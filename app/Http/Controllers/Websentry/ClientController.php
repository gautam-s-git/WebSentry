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
}
