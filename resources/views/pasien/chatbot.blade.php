<x-app-layout>
     <x-slot name="header">
         {{-- Enhanced Header --}}
         <div class="bg-gradient-to-r from-blue-400 to-indigo-400 shadow-lg rounded-lg p-6 text-center">
             <h2 class="font-bold text-3xl text-white leading-tight">
                 <i class="fas fa-robot mr-3"></i> {{ __('Chatbot Puskesku Anda') }}
             </h2>
             <p class="text-white text-opacity-90 mt-2 text-md">{{ __('Ajukan pertanyaan seputar kesehatan dan layanan Puskesmas') }}</p>
         </div>
     </x-slot>

     <div class="py-8">
         <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-500">
                 <div class="p-6 text-gray-900">
                     <h3 class="text-2xl font-semibold mb-4 text-blue-700 flex items-center">
                         <i class="fas fa-comments mr-3"></i> Bertanya kepada Chatbot
                     </h3>

                     {{-- Chat Box --}}
                     <div id="chat-box" class="h-96 overflow-y-auto border border-blue-200 rounded-xl p-4 mb-4 flex flex-col space-y-4 bg-blue-50 shadow-inner">
                         {{-- Initial Bot Message --}}
                         <div class="flex justify-start">
                             <div class="bg-blue-200 text-blue-800 p-3 rounded-t-xl rounded-br-xl max-w-xs shadow-md animate-fade-in-down">
                                 <i class="fas fa-robot mr-2"></i> Halo! Saya chatbot Puskesku Online. Ada yang bisa saya bantu?
                             </div>
                         </div>
                     </div>

                     {{-- Message Input and Send Button --}}
                     <div class="flex space-x-3 mt-4 items-center">
                         <x-text-input id="user-message" type="text" class="flex-1 p-3 border-2 border-blue-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 shadow-sm" placeholder="Ketik pesan Anda di sini..." />
                         <x-primary-button id="send-button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                             <i class="fas fa-paper-plane mr-2"></i> {{ __('Kirim') }}
                         </x-primary-button>
                     </div>
                     <div id="loading-indicator" class="hidden text-center text-sm text-blue-500 mt-3 flex items-center justify-center">
                         <i class="fas fa-spinner fa-spin mr-2"></i> Sedang mengetik...
                     </div>
                     <div id="error-message" class="hidden text-red-600 text-sm mt-3 flex items-center justify-center">
                         <i class="fas fa-exclamation-triangle mr-2"></i>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     @push('scripts')
     <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
     {{-- Add Font Awesome for icons if not already included in your layout --}}
     <script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script> {{-- Replace 'your-font-awesome-kit-id.js' with your actual Font Awesome kit ID --}}
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             const chatBox = document.getElementById('chat-box');
             const userMessageInput = document.getElementById('user-message');
             const sendButton = document.getElementById('send-button');
             const loadingIndicator = document.getElementById('loading-indicator');
             const errorMessage = document.getElementById('error-message');

             function addMessage(sender, message) {
                 const messageDiv = document.createElement('div');
                 if (sender === 'user') {
                     messageDiv.className = 'flex justify-end animate-fade-in-up';
                     messageDiv.innerHTML = `<div class="bg-indigo-400 text-white p-3 rounded-t-xl rounded-bl-xl max-w-xs shadow-md">${message}</div>`;
                 } else { // sender === 'ai'
                     messageDiv.className = 'flex justify-start animate-fade-in-down';
                     messageDiv.innerHTML = `<div class="bg-blue-200 text-blue-800 p-3 rounded-t-xl rounded-br-xl max-w-xs shadow-md">${message}</div>`;
                 }
                 chatBox.appendChild(messageDiv);
                 chatBox.scrollTop = chatBox.scrollHeight; // Scroll to bottom
             }

             async function sendMessage() {
                 const message = userMessageInput.value.trim();
                 if (!message) return;

                 addMessage('user', message);
                 userMessageInput.value = ''; // Clear input
                 errorMessage.textContent = ''; // Clear error message
                 errorMessage.classList.add('hidden');
                 loadingIndicator.classList.remove('hidden'); // Show loading

                 try {
                     const response = await axios.post('{{ route('pasien.chatbot.send') }}', {
                         message: message,
                         _token: '{{ csrf_token() }}' // Send CSRF token
                     });

                     loadingIndicator.classList.add('hidden'); // Hide loading
                     addMessage('ai', response.data.reply);

                 } catch (error) {
                     loadingIndicator.classList.add('hidden'); // Hide loading
                     console.error('Error sending message:', error);
                     errorMessage.textContent = 'Terjadi kesalahan saat berkomunikasi dengan chatbot. Silakan coba lagi.';
                     errorMessage.classList.remove('hidden');
                     if (error.response && error.response.data && error.response.data.error) {
                         errorMessage.textContent = error.response.data.error; // Display backend error
                     }
                 }
             }

             sendButton.addEventListener('click', sendMessage);
             userMessageInput.addEventListener('keypress', function(e) {
                 if (e.key === 'Enter') {
                     sendMessage();
                 }
             });
         });
     </script>
     {{-- Tailwind CSS Custom Animation for fade-in (add this to your main CSS file or a <style> tag) --}}
     {{-- You might need to extend your tailwind.config.js for these animations --}}
     {{-- For example, in tailwind.config.js:
     module.exports = {
         theme: {
             extend: {
                 keyframes: {
                     'fade-in-down': {
                         '0%': { opacity: '0', transform: 'translateY(-10px)' },
                         '100%': { opacity: '1', transform: 'translateY(0)' },
                     },
                     'fade-in-up': {
                         '0%': { opacity: '0', transform: 'translateY(10px)' },
                         '100%': { opacity: '1', transform: 'translateY(0)' },
                     }
                 },
                 animation: {
                     'fade-in-down': 'fade-in-down 0.5s ease-out',
                     'fade-in-up': 'fade-in-up 0.5s ease-out',
                 }
             }
         }
     }
     --}}
     <style>
         /* Basic animations if you don't configure them in tailwind.config.js */
         @keyframes fade-in-down {
             0% {
                 opacity: 0;
                 transform: translateY(-10px);
             }
             100% {
                 opacity: 1;
                 transform: translateY(0);
             }
         }

         @keyframes fade-in-up {
             0% {
                 opacity: 0;
                 transform: translateY(10px);
             }
             100% {
                 opacity: 1;
                 transform: translateY(0);
             }
         }

         .animate-fade-in-down {
             animation: fade-in-down 0.5s ease-out;
         }

         .animate-fade-in-up {
             animation: fade-in-up 0.5s ease-out;
         }
     </style>
     @endpush
 </x-app-layout>