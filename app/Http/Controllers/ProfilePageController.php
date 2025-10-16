<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilePageController extends ApiController
{
   public function index(Request $request)
{
    $token = session('api_token');
    $response = $this->get('/api/profile', $token);

    if ($response->failed()) {
        dd('API failed', $response->status(), $response->body(), $token);
    }

    $user = $response->json();
    return view('Profile.profile', compact('user'));
}

public function edit(Request $request)
{
    $token = session('api_token');
    $response = $this->get('/api/profile', $token);

    if ($response->failed()) {
        return redirect()->route('profile')->withErrors(['error' => 'Unable to fetch profile data.']);
    }

    $user = $response->json();
    return view('Profile.edit', compact('user')); // create profile_edit.blade.php if not yet
}


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
        ]);

        $token = session('api_token');
        $response = $this->put('/api/profile', [
            'name' => $request->name,
            'username' => $request->username,
        ], $token);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to update profile.']);
        }

        $data = $response->json();
        session(['user' => $data['user']]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // Add a PUT helper to ApiController if not present
}
