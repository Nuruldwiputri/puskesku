<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomor Antrean - {{ $appointment->queue_number }}</title>
    {{-- Menggunakan Tailwind CSS dari CDN untuk halaman cetak --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .print-area {
                width: 100%;
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                font-family: sans-serif;
            }
            .queue-number {
                font-size: 8rem; /* Ukuran font besar */
                font-weight: bold;
                color: #000;
            }
            .info-text {
                font-size: 1.5rem;
                margin-top: 1rem;
            }
            .small-text {
                font-size: 1rem;
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="print-area bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-bold mb-4">Puskesmas Online</h1>
        <h2 class="text-2xl mb-6">Nomor Antrean Anda:</h2>
        <div class="queue-number text-indigo-700 mb-8 p-4 border-4 border-indigo-700 rounded-lg">
            {{ $appointment->queue_number }}
        </div>
        <p class="info-text">Untuk Dokter: {{ $appointment->doctor->name }}</p>
        <p class="info-text">Spesialisasi: {{ $appointment->doctor->specialization }}</p>
        <p class="small-text mt-4">Pada Tanggal: {{ $appointment->appointment_date->format('d F Y') }}</p>
        <p class="small-text">Pukul: {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }} WIB</p>
        <p class="small-text mt-8">Mohon tiba 15 menit sebelum waktu janji temu Anda.</p>

        <button onclick="window.print()" class="no-print mt-8 px-6 py-3 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Cetak Nomor Antrean
        </button>
        <button onclick="window.close()" class="no-print mt-4 px-6 py-3 bg-gray-500 text-white font-semibold rounded-md shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
            Tutup Jendela
        </button>
    </div>
</body>
</html>