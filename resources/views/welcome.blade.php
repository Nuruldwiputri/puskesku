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
                 background-image: url('https://i.pinimg.com/736x/46/9c/c7/469cc762e00c93d423596115dea8750e.jpg'); /* Replace with your doctor's photo URL */
                 background-size: cover;
                 background-position: center;
                 background-attachment: fixed; /* Makes the background fixed while scrolling */
                 position: relative; /* Needed for pseudo-element positioning */
                 overflow-y: auto; /* Ensure scrolling works if content is long */
             }

             /* Overlay for better text readability */
             body::before {
                 content: "";
                 position: absolute;
                 top: 0;
                 left: 0;
                 right: 0;
                 bottom: 0;
                 background-color: rgba(0, 50, 100, 0.7); /* Dark blue overlay with 70% opacity */
                 z-index: -1; /* Place behind content but above background image */
             }

             /* Ensure content is above the overlay */
             header, .main-welcome-content, .join-now-button-container {
                 position: relative;
                 z-index: 1;
             }
         </style>
     </head>
     <body class="text-white flex flex-col items-center justify-between min-h-screen font-sans p-6 lg:p-8">
         <header class="w-full lg:max-w-7xl mx-auto text-sm mb-6">
             <div class="flex justify-between items-center h-16"> {{-- Tambahkan h-16 untuk tinggi konsisten --}}
                 {{-- Logo Puskesmas di Kiri Atas --}}
                 <div class="flex-shrink-0 flex items-center">
                     <a href="{{ url('/') }}"> {{-- Mengarahkan ke root URL --}}
                         <img src="{{ asset('images/logopuskeskupanjangnobg2.png') }}" alt="{{ config('app.name') }}" class="h-12 w-auto"> {{-- Sesuaikan h-12 jika perlu --}}
                     </a>
                 </div>

                 {{-- Tombol Login/Daftar di Kanan Atas --}}
                 <nav class="flex items-center gap-4">
                     @auth
                         <a
                             href="{{ url('/dashboard') }}"
                             class="inline-block px-5 py-1.5 border border-white text-white hover:bg-white hover:text-blue-800 rounded-md text-sm leading-normal transition ease-in-out duration-150 shadow-md"
                         >
                             <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                         </a>
                     @else
                         <a
                             href="{{ route('login') }}"
                             class="inline-block px-5 py-1.5 bg-white text-blue-800 font-semibold hover:bg-blue-100 hover:text-blue-900 rounded-md text-sm leading-normal shadow-md transition ease-in-out duration-150"
                         >
                             <i class="fas fa-sign-in-alt mr-1"></i> {{ __('Masuk') }}
                         </a>

                         @if (Route::has('register'))
                             <a
                                 href="{{ route('register') }}"
                                 class="inline-block px-5 py-1.5 border border-white text-white hover:bg-white hover:text-blue-800 font-semibold rounded-md text-sm leading-normal shadow-sm transition ease-in-out duration-150">
                                 <i class="fas fa-user-plus mr-1"></i> {{ __('Daftar') }}
                             </a>
                         @endif
                     @endauth
                 </nav>
             </div>
         </header>

         {{-- Main Welcome Content --}}
         <div class="main-welcome-content flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8 flex-grow">
             <h1 class="text-white text-5xl sm:text-6xl lg:text-7xl font-extrabold leading-tight tracking-tight mb-4 drop-shadow-lg">
                 Welcome to <br><span class="text-blue-300">Puskesku Online</span>
             </h1>
             <p class="text-white text-xl sm:text-2xl max-w-2xl drop-shadow-md">
                 Layanan kesehatan Puskesmas kini dalam genggaman Anda.
                 Buat janji, kelola riwayat, dan akses informasi dengan mudah.
             </p>
             <a href="{{ route('register') }}"
                class="mt-10 inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold rounded-full shadow-xl transition ease-in-out duration-200">
                 <i class="fas fa-user-plus mr-3"></i> Gabung Sekarang
             </a>
         </div>
         {{-- "Gabung Sekarang" button --}}
         <div class="join-now-button-container mt-auto mb-10">
             
         </div>

     </body>
 </html>