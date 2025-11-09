<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPageController extends ApiController
{
    public function index()
{
    $token = session('api_token');
    $user = session('user');

    // get dashboard info
    $dashboardResponse = $this->get('/api/dashboard', $token);
    if ($dashboardResponse->failed()) {
        return back()->withErrors(['error' => 'Failed to load dashboard data.']);
    }

    $data = $dashboardResponse->json();
    $topUsers = $data['top_users'] ?? [];
    $activePeriod = $data['active_period'] ?? null;
    $activeTasks = $data['active_tasks'] ?? [];

    // 🧮 fetch completions and count those from active period
    $completionsResponse = $this->get('/api/completions', $token);
    $totalCompletions = 0;

    if ($completionsResponse->successful() && $activePeriod) {
        $completions = collect($completionsResponse->json());
        $totalCompletions = $completions->filter(function ($completion) use ($activePeriod) {
            $task = $completion['task'] ?? null;
            return $task && ($task['period_id'] ?? null) == $activePeriod['id'];
        })->count();
    }

    return view('dashboard', compact(
        'user', 
        'topUsers', 
        'activePeriod', 
        'activeTasks',
        'totalCompletions'
    ));
}

}
