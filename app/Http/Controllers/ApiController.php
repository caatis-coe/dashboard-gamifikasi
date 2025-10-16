<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        // Read from config/services.php
        $this->apiBaseUrl = config('services.api.base_url');
    }

    /**
     * Helper to make a POST request easily.
     */
    protected function post($endpoint, $data = [], $token = null)
    {
        $request = Http::withHeaders([
            'Accept' => 'application/json',
        ]);

        if ($token) {
            $request->withToken($token);
        }

        return $request->post("{$this->apiBaseUrl}{$endpoint}", $data);
    }

    /**
     * Helper to make a GET request easily.
     */
    protected function get($endpoint, $token = null)
    {
        $request = Http::withHeaders([
            'Accept' => 'application/json',
        ]);

        if ($token) {
            $request->withToken($token);
        }

        return $request->get("{$this->apiBaseUrl}{$endpoint}");
    }

    /**
     * Helper to make a PUT request easily.
     */
    protected function put($endpoint, $data = [], $token = null)
    {
        $request = Http::withHeaders([
            'Accept' => 'application/json',
        ]);

        if ($token) {
            $request->withToken($token);
        }

        return $request->put("{$this->apiBaseUrl}{$endpoint}", $data);
    }

    protected function delete($endpoint, $token = null)
{
    $request = Http::withHeaders(['Accept' => 'application/json']);

    if ($token) {
        $request->withToken($token);
    }

    return $request->delete("{$this->apiBaseUrl}{$endpoint}");
}

}
