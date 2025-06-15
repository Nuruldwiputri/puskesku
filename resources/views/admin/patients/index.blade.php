<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header consistent with other pages --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-users mr-3"></i> {{ __('Daftar Pasien') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Tinjau seluruh data pasien yang terdaftar di Puskesku') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             {{-- Main content area with a top border accent and shadow --}}
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     <h3 class="text-2xl font-semibold mb-6 text-blue-700 flex items-center">
                         <i class="fas fa-user-friends mr-3"></i> Seluruh Daftar Pasien
                     </h3>

                     @if($patients->isEmpty())
                         <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-5 rounded-lg text-center shadow-sm">
                             <i class="fas fa-info-circle text-2xl mb-3"></i>
                             <p class="text-lg italic font-medium">Belum ada pasien yang terdaftar.</p>
                             <p class="text-sm text-blue-600 mt-2">Daftar pasien akan muncul di sini setelah mereka mendaftar.</p>
                         </div>
                     @else
                         <div class="overflow-x-auto rounded-lg shadow-md border border-blue-100">
                             <table class="min-w-full divide-y divide-blue-200">
                                 <thead class="bg-blue-100">
                                     <tr>
                                         <th scope="col" class="px-6 py-3 text-middle text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-id-card-alt mr-2"></i>Nama</th>
                                         <th scope="col" class="px-6 py-3 text-middle text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-envelope mr-2"></i>Email</th>
                                         <th scope="col" class="px-6 py-3 text-middle text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-phone mr-2"></i>Telepon</th>
                                         <th scope="col" class="px-6 py-3 text-middle text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-map-marker-alt mr-2"></i>Alamat</th>
                                         <th scope="col" class="px-6 py-3 text-middle text-xs font-bold text-blue-700 uppercase tracking-wider"><i class="fas fa-calendar-plus mr-2"></i>Bergabung Sejak</th>
                                     </tr>
                                 </thead>
                                 <tbody class="bg-white divide-y divide-blue-100">
                                     @foreach($patients as $patient)
                                         <tr class="hover:bg-blue-50 transition-colors duration-200">
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $patient->name }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $patient->email }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $patient->phone_number ?? '-' }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $patient->address ?? '-' }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $patient->created_at->format('d M Y') }}</td>
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