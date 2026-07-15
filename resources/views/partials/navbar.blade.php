<div class="h-20 bg-white shadow flex items-center justify-between px-6">
    <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
            Logout
        </button>
    </form>
</div>