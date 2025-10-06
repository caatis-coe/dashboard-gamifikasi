<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends ApiController
{
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // ✅ Now we can just call $this->post() instead of Http::post()
        $response = $this->post('/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        $data = $response->json();

        if (!isset($data['token'])) {
            return back()->withErrors(['email' => 'Login failed — API did not return a token.']);
        }

        session([
            'api_token' => $data['token'],
            'user' => $data['user'],
        ]);

        return redirect('/dashboard');
    }

    public function logout()
    {
        session()->forget(['api_token', 'user']);
        return redirect('/login');
    }
}
