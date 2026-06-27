<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        return Ticket::with(['requester', 'assignee'])
            ->paginate(15);
    }

    public function show(Request $request, Ticket $ticket)
    {
        return $ticket->load(['requester', 'assignee', 'organization']);
    }
}
