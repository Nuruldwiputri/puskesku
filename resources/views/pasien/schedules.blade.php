<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-calendar-alt mr-3"></i> {{ __('Jadwal Dokter') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Temukan jadwal praktik dokter Puskesku kami') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     <h3 class="text-2xl font-semibold mb-6 text-blue-700 flex items-center">
                         <i class="fas fa-user-md mr-3"></i> Daftar Dokter dan Jadwal Praktik
                     </h3>

                     @if($doctors->isEmpty())
                         <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-5 rounded-lg text-center shadow-sm">
                             <i class="fas fa-info-circle text-2xl mb-3"></i>
                             <p class="text-lg italic font-medium">Belum ada dokter yang terdaftar atau jadwal yang tersedia.</p>
                             <p class="text-sm text-blue-600 mt-2">Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.</p>
                         </div>
                     @else
                         <div class="grid grid-cols-1 gap-8">
                             @foreach($doctors as $doctor)
                                 <div class="bg-blue-50 p-6 border-l-4 border-teal-400 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                     <h4 class="font-bold text-xl mb-2 text-indigo-700 flex items-center">
                                         <i class="fas fa-user-circle mr-2"></i> {{ $doctor->name }}
                                         <span class="ml-3 px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-full">{{ $doctor->specialization }}</span>
                                     </h4>
                                     <p class="text-sm text-gray-600 mb-4 flex items-center">
                                         <i class="far fa-envelope mr-2 text-blue-500"></i> Email: {{ $doctor->email ?? '-' }}
                                         <span class="mx-3 text-gray-400">|</span>
                                         <i class="fas fa-phone mr-2 text-blue-500"></i> Telp: {{ $doctor->phone_number ?? '-' }}
                                     </p>

                                     @if($doctor->schedules->isEmpty())
                                         <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg text-sm text-center shadow-sm">
                                             <i class="fas fa-exclamation-triangle mr-2"></i> Tidak ada jadwal praktik yang tersedia untuk dokter ini.
                                         </div>
                                     @else
                                         <div class="overflow-x-auto rounded-lg shadow-sm border border-blue-100">
                                             <table class="min-w-full divide-y divide-blue-200">
                                                 <thead class="bg-blue-100">
                                                     <tr>
                                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                                             <i class="fas fa-calendar-day mr-2"></i>Hari
                                                         </th>
                                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                                             <i class="far fa-clock mr-2"></i>Waktu Praktik
                                                         </th>
                                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                                             <i class="fas fa-users mr-2"></i>Maks. Janji
                                                         </th>
                                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                                             <i class="fas fa-hand-pointer mr-2"></i>Aksi
                                                         </th>
                                                     </tr>
                                                 </thead>
                                                 <tbody class="bg-white divide-y divide-blue-100">
                                                     @foreach($doctor->schedules->sortBy('day_of_week') as $schedule)
                                                         {{-- Highlight today's schedule --}}
                                                         <tr class="hover:bg-blue-50 transition-colors duration-200 {{ (new DateTime())->format('l') === $schedule->day_of_week ? 'bg-blue-50 font-semibold' : '' }}">
                                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $schedule->day_of_week }}</td>
                                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $schedule->max_appointments > 0 ? $schedule->max_appointments : 'Tak Terbatas' }}</td>
                                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                 <a href="{{ route('pasien.appointments.create', ['doctor_id' => $doctor->id, 'appointment_date' => \Carbon\Carbon::now()->format('Y-m-d')]) }}" class="inline-flex items-center pl-2 pr-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                                     <i class="fas fa-calendar-plus mr-2"></i> Buat Janji
                                                                 </a>
                                                             </td>
                                                         </tr>
                                                     @endforeach
                                                 </tbody>
                                             </table>
                                         </div>
                                     @endif
                                 </div>
                             @endforeach
                         </div>
                     @endif
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