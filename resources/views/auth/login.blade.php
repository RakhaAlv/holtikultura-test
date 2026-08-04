<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])

    <title>Login</title>
</head>

<body class="bg-white-100 font-['Poppins']">

    <!-- Container Utama -->
<div class="flex min-h-screen overflow-hidden">

<!-- ================= LEFT SIDE ================= -->
<div class="relative w-1/2 bg-white">

    <!-- Logo + Tulisan -->
    <div class="absolute top-12 left-12 z-20 flex items-center gap-5">
        <img
            src="{{ asset('logo-kementrian-pertanian.png') }}"
            alt="Logo Kementerian Pertanian"
            class="w-14 h-14 object-contain"
        >

        <div>
            <h1 class="text-[22px] font-bold uppercase leading-tight text-gray-900">
                Direktorat Jenderal
            </h1>
            <h1 class="text-[22px] font-bold uppercase leading-tight text-gray-900">
                Hortikultura
            </h1>
        </div>
    </div>

<!-- Logo SIMERAH -->
<div class="relative z-10 flex flex-col items-center pt-56">
    <img
        src="{{ asset('Logo-SIMERAH.png') }}"
        alt="Logo SIMERAH"
        class="w-[450px]"
    >

    <p class="mt-4 text-left text-[18px] font-semibold uppercase tracking-wide text-gray-500 leading-relaxed">
        Sistem Informasi Monitoring dan Evaluasi <br>
        Realisasi Hortikultura
    </p>
</div>

    <!-- Background -->
    <img
    src="{{ asset('ilustrasi-petani-login.png') }}"
    class="absolute -bottom-10 -right-52 w-[1000px] max-w-none"
>

</div>

        <!-- ================= RIGHT SIDE ================= -->
        <div class="relative z-10 w-1/2 bg-green-700 rounded-l-[40px] overflow-hidden shadow-[0_0_40px_rgba(0,0,0,0.18)]">

            <!-- Dekorasi Lingkarn Login Page -->
                <div class="absolute -right-24 -bottom-24 h-64 w-64 rounded-full border-[25px] border-green-500 opacity-40"></div>

                <div class="absolute -right-10 -bottom-10 h-40 w-40 rounded-full border-[18px] border-green-400 opacity-30"></div>

            <!-- Container Isi -->
            <div class="flex flex-col items-center pt-24">


                <!-- Login Card -->
                <div class="mt-12 w-[430px] rounded-[32px] bg-white p-12 shadow-2xl">

                    <!-- Heading -->
                    <h2 class="text-[40px] font-bold text-gray-900">
                        Hello!
                    </h2>

                    <p class="mt-2 text-gray-500 text-sm">
                        Sign In to get started
                    </p>

                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}" class="mt-8">
                        @csrf

                        <!-- Email -->
                        <div>
                            <input
                                type="email"
                                name="email"
                                placeholder="Email Address"
                                class="w-full rounded-full border border-gray-300 px-6 py-4 outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                        </div>

                        <!-- Password -->
                        <div class="mt-5">
                            <input
                                type="password"
                                name="password"
                                placeholder="Password"
                                class="mt-5 w-full rounded-full border border-gray-300 px-6 py-4 text-sm outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700"
                                required
                            >
                        </div>

                        <!-- Remember Me -->
                        <div class="mt-5 flex items-center">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-green-700 focus:ring-green-700"
                            >
                            <label for="remember" class="ml-2 text-sm text-gray-600">
                                Remember me
                            </label>
                        </div>

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- Button -->
                        <button
                            type="submit"
                            class="mt-10 h-14 w-full rounded-full bg-[#2E7D32] text-lg font-semibold text-white transition hover:bg-green-800"
                        >
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>
</html>