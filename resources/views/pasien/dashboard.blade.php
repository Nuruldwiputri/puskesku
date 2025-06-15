<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header consistent with other pages --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-chart-line mr-3"></i> {{ __('Dashboard Pasien') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Ringkasan janji temu dan informasi kesehatan Anda') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             {{-- Main content area with a top border accent --}}
             <div class="overflow-hidden shadow-xl sm:rounded-lg grid grid-cols-1 md:grid-cols-2 gap-6 border-t-4 border-blue-500">

                 {{-- Welcome and Upcoming Appointments Section --}}
                 <div class="bg-white rounded-lg p-6 border-l-4 border-teal-400 shadow-md hover:shadow-lg transition-shadow duration-300">
                     <div class="text-gray-800">
                         <div class="bg-blue-50 p-4 rounded-lg mb-6 flex items-center border border-blue-200">
                             <i class="fas fa-user-check text-2xl text-teal-600 mr-4"></i>
                             <div>
                                 <p class="mb-1 text-xl font-bold text-teal-600">{{ __("Selamat datang, ") }}<span class="text-indigo-700">{{ Auth::user()->name }}</span>!</p>
                                 <p class="text-gray-700 text-sm">{{ __("Ini adalah area khusus Pasien. Anda dapat melihat jadwal dokter dan membuat janji.") }}</p>
                             </div>
                         </div>

                         {{-- Upcoming Appointments --}}
                         <h4 class="font-bold text-xl mb-4 text-teal-600 flex items-center">
                             <i class="fas fa-calendar-check mr-3"></i> Janji Temu Mendatang Anda
                         </h4>
                         @if($upcomingAppointments->isEmpty())
                             <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-5 rounded-lg text-center shadow-sm">
                                 <i class="fas fa-exclamation-circle text-2xl mb-3"></i>
                                 <p class="text-lg italic font-medium">Anda tidak memiliki janji temu mendatang.</p>
                                 <p class="text-sm text-blue-600 mt-2">Buat janji temu baru sekarang untuk mendapatkan layanan kesehatan!</p>
                             </div>
                         @else
                             <div class="overflow-x-auto rounded-lg shadow-md border border-teal-100">
                                 <table class="min-w-full divide-y divide-teal-200 bg-white">
                                     <thead class="bg-teal-100">
                                         <tr>
                                             <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-teal-700 uppercase tracking-wider"><i class="fas fa-user-md mr-1"></i> Dokter</th>
                                             <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-teal-700 uppercase tracking-wider"><i class="far fa-calendar-alt mr-1"></i> Tanggal</th>
                                             <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-teal-700 uppercase tracking-wider"><i class="far fa-clock mr-1"></i> Waktu</th>
                                             <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-teal-700 uppercase tracking-wider"><i class="fas fa-info-circle mr-1"></i> Status</th>
                                             <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-teal-700 uppercase tracking-wider"><i class="fas fa-list-ol mr-1"></i> Antrean</th>
                                             <th scope="col" class="relative px-3 py-3.5">
                                                 <span class="sr-only">Aksi</span>
                                             </th>
                                         </tr>
                                     </thead>
                                     <tbody class="bg-white divide-y divide-teal-100">
                                         @foreach($upcomingAppointments as $appointment)
                                             <tr class="hover:bg-teal-50 transition-colors duration-200">
                                                 <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $appointment->doctor->name }}</td>
                                                 <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $appointment->appointment_date->format('d M Y') }}</td>
                                                 <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                                 <td class="px-3 py-3 whitespace-nowrap text-sm">
                                                     <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm
                                                         @if($appointment->status->value === \App\Enums\AppointmentStatusEnum::Approved->value) bg-green-200 text-green-800
                                                         @elseif($appointment->status->value === \App\Enums\AppointmentStatusEnum::Pending->value) bg-yellow-200 text-yellow-800
                                                         @else bg-gray-200 text-gray-800
                                                         @endif
                                                     ">
                                                         {{ ucfirst($appointment->status->value) }}
                                                     </span>
                                                 </td>
                                                 <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $appointment->queue_number ?? '-' }}</td>
                                                 <td class="px-3 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                     @if($appointment->status === \App\Enums\AppointmentStatusEnum::Approved && !is_null($appointment->queue_number))
                                                         <a href="{{ route('pasien.appointment.print', $appointment->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                             <i class="fas fa-print mr-2"></i> Cetak
                                                         </a>
                                                     @else
                                                         <span class="text-gray-500 italic">-</span>
                                                     @endif
                                                 </td>
                                             </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                             </div>
                         @endif
                     </div>
                 </div>

                 {{-- Past Appointments Section --}}
                 <div class="bg-white rounded-lg p-6 border-l-4 border-sky-400 shadow-md hover:shadow-lg transition-shadow duration-300">
                     <div class="text-gray-800">
                         <h4 class="font-bold text-xl mb-4 text-sky-600 flex items-center">
                             <i class="fas fa-history mr-3"></i> Riwayat Janji Temu Anda
                         </h4>
                         @if($pastAppointments->isEmpty())
                             <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-5 rounded-lg text-center shadow-sm">
                                 <i class="fas fa-info-circle text-2xl mb-3"></i>
                                 <p class="text-lg italic font-medium">Anda tidak memiliki riwayat janji temu.</p>
                                 <p class="text-sm text-blue-600 mt-2">Semua janji temu yang telah selesai atau dibatalkan akan muncul di sini.</p>
                             </div>
                         @else
                             <div class="overflow-x-auto rounded-lg shadow-md border border-sky-100">
                                 <table class="min-w-full divide-y divide-sky-200 bg-white">
                                     <thead class="bg-sky-100">
                                         <tr>
                                             <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-sky-700 uppercase tracking-wider"><i class="fas fa-user-md mr-1"></i> Dokter</th>
                                             <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-sky-700 uppercase tracking-wider"><i class="far fa-calendar-alt mr-1"></i> Tanggal</th>
                                             <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-sky-700 uppercase tracking-wider"><i class="far fa-clock mr-1"></i> Waktu</th>
                                             <th scope="col" class="px-3 py-3.5 text-left text-sm font-bold text-sky-700 uppercase tracking-wider"><i class="fas fa-info-circle mr-1"></i> Status</th>
                                         </tr>
                                     </thead>
                                     <tbody class="bg-white divide-y divide-sky-100">
                                         @foreach($pastAppointments as $appointment)
                                             <tr class="hover:bg-sky-50 transition-colors duration-200">
                                                 <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $appointment->doctor->name }}</td>
                                                 <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $appointment->appointment_date->format('d M Y') }}</td>
                                                 <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                                 <td class="px-3 py-3 whitespace-nowrap text-sm">
                                                     <!-- <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm
                                                         @if($appointment->status->value === \App\Enums\AppointmentStatusEnum::Completed->value) bg-green-200 text-green-800
                                                         @elseif($appointment->status->value === \App\Enums\AppointmentStatusEnum::Canceled->value || $appointment->status->value === \App\Enums\AppointmentStatusEnum::Rejected->value) bg-red-200 text-red-800
                                                         @else bg-gray-200 text-gray-800
                                                         @endif
                                                     ">
                                                         {{ ucfirst($appointment->status->value) }}
                                                     </span> -->
                                                     <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm
                                                         @if($appointment->status->value === \App\Enums\AppointmentStatusEnum::Approved->value) bg-green-200 text-green-800
                                                         @elseif($appointment->status->value === \App\Enums\AppointmentStatusEnum::Pending->value) bg-yellow-200 text-yellow-800
                                                         @else bg-gray-200 text-gray-800
                                                         @endif
                                                     ">
                                                         {{ ucfirst($appointment->status->value) }}
                                                     </span>
                                                 </td>
                                             </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                             </div>
                         @endif
                     </div>
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