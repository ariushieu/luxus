<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Booking;
use App\Models\Quote;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('is_active', true)->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'pending_quotes' => Quote::where('status', 'pending')->count(),
            'total_categories' => Category::count(),
        ];

        $recentBookings = Booking::latest()->limit(3)->get();
        $recentQuotes = Quote::latest()->limit(3)->get();
        $recentProjects = Project::with('category')->latest()->limit(3)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentQuotes', 'recentProjects'));
    }
}
