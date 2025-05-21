<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Department;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserCredentials;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tickets = Ticket::with(['department', 'user', 'assignedTo', 'branch'])
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
        $ticket = Ticket::with(['department', 'user', 'assignedTo', 'branch'])->findOrFail($id);
        $headOfficeStaff = User::where('role', 'head_office_staff')->get();

        return view('admin.ticket-show', compact('ticket', 'headOfficeStaff'));
    }

    public function users()
    {
        $users = User::with(['department', 'branch'])->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        $departments = Department::all();
        $branches = Branch::all();
        return view('admin.user-create', compact('departments', 'branches'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,head_of_department,staff,head_office_staff',
            'department_id' => 'required_unless:role,admin|exists:departments,id|nullable',
            'branch_id' => 'required_unless:role,admin|exists:branches,id|nullable',
        ]);

        // Generate username with pattern pmlil + counter
        $latestUser = User::orderBy('id', 'desc')->first();
        $counter = $latestUser ? intval(substr($latestUser->username, 5)) + 1 : 1;
        $username = 'pmlil' . str_pad($counter, 5, '0', STR_PAD_LEFT);

        // Generate random password
        $password = Str::random(8);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'department_id' => $validated['department_id'] ?? null,
            'branch_id' => $validated['branch_id'] ?? null,
            'username' => $username,
            'password' => $password,
        ]);

        // Send email with credentials
        Mail::to($user->email)->send(new NewUserCredentials($user, $password));

        return redirect()->route('admin.users')
            ->with('success', "User created successfully. Credentials have been sent to {$user->email}");
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

    public function branches()
    {
        $branches = Branch::withCount('tickets')->paginate(10);
        return view('admin.branches', compact('branches'));
    }

    public function createBranch()
    {
        return view('admin.branch-create');
    }

    public function storeBranch(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:branches',
            'address' => 'nullable|string',
        ]);

        Branch::create($validated);

        return redirect()->route('admin.branches')
            ->with('success', 'Branch created successfully.');
    }

    public function updateUserRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,head_of_department,staff,head_office_staff',
        ]);

        $user = User::findOrFail($id);
        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('admin.users')
            ->with('success', 'User role updated successfully.');
    }
}
