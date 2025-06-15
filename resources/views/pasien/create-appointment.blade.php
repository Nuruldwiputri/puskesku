<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-calendar-plus mr-3"></i> {{ __('Buat Janji Temu Baru') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Pilih dokter dan waktu yang tersedia untuk janji temu Anda') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     <h3 class="text-2xl font-semibold mb-6 text-blue-700 flex items-center">
                         <i class="fas fa-file-alt mr-3"></i> Formulir Pembuatan Janji Temu
                     </h3>

                     {{-- Success Alert --}}
                     @if (session('success'))
                         <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                             <i class="fas fa-check-circle mr-2"></i> <span class="block sm:inline">{{ session('success') }}</span>
                         </div>
                     @endif
                     {{-- Error Alert --}}
                     @if (session('error'))
                         <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                             <i class="fas fa-exclamation-circle mr-2"></i> <span class="block sm:inline">{{ session('error') }}</span>
                         </div>
                     @endif
                     {{-- Validation Errors --}}
                     @if ($errors->any())
                         <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-md" role="alert">
                             <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                                 @foreach ($errors->all() as $error)
                                     <li><i class="fas fa-times-circle mr-1"></i> {{ $error }}</li>
                                 @endforeach
                             </ul>
                         </div>
                     @endif

                     {{-- Filter Form for Doctor and Date --}}
                     <form method="GET" action="{{ route('pasien.appointments.create') }}" id="filterForm" class="space-y-6 mb-8 p-6 bg-blue-50 rounded-lg shadow-inner border border-blue-200">
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div>
                                 <x-input-label for="doctor_id" :value="__('Pilih Dokter')" class="text-blue-700 font-medium mb-2" />
                                 <div class="relative">
                                     <select id="doctor_id" name="doctor_id" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5 appearance-none bg-white pr-10" onchange="document.getElementById('filterForm').submit()">
                                         <option value="">-- Pilih Dokter --</option>
                                         @foreach($doctors as $doctor)
                                             <option value="{{ $doctor->id }}" {{ $selectedDoctorId == $doctor->id ? 'selected' : '' }}>
                                                 {{ $doctor->name }} ({{ $doctor->specialization }})
                                             </option>
                                         @endforeach
                                     </select>
                                     <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-blue-700">
                                         <i class="fas fa-chevron-down"></i>
                                     </div>
                                 </div>
                             </div>

                             <div>
                                 <x-input-label for="appointment_date" :value="__('Pilih Tanggal Janji')" class="text-blue-700 font-medium mb-2" />
                                 <x-text-input id="appointment_date" name="appointment_date" type="date" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" :value="$selectedDate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onchange="document.getElementById('filterForm').submit()" />
                             </div>
                         </div>
                         <x-primary-button type="submit" class="hidden">Filter</x-primary-button> {{-- Hidden submit button, submission handled by JS --}}
                     </form>

                     {{-- Display Available Schedules and Appointment Creation Form --}}
                     @if($selectedDoctorId && $selectedDate)
                         <hr class="my-8 border-blue-200">
                         <h4 class="font-bold text-xl mb-6 text-teal-600 flex items-center">
                             <i class="fas fa-calendar-day mr-3"></i> Jadwal Tersedia untuk&nbsp;<span class="text-indigo-700">{{ $doctors->firstWhere('id', $selectedDoctorId)->name }}</span>&nbsp;pada Tanggal&nbsp;<span class="text-indigo-700">{{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</span>
                         </h4>

                         @if($availableSchedules->isEmpty())
                             <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-5 rounded-lg text-center shadow-sm">
                                 <i class="fas fa-exclamation-triangle text-2xl mb-3"></i>
                                 <p class="text-lg italic font-medium">Tidak ada jadwal tersedia untuk dokter ini pada tanggal yang dipilih.</p>
                                 <p class="text-sm text-yellow-600 mt-2">Silakan pilih tanggal atau dokter lain.</p>
                             </div>
                         @else
                             <form method="POST" action="{{ route('pasien.appointments.store') }}" class="space-y-6 p-6 bg-blue-50 rounded-lg shadow-inner border border-blue-200">
                                 @csrf

                                 <div>
                                     <x-input-label for="schedule_id" :value="__('Pilih Waktu Janji Temu')" class="text-blue-700 font-medium mb-2" />
                                     <div class="relative">
                                         <select id="schedule_id" name="schedule_id" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5 appearance-none bg-white pr-10" required>
                                             <option value="">-- Pilih Waktu --</option>
                                             @foreach($availableSchedules as $schedule)
                                                 <option value="{{ $schedule->id }}" {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                                     {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} (Hari: {{ $schedule->day_of_week }})
                                                 </option>
                                             @endforeach
                                         </select>
                                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-blue-700">
                                             <i class="fas fa-chevron-down"></i>
                                         </div>
                                     </div>
                                 </div>

                                 <div>
                                     <x-input-label for="notes" :value="__('Catatan (Opsional)')" class="text-blue-700 font-medium mb-2" />
                                     <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" placeholder="Contoh: Keluhan utama, preferensi dokter, dll.">{{ old('notes') }}</textarea>
                                 </div>

                                 {{-- Hidden inputs for selected doctor and date --}}
                                 <input type="hidden" name="doctor_id" value="{{ $selectedDoctorId }}">
                                 <input type="hidden" name="appointment_date" value="{{ $selectedDate }}">

                                 <div class="flex items-center gap-4 pt-4">
                                     <x-primary-button class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                         <i class="fas fa-check-circle mr-2"></i> {{ __('Buat Janji Temu') }}
                                     </x-primary-button>
                                     <a href="{{ route('pasien.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                         <i class="fas fa-times-circle mr-2"></i> {{ __('Batal') }}
                                     </a>
                                 </div>
                             </form>
                         @endif
                     @else
                         <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-5 rounded-lg text-center shadow-sm">
                             <i class="fas fa-hand-point-up text-2xl mb-3"></i>
                             <p class="text-lg italic font-medium">Silakan pilih dokter dan tanggal di atas untuk melihat jadwal yang tersedia.</p>
                             <p class="text-sm text-blue-600 mt-2">Setelah memilih, formulir janji temu akan muncul di sini.</p>
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