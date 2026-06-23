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
}
