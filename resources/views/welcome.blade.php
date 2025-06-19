<!DOCTYPE html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
     <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">

         <title>{{ config('app.name', 'Puskesmas Online') }}</title>

         <link rel="preconnect" href="https://fonts.bunny.net">
         <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

         <!-- Font Awesome for Icons -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

         @vite(['resources/css/app.css', 'resources/js/app.js'])

         <style>
             /* Custom CSS for background image and overlay */
             body {
                 /* Menggunakan gradien biru terang sebagai pengganti gambar, mirip referensi */
                 background: linear-gradient(135deg, #e0f2fe 0%, #bfdbfe 50%, #90cdf4 100%); /* Light blue to brighter blue gradient */
                 background-size: cover; /* Penting untuk ukuran gradien */
                 background-position: center;
                 background-attachment: fixed;
                 position: relative;
                 overflow-y: auto;
                 min-height: 100vh;
                 margin: 0;
             }

             /* Overlay lebih tipis atau disesuaikan untuk kontras yang lebih baik */
             body::before {
                 content: "";
                 position: absolute;
                 top: 0;
                 left: 0;
                 right: 0;
                 bottom: 0;
                 /* Gradien overlay yang lebih halus atau transparan */
                 background: linear-gradient(to bottom, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05)); /* Sangat tipis, hampir transparan */
                 z-index: -1;
             }

             /* Ensure content is above the overlay */
             header, .main-welcome-content, .join-now-button-container {
                 position: relative;
                 z-index: 1;
             }
         </style>
     </head>
     <body class="text-gray-800 flex flex-col items-center justify-between min-h-screen font-sans p-6 lg:p-8">
         <header class="w-full lg:max-w-7xl mx-auto text-sm mb-6">
             <div class="flex justify-between items-center h-16">
                 {{-- Logo Puskesmas di Kiri Atas (Tetap) --}}
                 <div class="flex-shrink-0 flex items-center">
                     <a href="{{ url('/') }}">
                         <img src="{{ asset('images/logopuskeskupanjangnobg2.png') }}" alt="{{ config('app.name') }}" class="h-12 w-auto">
                     </a>
                 </div>

                 {{-- Tombol Login/Daftar di Kanan Atas (DIPERBESAR) --}}
                 <nav class="flex items-center gap-4">
                     @auth
                         <a
                             href="{{ url('/dashboard') }}"
                             class="inline-block px-6 py-2 border border-blue-500 text-blue-700 hover:bg-blue-100 hover:text-blue-900 rounded-md text-base leading-normal transition ease-in-out duration-150 shadow-md"
                         >
                             <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                         </a>
                     @else
                         <a
                             href="{{ route('login') }}"
                             class="inline-block px-6 py-2 bg-blue-500 text-white font-semibold hover:bg-blue-600 rounded-full text-base leading-normal transition ease-in-out duration-150 shadow-md"
                         >
                             <i class="fas fa-sign-in-alt mr-1"></i> {{ __('Masuk') }}
                         </a>

                         @if (Route::has('register'))
                             <a
                                 href="{{ route('register') }}"
                                 class="inline-block px-6 py-2 border-2 border-blue-500 text-blue-700 font-semibold hover:bg-blue-50 rounded-full text-base leading-normal transition ease-in-out duration-150 shadow-sm">
                                 <i class="fas fa-user-plus mr-1"></i> {{ __('Daftar') }}
                             </a>
                         @endif
                     @endauth
                 </nav>
             </div>
         </header>

         {{-- Main Welcome Content --}}
         <div class="main-welcome-content flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8 flex-grow">
             {{-- Teks H1 dan P tetap sama --}}
             <h1 class="text-blue-800 text-5xl sm:text-6xl lg:text-7xl font-extrabold leading-tight tracking-tight mb-4 drop-shadow-lg">
                 Welcome to <br><span class="text-blue-600">Puskesku Online</span>
             </h1>
             <p class="text-gray-700 text-xl sm:text-2xl max-w-2xl drop-shadow-md opacity-90">
                 Layanan kesehatan Puskesmas kini dalam genggaman Anda.
                 Buat janji, kelola riwayat, dan akses informasi dengan mudah.
             </p>

             {{-- Tombol Gabung Sekarang (DIKECILKAN SEDIKIT) --}}
             <a href="{{ route('register') }}"
                class="mt-10 inline-flex items-center px-6 py-3 bg-blue-600 text-white border-2 border-blue-600 rounded-full font-bold text-lg uppercase tracking-wider hover:bg-blue-700 hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-300 shadow-lg transform hover:scale-105">
                 <i class="fas fa-user-plus mr-3"></i> Gabung Sekarang
             </a>
         </div>

         {{-- Tambahan untuk footer atau elemen lain di bawah (opsional) --}}
         <div class="w-full text-center mt-auto text-gray-600 text-opacity-70 text-sm">
             <p>&copy; {{ date('Y') }} Puskesmas Online Kelompok 3</p>
         </div>

     </body>
 </html>