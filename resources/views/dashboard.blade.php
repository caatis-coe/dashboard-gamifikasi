@extends('layouts.template')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ $user['name'] }}</h1>
        
        <p class="text-gray-600">You have successfully logged in.</p>
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit"
                class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200">
                Logout
            </button>
        </form>
    </div>
</div>
@endsection
