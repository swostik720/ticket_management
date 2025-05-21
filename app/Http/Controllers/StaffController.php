<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $tickets = Ticket::with(['department', 'user', 'branch'])
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

        return view('staff.dashboard', compact('tickets', 'ticketCounts', 'user'));
    }

    public function showTicket($id)
    {
        $ticket = Ticket::with(['department', 'user', 'assignedTo', 'branch'])->findOrFail($id);

        // Check if this ticket belongs to the current staff
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('staff.ticket-show', compact('ticket'));
    }
}
