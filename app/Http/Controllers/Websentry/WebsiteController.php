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

    // KAN-1-task-9: Show a single website with its monitoring logs
    public function show($id)
    {
        $website = Website::with(['client', 'monitoringLogs' => function ($q) {
            $q->orderBy('id', 'DESC')->limit(50);
        }])->findOrFail($id);

        return Inertia::render('websentry/Websites/Show', [
            'website' => $website,
        ]);
    }

    // KAN-1-task-10: Update a website
    public function update(Request $request, $id)
    {
        $website = Website::findOrFail($id);

        $validated = $request->validate([
            'url'            => 'sometimes|url|max:255',
            'name'           => 'sometimes|string|max:255',
            'active'         => 'sometimes|boolean',
            'check_interval' => 'sometimes|integer|min:1',
        ]);

        $website->update($validated);

        return redirect()->route('websites.index')->with('success', 'Website updated successfully.');
    }

    // KAN-1-task-11: Delete a website (soft delete)
    public function destroy($id)
    {
        $website = Website::findOrFail($id);
        $website->delete();

        return redirect()->route('websites.index')->with('success', 'Website removed successfully.');
    }
}
