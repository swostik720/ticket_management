<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tickets = Ticket::with(['department', 'user', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $ticketCounts = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'escalated' => Ticket::where('status', 'escalated')->count(),
            'not_resolved' => Ticket::where('status', 'not_resolved')->count(),
        ];

        return view('admin.dashboard', compact('tickets', 'ticketCounts'));
    }

    public function showTicket($id)
    {
        $ticket = Ticket::with(['department', 'user', 'assignedTo'])->findOrFail($id);
        $staffMembers = User::where('role', 'staff')->get();

        return view('admin.ticket-show', compact('ticket', 'staffMembers'));
    }

    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    public function departments()
    {
        $departments = Department::withCount('tickets')->paginate(10);
        return view('admin.departments', compact('departments'));
    }

    public function createDepartment()
    {
        return view('admin.department-create');
    }

    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'description' => 'nullable|string',
        ]);

        Department::create($validated);

        return redirect()->route('admin.departments')
            ->with('success', 'Department created successfully.');
    }

    public function updateUserRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,staff,user',
        ]);

        $user = User::findOrFail($id);
        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('admin.users')
            ->with('success', 'User role updated successfully.');
    }
}
