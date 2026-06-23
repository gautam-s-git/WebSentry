<?php

namespace App\Http\Controllers\Websentry;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Website;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WebsiteController extends Controller
{
    // KAN-1-task-7: List all websites
    public function index()
    {
        $websites = Website::with('client')->orderBy('id', 'DESC')->get();

        return Inertia::render('websentry/Websites/Index', [
            'websites' => $websites,
        ]);
    }

    // KAN-1-task-8: Create a new website
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'      => 'required|exists:users,id',
            'url'            => 'required|url|max:255',
            'name'           => 'required|string|max:255',
            'active'         => 'boolean',
            'check_interval' => 'integer|min:1',
        ]);

        $validated['active'] = $validated['active'] ?? true;
        $validated['check_interval'] = $validated['check_interval'] ?? 15;

        $website = Website::create($validated);

        return redirect()->route('websites.index')->with('success', 'Website added successfully.');
    }
}
