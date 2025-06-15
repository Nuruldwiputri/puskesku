<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header consistent with other pages --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-calendar-alt mr-3"></i> {{ __('Daftar Jadwal Dokter') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Kelola dan tinjau jadwal praktik seluruh dokter') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             {{-- Main content area with a top border accent and shadow --}}
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     {{-- Section 1: Add "Tambah Jadwal" button and success/error messages --}}
                     <div class="flex justify-between items-center mb-6">
                         <h3 class="text-2xl font-semibold text-blue-700 flex items-center">
                             <i class="fas fa-list-alt mr-3"></i> Seluruh Daftar Jadwal Dokter
                         </h3>
                         <a href="{{ route('admin.schedules.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:from-green-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:scale-105">
                             <i class="fas fa-plus-circle mr-2"></i> {{ __('Tambah Jadwal') }}
                         </a>
                     </div>

                     {{-- Success/Error Alerts --}}
                     @if (session('success'))
                         <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                             <i class="fas fa-check-circle mr-2"></i> <span class="block sm:inline">{{ session('success') }}</span>
                         </div>
                     @endif
                     @if (session('error'))
                         <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                             <i class="fas fa-exclamation-circle mr-2"></i> <span class="block sm:inline">{{ session('error') }}</span>
                         </div>
                     @endif

                     @if($schedules->isEmpty())
                         <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-5 rounded-lg text-center shadow-sm">
                             <i class="fas fa-info-circle text-2xl mb-3"></i>
                             <p class="text-lg italic font-medium">Belum ada jadwal yang terdaftar.</p>
                             <p class="text-sm text-blue-600 mt-2">Klik "Tambah Jadwal" untuk mulai menambahkan jadwal praktik dokter.</p>
                         </div>
                     @else
                         <div class="overflow-x-auto rounded-lg shadow-md border border-blue-100">
                             <table class="min-w-full divide-y divide-blue-200">
                                 <thead class="bg-blue-100">
                                     <tr>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-user-md mr-2"></i>Dokter</th>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-calendar-day mr-2"></i>Hari</th>
                                         <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="far fa-clock mr-2"></i>Waktu Mulai</th>
                                         <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="far fa-clock mr-2"></i>Waktu Selesai</th>
                                         <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-users mr-2"></i>Max Janji</th>
                                         {{-- Section 2: Add Action column to thead --}}
                                         <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-cogs mr-2"></i>Aksi</th>
                                     </tr>
                                 </thead>
                                 <tbody class="bg-white divide-y divide-blue-100">
                                     @foreach($schedules as $schedule)
                                         <tr class="hover:bg-blue-50 transition-colors duration-200">
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $schedule->doctor->name }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $schedule->day_of_week }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">{{ $schedule->max_appointments }}</td>
                                             {{-- Section 3: Add Action buttons to tbody --}}
                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                                 <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="inline-flex items-center pl-3 pr-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm mr-2">
                                                     <i class="fas fa-edit mr-2"></i> Edit
                                                 </a>
                                                 <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                                     @csrf
                                                     @method('delete')
                                                     <button type="submit" class="inline-flex items-center pl-3 pr-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                                         <i class="fas fa-trash-alt mr-2"></i> Hapus
                                                     </button>
                                                 </form>
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