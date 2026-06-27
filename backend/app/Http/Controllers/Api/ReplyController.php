<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReplyController extends Controller
{
    public function index(Request $request, Ticket $ticket)
    {
        $query = $ticket->replies()
            ->with('user:id,name,email');

        if ($request->user()->role === 'customer') {
            $query->where('type', 'reply');
        }

        return $query->orderBy('created_at', 'asc')->get();
    }

    public function store(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'body' => ['required', 'string'],
            'type' => ['sometimes', Rule::in(['reply', 'note'])],
        ]);

        $type = $data['type'] ?? 'reply';

        // Customers can only post replies, never notes
        if ($request->user()->role === 'customer') {
            $type = 'reply';
        }

        $reply = $ticket->replies()->create([
            'user_id' => $request->user()->id,
            'body' => $data['body'],
            'type' => $type,
        ]);

        return response()->json(
            $reply->load('user:id,name,email'),
            201
        );
    }
}
