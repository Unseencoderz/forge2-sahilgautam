<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::query()
            ->with([
                'requester:id,name,email',
                'assignee:id,name,email',
            ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('assignee_id')) {
            $query->where('assignee_id', $request->assignee_id);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['sometimes', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'tags' => ['sometimes', 'array', 'nullable'],
        ]);

        $ticket = Ticket::create([
            'organization_id' => $request->user()->organization_id,
            'requester_id' => $request->user()->id,
            'subject' => $data['subject'],
            'description' => $data['description'],
            'status' => 'open',
            'priority' => $data['priority'] ?? 'medium',
            'assignee_id' => null,
            'tags' => $data['tags'] ?? null,
        ]);

        return response()->json($ticket, 201);
    }

    public function show(Request $request, Ticket $ticket)
    {
        return $ticket->load([
            'requester:id,name,email',
            'assignee:id,name,email',
            'replies.user:id,name,email',
        ]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'subject' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'status' => ['sometimes', Rule::in(['open', 'pending', 'resolved', 'closed'])],
            'priority' => ['sometimes', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'assignee_id' => ['sometimes', 'nullable', 'exists:users,id'],
            'tags' => ['sometimes', 'array', 'nullable'],
        ]);

        $ticket->update($data);

        return response()->json($ticket);
    }

    public function destroy(Request $request, Ticket $ticket)
    {
        $ticket->delete();

        return response()->json(null, 204);
    }
}
