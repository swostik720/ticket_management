<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $tickets = Ticket::with(['department', 'assignedTo'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $ticketCounts = [
            'total' => Ticket::where('user_id', Auth::id())->count(),
            'open' => Ticket::where('user_id', Auth::id())->where('status', 'open')->count(),
            'in_progress' => Ticket::where('user_id', Auth::id())->where('status', 'in_progress')->count(),
            'closed' => Ticket::where('user_id', Auth::id())->where('status', 'closed')->count(),
            'escalated' => Ticket::where('user_id', Auth::id())->where('status', 'escalated')->count(),
            'not_resolved' => Ticket::where('user_id', Auth::id())->where('status', 'not_resolved')->count(),
        ];

        return view('user.dashboard', compact('tickets', 'ticketCounts'));
    }

    public function showTicket($id)
    {
        $ticket = Ticket::with(['department', 'assignedTo'])->findOrFail($id);

        // Check if this ticket belongs to the current user
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.ticket-show', compact('ticket'));
    }
}
