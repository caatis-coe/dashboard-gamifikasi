@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    

<div class="w-full min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ $user['name'] }}</h1>
        
        <p class="text-gray-600">You have successfully logged in.</p>
        
    </div>

</div>
@endsection
