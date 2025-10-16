
@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Registered Users</h1>
                <a href="{{ route('users.create') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    + Add User
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            @if(isset($users) && count($users) > 0)
                <table class="w-full  rounded-lg overflow-hidden">
                    <thead class="bg-green-600 text-green-50">
                        <tr>
                            <th class="py-2 px-4 text-left">No</th>
                            <th class="py-2 px-4 text-left">Username</th>
                            <th class="py-2 px-4 text-left">Name</th>
                            <th class="py-2 px-4 text-left">Email</th>
                            <th class="py-2 px-4 text-left">Role</th>
                            <th class="py-2 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($users as $index => $user)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="py-2 px-4">{{ $index + 1 }}</td>
                                <td class="py-2 px-4">{{ $user['username'] ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $user['name'] ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $user['email'] ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $user['role'] ?? '-' }}</td>
                                <td class="py-2 px-4 text-center flex justify-center gap-2">
                                    <form action="{{ route('users.delete', $user['id']) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white rounded p-2"
                                            title="Delete">
                                            <!-- Heroicons Trash -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('users.edit', $user['id']) }}" method="GET">
                                        <button 
                                            type="submit" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white rounded p-2"
                                            title="Edit">
                                            <!-- Heroicons Pencil Square -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487a2.1 2.1 0 113.001 3.001L7.5 18.85l-4 1 1-4 12.362-12.363z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No users found.</p>
            @endif
        </div>
    </div>
</div>

@endsection