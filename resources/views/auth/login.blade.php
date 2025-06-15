<x-guest-layout>
     {{-- Judul Halaman Login (ditambahkan untuk estetika tema) --}}
     <div class="text-center mb-8">
         <h1 class="text-3xl font-extrabold text-blue-800 tracking-tight leading-tight">
             <i class="fas fa-sign-in-alt text-blue-500 mr-3"></i> {{ __('Selamat Datang') }}
         </h1>
         <p class="text-gray-600 mt-2 text-lg">{{ __('Masuk ke akun Anda untuk melanjutkan') }}</p>
     </div>

     {{-- Session Status --}}
     <x-auth-session-status class="mb-4" :status="session('status')" />

     <form method="POST" action="{{ route('login') }}" class="p-8 bg-white rounded-lg shadow-xl border-t-4 border-blue-500">
         @csrf

         <div class="mb-4">
             <x-input-label for="email" :value="__('Email')" class="text-blue-700 font-medium mb-2" />
             <x-text-input id="email" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan alamat email Anda" />
             <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
         </div>

         <div class="mt-4 mb-6">
             <x-input-label for="password" :value="__('Password')" class="text-blue-700 font-medium mb-2" />
             <x-text-input id="password" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5"
                             type="password"
                             name="password"
                             required autocomplete="current-password" placeholder="Masukkan password Anda" />
             <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
         </div>

         <div class="block mt-4">
             <label for="remember_me" class="inline-flex items-center">
                 <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                 <span class="ms-2 text-sm text-gray-700">{{ __('Ingat saya') }}</span>
             </label>
         </div>

         <div class="flex items-center justify-between mt-6">
             @if (Route::has('password.request'))
                 <a class="underline text-sm text-blue-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200" href="{{ route('password.request') }}">
                     {{ __('Lupa password Anda?') }}
                 </a>
             @endif

             <x-primary-button class="ms-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold pl-3 pr-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                 <i class="fas fa-arrow-right-to-bracket mr-2"></i> {{ __('Masuk') }}
             </x-primary-button>
         </div>
     </form>
 </x-guest-layout>
 <script>
     // Optional: Add Font Awesome for icons (if not already included)
     // You can include it in your layout's head section like this:
     // <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 </script>