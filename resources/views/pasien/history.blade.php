<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-history mr-3"></i> {{ __('Riwayat Janji Temu') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Lihat seluruh riwayat janji temu Anda di sini') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     <h3 class="text-2xl font-semibold mb-6 text-blue-700 flex items-center">
                         <i class="fas fa-calendar-alt mr-3"></i> Seluruh Riwayat Janji Temu Anda
                     </h3>

                     @if (session('error'))
                         <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                             <i class="fas fa-exclamation-circle mr-2"></i> <span class="block sm:inline">{{ session('error') }}</span>
                         </div>
                     @endif

                     @if($appointments->isEmpty())
                         <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-5 rounded-lg text-center shadow-sm">
                             <i class="fas fa-info-circle text-2xl mb-3"></i>
                             <p class="text-lg italic font-medium">Anda belum memiliki riwayat janji temu.</p>
                             <p class="text-sm text-blue-600 mt-2">Silakan buat janji temu baru untuk memulai!</p>
                         </div>
                     @else
                         <div class="overflow-x-auto rounded-lg shadow-md border border-blue-100">
                             <table class="min-w-full divide-y divide-blue-200">
                                 <thead class="bg-blue-100">
                                     <tr>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                             <i class="fas fa-user-md mr-2"></i>Dokter
                                         </th>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                             <i class="far fa-calendar-alt mr-2"></i>Tanggal
                                         </th>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                             <i class="far fa-clock mr-2"></i>Waktu
                                         </th>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                             <i class="fas fa-list-ol mr-2"></i>No. Antrean
                                         </th>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                             <i class="fas fa-info-circle mr-2"></i>Status
                                         </th>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                             <i class="fas fa-sticky-note mr-2"></i>Catatan
                                         </th>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                             <i class="fas fa-cogs mr-2"></i>Aksi
                                         </th>
                                     </tr>
                                 </thead>
                                 <tbody class="bg-white divide-y divide-blue-100">
                                     @foreach($appointments as $appointment)
                                         <tr class="hover:bg-blue-50 transition-colors duration-200">
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $appointment->doctor->name }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $appointment->appointment_date->format('d M Y') }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $appointment->queue_number ?? '-' }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap">
                                                 <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm
                                                     @if($appointment->status->value === \App\Enums\AppointmentStatusEnum::Approved->value || $appointment->status->value === \App\Enums\AppointmentStatusEnum::Completed->value) bg-green-200 text-green-800
                                                     @elseif($appointment->status->value === \App\Enums\AppointmentStatusEnum::Pending->value) bg-yellow-200 text-yellow-800
                                                     @else bg-red-200 text-red-800
                                                     @endif
                                                 ">
                                                     {{ ucfirst($appointment->status->value) }}
                                                 </span>
                                             </td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $appointment->notes ?? '-' }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                 @if($appointment->status === \App\Enums\AppointmentStatusEnum::Approved && !is_null($appointment->queue_number))
                                                     <a href="{{ route('pasien.appointment.print', $appointment->id) }}" target="_blank" class="inline-flex items-center pl-3 pr-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                         <i class="fas fa-print mr-2"></i> Cetak Antrean
                                                     </a>
                                                 @else
                                                     <span class="text-gray-500">-</span>
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
         </div>
     </div>
 </x-app-layout>
 <script>
     // Optional: Add Font Awesome for icons (if not already included)
     // You can include it in your layout's head section like this:
     // <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 </script>