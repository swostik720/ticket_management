<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeadOfficeController extends Controller
{
    public function dashboard()
    {
        $tickets = Ticket::with(['department', 'user', 'branch'])
            ->where(function($query) {
                $query->where('assigned_to', Auth::id())
                      ->orWhere('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $ticketCounts = [
            'total' => Ticket::where(function($query) {
                $query->where('assigned_to', Auth::id())
                      ->orWhere('user_id', Auth::id());
            })->count(),
            'in_progress' => Ticket::where('assigned_to', Auth::id())->where('status', 'in_progress')->count(),
            'closed' => Ticket::where('assigned_to', Auth::id())->where('status', 'closed')->count(),
            'escalated' => Ticket::where('assigned_to', Auth::id())->where('status', 'escalated')->count(),
            'not_resolved' => Ticket::where('assigned_to', Auth::id())->where('status', 'not_resolved')->count(),
            'created' => Ticket::where('user_id', Auth::id())->count(),
        ];

        return view('head_office.dashboard', compact('tickets', 'ticketCounts'));
    }

    public function showTicket($id)
    {
        $ticket = Ticket::with(['department', 'user', 'branch'])->findOrFail($id);

        // Check if this ticket is assigned to the current head office staff or created by them
        if ($ticket->assigned_to !== Auth::id() && $ticket->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to view this ticket.');
        }

        return view('head_office.ticket-show', compact('ticket'));
    }

    public function createTicket()
    {
        $user = Auth::user();
        $department = $user->department;
        $branch = $user->branch;

        if (!$department || !$branch) {
            return redirect()->back()->with('error', 'You must be assigned to a department and branch to create tickets.');
        }

        return view('head_office.ticket-create', compact('department', 'branch'));
    }

    public function storeTicket(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'urgency' => 'required|in:low,medium,high,critical',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $ticket = Ticket::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'department_id' => $user->department_id,
            'branch_id' => $user->branch_id,
            'urgency' => $validated['urgency'],
            'attachment' => $attachmentPath,
            'user_id' => Auth::id(),
            'status' => 'open',
        ]);

        if (!$ticket) {
            return redirect()->back()->with('error', 'Failed to create ticket. Please try again.');
        }

        return redirect()->route('head_office.tickets.show', $ticket->id)
            ->with('success', 'Ticket created successfully.');
    }
}
