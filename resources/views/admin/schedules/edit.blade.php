<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header consistent with other pages --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-edit mr-3"></i> {{ __('Edit Jadwal Dokter') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Ubah detail jadwal praktik dokter') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             {{-- Main content area with a top border accent and shadow --}}
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     <h3 class="text-2xl font-semibold mb-6 text-blue-700 flex items-center">
                         <i class="fas fa-file-invoice mr-3"></i> Formulir Pengeditan Jadwal
                     </h3>

                     {{-- Success/Error/Validation Alerts --}}
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
                     @if ($errors->any())
                         <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                             <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                                 @foreach ($errors->all() as $error)
                                     <li><i class="fas fa-times-circle mr-1"></i> {{ $error }}</li>
                                 @endforeach
                             </ul>
                         </div>
                     @endif

                     {{-- Schedule Edit Form --}}
                     <form method="POST" action="{{ route('admin.schedules.update', $schedule->id) }}" class="space-y-6 p-6 bg-blue-50 rounded-lg shadow-inner border border-blue-200">
                         @csrf
                         @method('patch')

                         {{-- Doctor Selection (usually disabled or hidden for edit, but kept editable as per original) --}}
                         <div>
                             <x-input-label for="doctor_id" :value="__('Pilih Dokter')" class="text-blue-700 font-medium mb-2" />
                             <div class="relative">
                                 <select id="doctor_id" name="doctor_id" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5 appearance-none bg-white pr-10" required>
                                     <option value="">-- Pilih Dokter --</option>
                                     @foreach($doctors as $doctor)
                                         <option value="{{ $doctor->id }}" {{ old('doctor_id', $schedule->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                             {{ $doctor->name }} ({{ $doctor->specialization }})
                                         </option>
                                     @endforeach
                                 </select>
                                 <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-blue-700">
                                     <i class="fas fa-chevron-down"></i>
                                 </div>
                             </div>
                             <x-input-error class="mt-2" :messages="$errors->get('doctor_id')" />
                         </div>

                         {{-- Day of Week Selection --}}
                         <div>
                             <x-input-label for="day_of_week" :value="__('Hari Praktik')" class="text-blue-700 font-medium mb-2" />
                             <div class="relative">
                                 <select id="day_of_week" name="day_of_week" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5 appearance-none bg-white pr-10" required>
                                     <option value="">-- Pilih Hari --</option>
                                     @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                         <option value="{{ $day }}" {{ old('day_of_week', $schedule->day_of_week) == $day ? 'selected' : '' }}>{{ $day }}</option>
                                     @endforeach
                                 </select>
                                 <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-blue-700">
                                     <i class="fas fa-chevron-down"></i>
                                 </div>
                             </div>
                             <x-input-error class="mt-2" :messages="$errors->get('day_of_week')" />
                         </div>

                         {{-- Start Time Input --}}
                         <div>
                             <x-input-label for="start_time" :value="__('Waktu Mulai')" class="text-blue-700 font-medium mb-2" />
                             <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" :value="old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i'))" required />
                             <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                         </div>

                         {{-- End Time Input --}}
                         <div>
                             <x-input-label for="end_time" :value="__('Waktu Selesai')" class="text-blue-700 font-medium mb-2" />
                             <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" :value="old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i'))" required />
                             <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                         </div>

                         {{-- Max Appointments Input --}}
                         <div>
                             <x-input-label for="max_appointments" :value="__('Maksimal Janji Temu (0 untuk tak terbatas)')" class="text-blue-700 font-medium mb-2" />
                             <x-text-input id="max_appointments" name="max_appointments" type="number" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" :value="old('max_appointments', $schedule->max_appointments)" min="0" required />
                             <x-input-error class="mt-2" :messages="$errors->get('max_appointments')" />
                         </div>

                         {{-- Form Actions --}}
                         <div class="flex items-center gap-4 pt-4">
                             <x-primary-button class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                 <i class="fas fa-save mr-2"></i> {{ __('Update Jadwal') }}
                             </x-primary-button>
                             <a href="{{ route('admin.schedules') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                 <i class="fas fa-times-circle mr-2"></i> {{ __('Batal') }}
                             </a>
                         </div>
                     </form>
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