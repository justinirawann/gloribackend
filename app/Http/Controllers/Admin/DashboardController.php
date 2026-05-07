<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Category;
use App\Models\User;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'portfolios' => Portfolio::count(),
            'categories' => Category::count(),
            'users' => User::count(),
            'messages' => ContactMessage::count(),
            'recent_portfolios' => Portfolio::latest()->take(5)->get(),
            'recent_messages' => ContactMessage::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}