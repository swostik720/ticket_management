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
        // Staff can only create tickets for their own department and branch
        $user = Auth::user();
        $department = $user->department;
        $branch = $user->branch;

        if (!$department || !$branch) {
            return redirect()->back()->with('error', 'You must be assigned to a department and branch to create tickets.');
        }

        return view('tickets.create', compact('department', 'branch'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
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
            'department_id' => $user->department_id,
            'branch_id' => $user->branch_id,
            'urgency' => $request->urgency,
            'attachment' => $attachmentPath,
            'user_id' => Auth::id(),
            'status' => 'open',
        ]);

        return redirect()->route('staff.tickets.show', $ticket->id)
            ->with('success', 'Ticket created successfully.');
    }

    public function show($id)
    {
        $ticket = Ticket::with(['department', 'user', 'assignedTo', 'branch'])->findOrFail($id);

        $user = Auth::user();
        $headOfficeStaff = [];

        if ($user->canAssignTickets()) {
            $headOfficeStaff = User::where('role', 'head_office_staff')->get();
        }

        return view('tickets.show', compact('ticket', 'headOfficeStaff'));
    }

    public function assign(Request $request, $id)
    {
        // Only admin or head of department can assign tickets
        $user = Auth::user();
        if (!$user->canAssignTickets()) {
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
        // Only head office staff can update ticket status
        if (!Auth::user()->isHeadOfficeStaff()) {
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
