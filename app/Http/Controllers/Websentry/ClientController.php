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

    // KAN-1-task-4: Show a single client
    public function show($id)
    {
        $client = Client::withCount('website')->findOrFail($id);

        return Inertia::render('websentry/Clients/Show', [
            'client' => $client,
        ]);
    }

    // KAN-1-task-5: Update a client
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'name'   => 'sometimes|string|max:255',
            'email'  => 'sometimes|email|unique:users,email,' . $id,
            'active' => 'sometimes|boolean',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }
}
