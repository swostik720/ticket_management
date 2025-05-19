<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function create()
    {
        $departments = Department::all();
        return view('tickets.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'urgency' => 'required|in:low,medium,high,critical',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'department_id' => $request->department_id,
            'urgency' => $request->urgency,
            'attachment' => $attachmentPath,
            'user_id' => Auth::id(),
            'status' => 'open',
        ]);

        return redirect()->route('user.tickets.show', $ticket->id)
            ->with('success', 'Ticket created successfully.');
    }

    public function show($id)
    {
        $ticket = Ticket::with(['department', 'user', 'assignedTo'])->findOrFail($id);

        // Check if user has permission to view this ticket
        if (Auth::user()->isUser() && $ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $staffMembers = [];
        if (Auth::user()->isAdmin()) {
            $staffMembers = User::where('role', 'staff')->get();
        }

        return view('tickets.show', compact('ticket', 'staffMembers'));
    }

    public function assign(Request $request, $id)
    {
        // Only admin can assign tickets
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'assigned_to' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ticket = Ticket::findOrFail($id);
        $ticket->assigned_to = $request->assigned_to;
        $ticket->status = 'in_progress';
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket assigned successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        // Only staff can update ticket status
        if (!Auth::user()->isStaff()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:closed,escalated,not_resolved',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ticket = Ticket::findOrFail($id);

        // Check if this ticket is assigned to the current staff
        if ($ticket->assigned_to !== Auth::id()) {
            abort(403, 'You are not assigned to this ticket.');
        }

        $ticket->status = $request->status;
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket status updated successfully.');
    }
}
