<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header consistent with other pages --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-user-edit mr-3"></i> {{ __('Edit Dokter') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Ubah detail data dokter') }}</p>
         </div>
     </x-slot>

     <div class="py-12">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             {{-- Main content area with a top border accent and shadow --}}
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     <h3 class="text-2xl font-semibold mb-6 text-blue-700 flex items-center">
                         <i class="fas fa-user-cog mr-3"></i> Formulir Pengeditan Dokter
                     </h3>

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

                     {{-- Doctor Edit Form --}}
                     <form method="POST" action="{{ route('admin.doctors.update', $doctor->id) }}" class="space-y-6 p-6 bg-blue-50 rounded-lg shadow-inner border border-blue-200">
                         @csrf
                         @method('patch') {{-- Using PATCH method for update --}}

                         {{-- Name Input --}}
                         <div>
                             <x-input-label for="name" :value="__('Nama Dokter')" class="text-blue-700 font-medium mb-2" />
                             <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" :value="old('name', $doctor->name)" required autofocus placeholder="Masukkan nama lengkap dokter" />
                             <x-input-error class="mt-2" :messages="$errors->get('name')" />
                         </div>

                         {{-- Specialization Input --}}
                         <div>
                             <x-input-label for="specialization" :value="__('Spesialisasi')" class="text-blue-700 font-medium mb-2" />
                             <x-text-input id="specialization" name="specialization" type="text" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" :value="old('specialization', $doctor->specialization)" required placeholder="Contoh: Umum, Gigi, Anak, dll." />
                             <x-input-error class="mt-2" :messages="$errors->get('specialization')" />
                         </div>

                         {{-- Phone Number Input --}}
                         <div>
                             <x-input-label for="phone_number" :value="__('Nomor Telepon')" class="text-blue-700 font-medium mb-2" />
                             <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" :value="old('phone_number', $doctor->phone_number)" placeholder="Contoh: 081234567890" />
                             <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                         </div>

                         {{-- Email Input --}}
                         <div>
                             <x-input-label for="email" :value="__('Email')" class="text-blue-700 font-medium mb-2" />
                             <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2.5" :value="old('email', $doctor->email)" placeholder="Contoh: nama.dokter@puskesmas.com" />
                             <x-input-error class="mt-2" :messages="$errors->get('email')" />
                         </div>

                         {{-- Form Actions --}}
                         <div class="flex items-center gap-4 pt-4">
                             <x-primary-button class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                 <i class="fas fa-save mr-2"></i> {{ __('Update Dokter') }}
                             </x-primary-button>
                             <a href="{{ route('admin.doctors') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
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