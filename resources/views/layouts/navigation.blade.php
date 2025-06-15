<nav x-data="{ open: false }" class="bg-blue-800 border-b border-blue-900 shadow-xl">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         <div class="flex justify-between h-16">
             <div class="flex">
                 {{-- Logo Aplikasi --}}
                 <div class="shrink-0 flex items-center">
                     <a href="{{ route('dashboard') }}">
                         <div class="flex items-center text-white text-2xl font-bold">
                             {{-- Logo Puskesmas Anda --}}
                             <img src="{{ asset('images/logo2puskesku.png') }}" alt="Puskesku Logo" class="h-10 w-10 mr-3 rounded-full"> {{-- Menambahkan logo --}}
                             Puskesku
                         </div>
                     </a>
                 </div>

                 {{-- Navigasi Desktop --}}
                 <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                     <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('pasien.dashboard')" class="text-white hover:text-blue-200 hover:bg-blue-700 pr-4 mr-1 border-b-2 border-transparent hover:border-blue-300 active:border-white active:bg-blue-700 transition duration-200 ease-in-out">
                         <i class="fas fa-home mr-2"></i> {{ __('Dashboard') }}
                     </x-nav-link>

                     @auth
                         {{-- Navigasi untuk Admin --}}
                         @if(Auth::user()->role === \App\Enums\UserRoleEnum::Admin->value)
                             <x-nav-link :href="route('admin.patients')" :active="request()->routeIs('admin.patients')" class="text-white hover:text-blue-200 hover:bg-blue-700 pr-4 mr-1 border-b-2 border-transparent hover:border-blue-300 active:border-white active:bg-blue-700 transition duration-200 ease-in-out">
                                 <i class="fas fa-hospital-user mr-2"></i> {{ __('Daftar Pasien') }}
                             </x-nav-link>
                             <x-nav-link :href="route('admin.doctors')" :active="request()->routeIs('admin.doctors') || request()->routeIs('admin.doctors.*')" class="text-white hover:text-blue-200 hover:bg-blue-700 pr-4 mr-1 border-b-2 border-transparent hover:border-blue-300 active:border-white active:bg-blue-700 transition duration-200 ease-in-out">
                                 <i class="fas fa-user-md mr-2"></i> {{ __('Kelola Dokter') }}
                             </x-nav-link>
                             <x-nav-link :href="route('admin.schedules')" :active="request()->routeIs('admin.schedules') || request()->routeIs('admin.schedules.*')" class="text-white hover:text-blue-200 hover:bg-blue-700 pr-4 mr-1 border-b-2 border-transparent hover:border-blue-300 active:border-white active:bg-blue-700 transition duration-200 ease-in-out">
                                 <i class="fas fa-calendar-alt mr-2"></i> {{ __('Kelola Jadwal') }}
                             </x-nav-link>
                             <x-nav-link :href="route('admin.appointments')" :active="request()->routeIs('admin.appointments') || request()->routeIs('admin.appointments.*')" class="text-white hover:text-blue-200 hover:bg-blue-700 pr-4 mr-1 border-b-2 border-transparent hover:border-blue-300 active:border-white active:bg-blue-700 transition duration-200 ease-in-out">
                                 <i class="fas fa-clipboard-list mr-2"></i> {{ __('Daftar Janji Temu') }}
                             </x-nav-link>
                         @endif

                         {{-- Navigasi untuk Pasien --}}
                         @if(Auth::user()->role === \App\Enums\UserRoleEnum::Pasien->value)
                             <x-nav-link :href="route('pasien.schedules')" :active="request()->routeIs('pasien.schedules')" class="text-white hover:text-blue-200 hover:bg-blue-700 pr-4 mr-1 border-b-2 border-transparent hover:border-blue-300 active:border-white active:bg-blue-700 transition duration-200 ease-in-out">
                                 <i class="fas fa-calendar-alt mr-2"></i> {{ __('Jadwal Dokter') }}
                             </x-nav-link>
                             <x-nav-link :href="route('pasien.appointments.create')" :active="request()->routeIs('pasien.appointments.create')" class="text-white hover:text-blue-200 hover:bg-blue-700 pr-4 mr-1 border-b-2 border-transparent hover:border-blue-300 active:border-white active:bg-blue-700 transition duration-200 ease-in-out">
                                 <i class="fas fa-calendar-plus mr-2"></i> {{ __('Buat Janji') }}
                             </x-nav-link>
                             <x-nav-link :href="route('pasien.history')" :active="request()->routeIs('pasien.history')" class="text-white hover:text-blue-200 hover:bg-blue-700 pr-4 mr-1 border-b-2 border-transparent hover:border-blue-300 active:border-white active:bg-blue-700 transition duration-200 ease-in-out">
                                 <i class="fas fa-history mr-2"></i> {{ __('Riwayat Janji') }}
                             </x-nav-link>
                             <x-nav-link :href="route('pasien.chatbot')" :active="request()->routeIs('pasien.chatbot')" class="text-white hover:text-blue-200 hover:bg-blue-700 pr-4 mr-1 border-b-2 border-transparent hover:border-blue-300 active:border-white active:bg-blue-700 transition duration-200 ease-in-out">
                                 <i class="fas fa-robot mr-2"></i> {{ __('Chatbot') }}
                             </x-nav-link>
                         @endif
                     @endauth
                 </div>
             </div>

             {{-- Dropdown Pengguna (Kanan Atas) --}}
             <div class="hidden sm:flex sm:items-center sm:ms-6">
                 <x-dropdown align="right" width="48">
                     <x-slot name="trigger">
                         <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-700 hover:bg-blue-600 focus:outline-none focus:bg-blue-600 transition ease-in-out duration-150 shadow-sm">
                             <div>{{ Auth::user()->name }}</div>

                             <div class="ms-1">
                                 <svg class="fill-current h-4 w-4 text-blue-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                     <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                 </svg>
                             </div>
                         </button>
                     </x-slot>

                     <x-slot name="content">
                         <x-dropdown-link :href="route('profile.edit')" class="text-gray-700 hover:bg-blue-50">
                             <i class="fas fa-user-circle mr-2 text-blue-500"></i> {{ __('Profile') }}
                         </x-dropdown-link>

                         <form method="POST" action="{{ route('logout') }}">
                             @csrf

                             <x-dropdown-link :href="route('logout')"
                                     onclick="event.preventDefault();
                                                 this.closest('form').submit();"
                                     class="text-red-600 hover:bg-red-100">
                                 <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                             </x-dropdown-link>
                         </form>
                     </x-slot>
                 </x-dropdown>
             </div>

             {{-- Tombol Hamburger (untuk Mobile) --}}
             <div class="-me-2 flex items-center sm:hidden">
                 <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 focus:text-white transition duration-150 ease-in-out">
                     <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                         <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                         <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                     </svg>
                 </button>
             </div>
         </div>
     </div>

     {{-- Navigasi Responsif (Mobile) --}}
     <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-800 pb-2">
         <div class="pt-2 pb-3 space-y-1">
             <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                 <i class="fas fa-home mr-2"></i> {{ __('Dashboard') }}
             </x-responsive-nav-link>

             @auth
                 {{-- Responsive Navigasi untuk Admin --}}
                 @if(Auth::user()->role === \App\Enums\UserRoleEnum::Admin->value)
                     <x-responsive-nav-link :href="route('admin.patients')" :active="request()->routeIs('admin.patients')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                         <i class="fas fa-hospital-user mr-2"></i> {{ __('Daftar Pasien') }}
                     </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('admin.doctors')" :active="request()->routeIs('admin.doctors') || request()->routeIs('admin.doctors.*')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                         <i class="fas fa-user-md mr-2"></i> {{ __('Kelola Dokter') }}
                     </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('admin.schedules')" :active="request()->routeIs('admin.schedules') || request()->routeIs('admin.schedules.*')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                         <i class="fas fa-calendar-alt mr-2"></i> {{ __('Kelola Jadwal') }}
                     </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('admin.appointments')" :active="request()->routeIs('admin.appointments') || request()->routeIs('admin.appointments.*')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                         <i class="fas fa-clipboard-list mr-2"></i> {{ __('Daftar Janji Temu') }}
                     </x-responsive-nav-link>
                 @endif

                 {{-- Responsive Navigasi untuk Pasien --}}
                 @if(Auth::user()->role === \App\Enums\UserRoleEnum::Pasien->value)
                     <x-responsive-nav-link :href="route('pasien.schedules')" :active="request()->routeIs('pasien.schedules')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                         <i class="fas fa-calendar-alt mr-2"></i> {{ __('Jadwal Dokter') }}
                     </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('pasien.appointments.create')" :active="request()->routeIs('pasien.appointments.create')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                         <i class="fas fa-calendar-plus mr-2"></i> {{ __('Buat Janji') }}
                     </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('pasien.history')" :active="request()->routeIs('pasien.history')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                         <i class="fas fa-history mr-2"></i> {{ __('Riwayat Janji') }}
                     </x-responsive-nav-link>
                     <x-responsive-nav-link :href="route('pasien.chatbot')" :active="request()->routeIs('pasien.chatbot')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                         <i class="fas fa-robot mr-2"></i> {{ __('Chatbot') }}
                     </x-responsive-nav-link>
                 @endif
             @endauth
         </div>

         {{-- Informasi Profil Responsif --}}
         <div class="pt-4 pb-1 border-t border-blue-700">
             <div class="px-4">
                 <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                 <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
             </div>

             <div class="mt-3 space-y-1">
                 <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-blue-700 hover:text-blue-200 focus:bg-blue-700 focus:text-blue-200">
                     <i class="fas fa-user-circle mr-2"></i> {{ __('Profile') }}
                 </x-responsive-nav-link>

                 <form method="POST" action="{{ route('logout') }}">
                     @csrf

                     <x-responsive-nav-link :href="route('logout')"
                             onclick="event.preventDefault();
                                         this.closest('form').submit();"
                             class="text-red-300 hover:bg-red-700 hover:text-white focus:bg-red-700 focus:text-white">
                         <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                     </x-responsive-nav-link>
                 </form>
             </div>
         </div>
     </div>
 </nav>
 <script>
     // Pastikan Font Awesome CSS terhubung di file layout utama Anda (misalnya app.blade.php)
     // Contoh: <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 </script>