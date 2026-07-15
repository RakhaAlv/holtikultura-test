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
    <div class="flex min-h-screen">

        <!-- ================= LEFT SIDE ================= -->
        <div class="relative w-1/2 bg-white">

        <!-- Bagian atas  -->
         <div class="flex flex-col items-center pt-20">

         <!-- Judul -->

            <h1 class="text-center text-[44px] font-bold uppercase leading-tight text-black">
                 Direktorat Jenderal<br>
                 Hortikultura
            </h1>
            
        <!-- Logo  -->
            <img
                src="{{ asset('logo-kementrian-pertanian.png') }}"
                alt="Logo Kementrian Pertanian"
                class="mx-auto mt-20 w-44">

        </div>  

        <!-- Ilustrasi -->
            <img
                src="{{ asset('ilustrasi-petani-login.png') }}"
                alt="Ilustrasi Login Page"
                class="absolute bottom-0 -right-25 w-[1100px] max-w-none opacity-80">

        </div>

        <!-- ================= RIGHT SIDE ================= -->
        <div class="relative z-10 w-1/2 bg-green-700 rounded-l-[40px] overflow-hidden shadow-[0_0_40px_rgba(0,0,0,0.18)]">

            <!-- Dekorasi Lingkarn Login Page -->
                <div class="absolute -right-24 -bottom-24 h-64 w-64 rounded-full border-[25px] border-green-500 opacity-40"></div>

                <div class="absolute -right-10 -bottom-10 h-40 w-40 rounded-full border-[18px] border-green-400 opacity-30"></div>

            <!-- Container Isi -->
            <div class="flex flex-col items-center pt-28">

                <!-- Judul -->
                <h1 class="text-center text-white text-2xl font-bold uppercase leading-tight">
                    Sistem Informasi <br>
                    Pemantauan Komoditas
                </h1>

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
                    <form class="mt-8">

                        <!-- Email -->
                        <div>
                            <input
                                type="email"
                                placeholder="Email Address"
                                class="w-full rounded-full border border-gray-300 px-6 py-4 outline-none focus:border-green-700 focus:ring-2 focus:ring-green-700"
                            >
                        </div>

                        <!-- Password -->
                        <div class="mt-5">
                            <input
                                type="password"
                                placeholder="Password"
                                class="mt-5 w-full rounded-full border border-gray-300 px-6 py-4 text-sm outline-none transition focus:border-green-700 focus:ring-2 focus:ring-green-700"
                            >
                        </div>

                        <!-- Remember Me -->
                        <div class="mt-5 flex items-center">
                            <input
                                id="remember"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-green-700 focus:ring-green-700"
                            >
                            <label for="remember" class="ml-2 text-sm text-gray-600">
                                Remember me
                            </label>
                        </div>
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