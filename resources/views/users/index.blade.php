@extends('layouts.app')

@section('title', 'User Management')

@section('content')

<div class="rounded-[28px] bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.08)]">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">
            User Management
        </h1>

        <a href="#"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
            + Tambah User
        </a>

    </div>

    <table class="w-full border border-gray-300">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-3">Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Direktorat</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

        @foreach($users as $user)

            <tr class="border-t">

                <td class="p-3">{{ $user->name }}</td>

                <td>{{ $user->email }}</td>

                <td>{{ $user->role->nama_role }}</td>

                <td>{{ $user->direktorat->nama_direktorat ?? '-' }}</td>

                <td>

                    <button class="bg-blue-500 text-white px-3 py-1 rounded">
                        Edit
                    </button>

                    <button class="bg-red-500 text-white px-3 py-1 rounded">
                        Hapus
                    </button>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection