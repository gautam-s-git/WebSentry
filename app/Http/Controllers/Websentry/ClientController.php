<?php

namespace App\Http\Controllers\Websentry;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    // KAN-1-task-2: List all clients
    public function index()
    {
        $clients = Client::withCount('website')->orderBy('id', 'DESC')->get();

        return Inertia::render('websentry/Clients/Index', [
            'clients' => $clients,
        ]);
    }

    // KAN-1-task-3: Create a new client
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'active'   => 'boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['active'] = $validated['active'] ?? true;

        $client = Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }
}
