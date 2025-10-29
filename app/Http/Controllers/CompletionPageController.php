<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator; // added

class CompletionPageController extends ApiController
{
    public function index(Request $request)
    {
       $token = session('api_token'); // make sure it exists

       $response = $this->get('/api/completions', $token);

       if ($response->failed()) {
           // return empty paginator on failure to avoid blade errors
           $all = [];
       } else {
           $all = $response->json() ?: [];
       }

       // paginate locally at 5 items per page
       $perPage = 5;
       $currentPage = $request->input('page', 1);
       $collection = collect($all);
       $currentItems = $collection->forPage($currentPage, $perPage)->values()->all();

       $completions = new LengthAwarePaginator(
           $currentItems,
           $collection->count(),
           $perPage,
           $currentPage,
           [
               'path' => url()->current(),
               'query' => $request->query(),
           ]
       );

       return view('Completions.index', compact('completions'));
    }

    public function create()
    {
        // Fetch tasks to show in the dropdown
        $token = session('api_token');
        $response = $this->get('/api/tasks?active_only=true', $token);
    $tasks = $response->successful() ? $response->json() : [];

        return view('Completions.create', compact('tasks'));
    }

    public function store(Request $request)
{
    $request->validate([
        'task_id' => 'required|integer',
        'status' => 'required|string',
        'proof_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $token = session('api_token');

    // Prepare multipart form data
    $multipart = [
        ['name' => 'task_id', 'contents' => $request->task_id],
        ['name' => 'status', 'contents' => $request->status],
    ];

    if ($request->hasFile('proof_image')) {
        $multipart[] = [
            'name' => 'proof_image',
            'contents' => fopen($request->file('proof_image')->getPathname(), 'r'),
            'filename' => $request->file('proof_image')->getClientOriginalName(),
        ];
    }

    // Send request directly to API
    $response = \Illuminate\Support\Facades\Http::withToken($token)
        ->asMultipart()
        ->post('http://127.0.0.1:8000/api/completions', $multipart);

    if ($response->failed()) {
        dd($response->json()); // Debug if needed
        return back()->withErrors(['error' => 'Failed to create completion.']);
    }

    return redirect()->route('completions.index')
        ->with('success', 'Completion created successfully.');
}


    public function edit($id)
    {
        $token = session('api_token');

        $completionResponse = $this->get("/api/completions/{$id}", $token);
        $tasksResponse = $this->get('/api/tasks', $token);

        if ($completionResponse->failed()) {
            return redirect()->route('completions.index')->withErrors(['error' => 'Failed to fetch completion.']);
        }

        $completion = $completionResponse->json();
        $tasks = $tasksResponse->successful() ? $tasksResponse->json() : [];

        return view('Completions.edit', compact('completion', 'tasks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'status' => 'required|string',
            'proof_url' => 'nullable|string',
            'completed_at' => 'nullable|date',
        ]);

        $token = session('api_token');
        $response = $this->put("/api/completions/{$id}", [
            'task_id' => $request->task_id,
            'status' => $request->status,
            'proof_url' => $request->proof_url,
            'completed_at' => $request->completed_at,
        ], $token);

        if ($response->failed()) {
    return back()->withErrors(['error' => 'Failed to create completion.']);
}


        return redirect()->route('completions.index')->with('success', 'Completion updated successfully.');
    }

    public function destroy($id)
    {
        $token = session('api_token');
        $response = $this->delete("/api/completions/{$id}", $token);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to delete completion.']);
        }

        return redirect()->route('completions.index')->with('success', 'Completion deleted successfully.');
    }
}
