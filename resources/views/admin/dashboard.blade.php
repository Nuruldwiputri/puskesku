<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header consistent with other pages --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-tachometer-alt mr-3"></i> {{ __('Dashboard Admin') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Ringkasan statistik dan navigasi cepat untuk administrasi Puskesmas') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             {{-- Main content area with a top border accent and shadow --}}
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     <div class="bg-blue-50 p-4 rounded-lg mb-6 flex items-center border border-blue-200 shadow-sm">
                         <i class="fas fa-user-shield text-2xl text-teal-600 mr-4"></i>
                         <div>
                             <p class="mb-1 text-xl font-bold text-teal-600">{{ __("Selamat datang, Admin!") }}</p>
                             <p class="text-gray-700 text-sm">{{ __("Ini adalah pusat kendali Anda. Pantau statistik penting dan akses cepat ke fitur administrasi.") }}</p>
                         </div>
                     </div>

                     <h3 class="text-2xl font-semibold mb-6 text-blue-700 flex items-center">
                         <i class="fas fa-chart-bar mr-3"></i> Statistik Ringkasan
                     </h3>

                     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                         {{-- Total Pasien Card --}}
                         <div class="bg-blue-100 p-5 rounded-lg shadow-md border border-blue-200 flex items-center space-x-4 transform hover:scale-105 transition-transform duration-200">
                             <div class="p-3 bg-blue-500 rounded-full text-white">
                                 <i class="fas fa-users fa-2x"></i>
                             </div>
                             <div>
                                 <h3 class="font-bold text-lg text-blue-800">Total Pasien</h3>
                                 <p class="text-3xl font-semibold text-blue-900">{{ $totalPatients }}</p>
                             </div>
                         </div>
                         {{-- Total Dokter Card --}}
                         <div class="bg-green-100 p-5 rounded-lg shadow-md border border-green-200 flex items-center space-x-4 transform hover:scale-105 transition-transform duration-200">
                             <div class="p-3 bg-green-500 rounded-full text-white">
                                 <i class="fas fa-user-md fa-2x"></i>
                             </div>
                             <div>
                                 <h3 class="font-bold text-lg text-green-800">Total Dokter</h3>
                                 <p class="text-3xl font-semibold text-green-900">{{ $totalDoctors }}</p>
                             </div>
                         </div>
                         {{-- Janji Tertunda Card --}}
                         <div class="bg-yellow-100 p-5 rounded-lg shadow-md border border-yellow-200 flex items-center space-x-4 transform hover:scale-105 transition-transform duration-200">
                             <div class="p-3 bg-yellow-500 rounded-full text-white">
                                 <i class="fas fa-hourglass-half fa-2x"></i>
                             </div>
                             <div>
                                 <h3 class="font-bold text-lg text-yellow-800">Janji Tertunda</h3>
                                 <p class="text-3xl font-semibold text-yellow-900">{{ $totalPendingAppointments }}</p>
                             </div>
                         </div>
                         {{-- Total Jadwal Card --}}
                         <div class="bg-purple-100 p-5 rounded-lg shadow-md border border-purple-200 flex items-center space-x-4 transform hover:scale-105 transition-transform duration-200">
                             <div class="p-3 bg-purple-500 rounded-full text-white">
                                 <i class="fas fa-calendar-check fa-2x"></i>
                             </div>
                             <div>
                                 <h3 class="font-bold text-lg text-purple-800">Total Jadwal</h3>
                                 <p class="text-3xl font-semibold text-purple-900">{{ $totalSchedules }}</p>
                             </div>
                         </div>
                     </div>

                     {{-- Quick Navigation (optional, uncomment if needed) --}}
                     {{--
                     <h3 class="font-bold text-lg mb-3 text-blue-700">Navigasi Cepat:</h3>
                     <ul class="list-disc list-inside space-y-2">
                         <li><a href="{{ route('admin.patients') }}" class="text-blue-600 hover:text-blue-800 hover:underline"><i class="fas fa-hospital-user mr-2"></i> Lihat Daftar Pasien</a></li>
                         <li><a href="{{ route('admin.doctors') }}" class="text-blue-600 hover:text-blue-800 hover:underline"><i class="fas fa-user-md mr-2"></i> Lihat Daftar Dokter</a></li>
                         <li><a href="{{ route('admin.schedules') }}" class="text-blue-600 hover:text-blue-800 hover:underline"><i class="fas fa-calendar-alt mr-2"></i> Lihat Daftar Jadwal Dokter</a></li>
                         <li><a href="{{ route('admin.appointments') }}" class="text-blue-600 hover:text-blue-800 hover:underline"><i class="fas fa-clipboard-list mr-2"></i> Lihat Daftar Janji Temu</a></li>
                         <li><a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800 hover:underline"><i class="fas fa-user-cog mr-2"></i> Edit Profile</a></li>
                     </ul>
                     --}}
                 </div>
             </div>
         </div>
     </div>
 </x-app-layout>
 <script>
     // Optional: Add Font Awesome for icons (if not already included)
     // You can include it in your layout's head section like this:
     // <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 </script>