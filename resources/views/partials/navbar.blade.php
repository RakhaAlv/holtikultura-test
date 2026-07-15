<div class="h-20 bg-white shadow flex items-center justify-between px-6">
    <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
    </form>
</div>