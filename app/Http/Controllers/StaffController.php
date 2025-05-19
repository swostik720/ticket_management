<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function dashboard()
    {
        $tickets = Ticket::with(['department', 'user'])
            ->where('assigned_to', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $ticketCounts = [
            'total' => Ticket::where('assigned_to', Auth::id())->count(),
            'in_progress' => Ticket::where('assigned_to', Auth::id())->where('status', 'in_progress')->count(),
            'closed' => Ticket::where('assigned_to', Auth::id())->where('status', 'closed')->count(),
            'escalated' => Ticket::where('assigned_to', Auth::id())->where('status', 'escalated')->count(),
            'not_resolved' => Ticket::where('assigned_to', Auth::id())->where('status', 'not_resolved')->count(),
        ];

        return view('staff.dashboard', compact('tickets', 'ticketCounts'));
    }

    public function showTicket($id)
    {
        $ticket = Ticket::with(['department', 'user'])->findOrFail($id);

        // Check if this ticket is assigned to the current staff
        if ($ticket->assigned_to !== Auth::id()) {
            abort(403, 'You are not assigned to this ticket.');
        }

        return view('staff.ticket-show', compact('ticket'));
    }
}
