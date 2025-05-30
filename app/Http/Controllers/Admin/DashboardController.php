<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users_count = User::count();
        $activities = ActivityLog::with('user')->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('users_count', 'activities'));
    }
}