<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


class ApiController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('services.api.base_url');
    }


    
    protected function post($endpoint, $data = [], $token = null)
    {
        $request = Http::withHeaders(['Accept' => 'application/json']);

        if ($token) {
            $request = $request->withToken($token);
        }

        return $request->post("{$this->apiBaseUrl}{$endpoint}", $data);
    }

    protected function get($endpoint, $token = null)
    {
        $request = Http::withHeaders(['Accept' => 'application/json']);

        if ($token) {
            $request = $request->withToken($token);
        }

        return $request->get("{$this->apiBaseUrl}{$endpoint}");
    }

    protected function put($endpoint, $data = [], $token = null)
    {
        $request = Http::withHeaders(['Accept' => 'application/json']);

        if ($token) {
            $request = $request->withToken($token);
        }

        return $request->put("{$this->apiBaseUrl}{$endpoint}", $data);
    }

    protected function delete($endpoint, $token = null)
    {
        $request = Http::withHeaders(['Accept' => 'application/json']);

        if ($token) {
            $request = $request->withToken($token);
        }

        return $request->delete("{$this->apiBaseUrl}{$endpoint}");
    }

    
}
