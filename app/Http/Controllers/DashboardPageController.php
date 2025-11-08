<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPageController extends ApiController
{
    public function index()
    {
        $token = session('api_token');
        $user = session('user');

        // call your dashboard API endpoint
        $response = $this->get('/api/dashboard', $token);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to load dashboard data.']);
        }

        

        $data = $response->json();

        $topUsers = $data['top_users'] ?? [];
        $activePeriod = $data['active_period'] ?? null;
        $activeTasks = $data['active_tasks'] ?? [];

        return view('dashboard', compact('user', 'topUsers', 'activePeriod', 'activeTasks'));
    }
}
