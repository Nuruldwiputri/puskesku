<x-guest-layout>
     {{-- Judul Halaman Register (ditambahkan untuk estetika tema) --}}
     <div class="text-center mb-8">
         <h1 class="text-3xl font-extrabold text-blue-800 tracking-tight leading-tight">
             <i class="fas fa-user-plus text-blue-500 mr-3"></i> {{ __('Daftar Akun Baru') }}
         </h1>
         <p class="text-gray-600 mt-2 text-lg">{{ __('Buat akun pasien Anda sekarang') }}</p>
     </div>

     <form method="POST" action="{{ route('register') }}" class="p-8 bg-white rounded-lg shadow-xl border-t-4 border-blue-500">
         @csrf

         <div class="mb-4">
             <x-input-label for="name" :value="__('Nama Lengkap')" class="text-blue-700 font-medium mb-2" />
             <x-text-input id="name" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
             <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
         </div>

         <div class="mt-4 mb-4">
             <x-input-label for="email" :value="__('Email')" class="text-blue-700 font-medium mb-2" />
             <x-text-input id="email" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Masukkan alamat email Anda" />
             <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
         </div>

         <div class="mt-4 mb-4">
             <x-input-label for="password" :value="__('Password')" class="text-blue-700 font-medium mb-2" />
             <x-text-input id="password" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5"
                             type="password"
                             name="password"
                             required autocomplete="new-password" placeholder="Buat password Anda" />
             <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
         </div>

         <div class="mt-4 mb-6">
             <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-blue-700 font-medium mb-2" />
             <x-text-input id="password_confirmation" class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5"
                             type="password"
                             name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi password Anda" />
             <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
         </div>

         <div class="flex items-center justify-between mt-6">
             <a class="underline text-sm text-blue-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200" href="{{ route('login') }}">
                 {{ __('Sudah terdaftar?') }}
             </a>

             <x-primary-button class="ms-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold pl-3 pr-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                 <i class="fas fa-user-plus mr-2"></i> {{ __('Daftar') }}
             </x-primary-button>
         </div>
     </form>
 </x-guest-layout>
 <script>
     // Optional: Add Font Awesome for icons (if not already included)
     // You can include it in your layout's head section like this:
     // <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 </script>