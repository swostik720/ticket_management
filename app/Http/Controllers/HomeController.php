<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['department', 'user', 'assignedTo', 'branch'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('welcome', compact('tickets'));
    }
}
