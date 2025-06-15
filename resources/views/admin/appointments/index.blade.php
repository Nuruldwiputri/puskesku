<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header consistent with other pages --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-clipboard-list mr-3"></i> {{ __('Daftar Janji Temu') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Kelola seluruh janji temu pasien Puskesku') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             {{-- Main content area with a top border accent --}}
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     <h3 class="text-2xl font-semibold mb-6 text-blue-700 flex items-center">
                         <i class="fas fa-calendar-check mr-3"></i> Seluruh Daftar Janji Temu Pasien
                     </h3>

                     {{-- Success Alert --}}
                     @if (session('success'))
                         <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                             <i class="fas fa-check-circle mr-2"></i> <span class="block sm:inline">{{ session('success') }}</span>
                         </div>
                     @endif

                     @if($appointments->isEmpty())
                         <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-5 rounded-lg text-center shadow-sm">
                             <i class="fas fa-info-circle text-2xl mb-3"></i>
                             <p class="text-lg italic font-medium">Belum ada janji temu yang terdaftar.</p>
                             <p class="text-sm text-blue-600 mt-2">Daftar janji temu akan muncul di sini setelah pasien membuat janji.</p>
                         </div>
                     @else
                         <div class="overflow-x-auto rounded-lg shadow-md border border-blue-100">
                             <table class="min-w-full divide-y divide-blue-200">
                                 <thead class="bg-blue-100">
                                     <tr>
                                         <th scope="col" class="px-6 py-3 text-left !text-left text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-user mr-2"></i>Pasien</th>
                                         <th scope="col" class="px-6 py-3 text-left !text-left text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-user-md mr-2"></i>Dokter</th>
                                         <th scope="col" class="px-6 py-3 text-left !text-center text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-calendar-alt mr-2"></i>Jadwal (Hari, Waktu)</th>
                                         <th scope="col" class="px-6 py-3 text-center !text-center text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="far fa-calendar-check mr-2"></i>Tanggal Janji</th>
                                         <th scope="col" class="px-6 py-3 text-center !text-center text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="far fa-clock mr-2"></i>Waktu Janji</th>
                                         <th scope="col" class="px-6 py-3 text-center !text-center text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-list-ol mr-2"></i>No. Antrean</th>
                                         <th scope="col" class="px-6 py-3 text-left !text-left text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-info-circle mr-2"></i>Status</th>
                                         <th scope="col" class="px-6 py-3 text-left !text-left text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-sticky-note mr-2"></i>Catatan</th>
                                         <th scope="col" class="px-6 py-3 text-left !text-left text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-cogs mr-2"></i>Aksi</th>
                                     </tr>
                                 </thead>
                                 <tbody class="bg-white divide-y divide-blue-100">
                                     @foreach($appointments as $appointment)
                                         <tr class="hover:bg-blue-50 transition-colors duration-200">
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 !text-left">{{ $appointment->user->name }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 !text-left">{{ $appointment->doctor->name }} ({{ $appointment->doctor->specialization }})</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 !text-left">{{ $appointment->schedule->day_of_week }}, {{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->schedule->end_time)->format('H:i') }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 !text-center">{{ $appointment->appointment_date->format('d M Y') }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 !text-center">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 !text-center">{{ $appointment->queue_number ?? '-' }}</td>

                                             {{-- Status Column --}}
                                             <td class="px-6 py-4 whitespace-nowrap !text-left"> {{-- Status badge is inline-flex, so parent text-align may not affect it, but we set it for consistency --}}
                                                 <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm
                                                     @if($appointment->status->value === \App\Enums\AppointmentStatusEnum::Approved->value || $appointment->status->value === \App\Enums\AppointmentStatusEnum::Completed->value) bg-green-200 text-green-800
                                                     @elseif($appointment->status->value === \App\Enums\AppointmentStatusEnum::Pending->value) bg-yellow-200 text-yellow-800
                                                     @elseif($appointment->status->value === \App\Enums\AppointmentStatusEnum::Rejected->value || $appointment->status->value === \App\Enums\AppointmentStatusEnum::Canceled->value) bg-red-200 text-red-800
                                                     @else bg-gray-200 text-gray-800
                                                     @endif
                                                 ">
                                                     {{ ucfirst($appointment->status->value) }}
                                                 </span>
                                             </td>

                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 !text-left">{{ $appointment->notes ?? '-' }}</td>

                                             {{-- Action Column --}}
                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium !text-left"> {{-- Actions are forms/buttons, so left-align them --}}
                                                 <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST" class="inline-block">
                                                     @csrf
                                                     @method('patch')
                                                     <div class="relative inline-block text-left">
                                                         <select name="status" class="block w-full text-xs border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-1.5 pr-8 appearance-none bg-white
                                                             @if($appointment->status->value === \App\Enums\AppointmentStatusEnum::Approved->value || $appointment->status->value === \App\Enums\AppointmentStatusEnum::Completed->value) text-green-700 border-green-300
                                                             @elseif($appointment->status->value === \App\Enums\AppointmentStatusEnum::Pending->value) text-yellow-700 border-yellow-300
                                                             @elseif($appointment->status->value === \App\Enums\AppointmentStatusEnum::Rejected->value || $appointment->status->value === \App\Enums\AppointmentStatusEnum::Canceled->value) text-red-700 border-red-300
                                                             @else text-gray-700 border-gray-300
                                                             @endif
                                                         " onchange="this.closest('form').submit()">
                                                             <option value="">Ubah Status</option>
                                                             @foreach(\App\Enums\AppointmentStatusEnum::cases() as $enumStatus)
                                                                 {{-- Avoid displaying current status in the dropdown (optional, but cleaner UX) --}}
                                                                 @if($appointment->status->value !== $enumStatus->value)
                                                                     <option value="{{ $enumStatus->value }}">
                                                                         Ubah ke {{ ucfirst($enumStatus->value) }}
                                                                     </option>
                                                                 @endif
                                                             @endforeach
                                                         </select>
                                                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                                             <i class="fas fa-chevron-down text-xs"></i>
                                                         </div>
                                                     </div>
                                                 </form>

                                                 {{-- Delete appointment button (if needed, currently commented out) --}}
                                                 {{--
                                                 <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" class="inline-block mt-2 ml-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus janji temu ini?');">
                                                     @csrf
                                                     @method('delete')
                                                     <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                         <i class="fas fa-trash mr-1"></i> Hapus
                                                     </button>
                                                 </form>
                                                 --}}
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