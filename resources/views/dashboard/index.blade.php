<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="font-[Inter]">
    <div class="flex flex-1 flex-col md:flex-row lg:flex-row">
        <div class="overflow-hidden shadow w-full">
            <div class="bg-gradient-to-b from-[#42aafa] to-[#2a8bd3] w-full py-16 px-5 min-h-screen h-auto">
                <div class="container mx-auto px-4">
                    <div class="mb-5 text-center">
                        <h2 class="text-4xl font-bold text-white uppercase">Hasil Pengolahan Podes 2024</h2>
                    </div>
                </div>
                <div class="w-full lg:flex lg:justify-between">
                    <div class="flex flex-wrap w-full lg:w-auto justify-center lg:justify-start gap-2">
                        <!-- Provinsi -->
                        <div class="dropdown dropdown-bottom">
                            <select id="provinsiSelect" aria-label="Select province" class="btn m-1">
                                <option selected>Pilih Provinsi</option>
                            </select>
                        </div>

                        <!-- Kabupaten -->
                        <div class="dropdown dropdown-bottom">
                            <select id="kabupatenSelect" aria-label="Select kabupaten" class="btn m-1" disabled>
                                <option selected>Pilih Kabupaten</option>
                            </select>
                        </div>

                        <!-- Kecamatan -->
                        <div class="dropdown dropdown-bottom">
                            <select id="kecamatanSelect" aria-label="Select kecamatan" class="btn m-1" disabled>
                                <option selected>Pilih Kecamatan</option>
                            </select>
                        </div>

                        <!-- Desa -->
                        <div class="dropdown dropdown-bottom">
                            <select id="desaSelect" aria-label="Select desa" class="btn m-1" disabled>
                                <option selected>Pilih Desa/Kelurahan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Form Search -->
                    {{-- <form action="/search" method="POST" class="flex justify-center lg:ml-4 mt-4 lg:mt-0 gap-2">
                        <input type="text" name="search" id="search" class="input input-bordered w-64"
                            placeholder="Cari sesuat
                        <button type="submit" class="btn">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                    stroke="currentColor">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </g>
                            </svg>
                        </button>
                        @csrf
                    </form> --}}
                </div>

                <div class="mt-2 bg-white overflow-x-auto rounded-xl shadow-lg">
                    <table class="table min-w-max text-sm text-left text-gray-700 bg-white border border-gray-200"
                        id="podesTable">
                        <thead class="bg-gray-100 text-gray-800 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Nama Provinsi</th>
                                <th class="px-4 py-3">Nama Kabupaten</th>
                                <th class="px-4 py-3">Nama Kecamatan</th>
                                <th class="px-4 py-3">Nama Desa</th>
                                <th class="px-4 py-3">Kode Desa/Kelurahan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
                <div id="loadingIndicator" class="hidden flex justify-center my-6">
                    <span class="loading loading-spinner loading-lg text-white"></span>
                </div>



                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-4 flex justify-center">
                    <div id="pagination" class="join">
                        <!-- Akan diisi dengan JavaScript atau Blade -->
                        <button class="join-item btn">«</button>
                        <button class="join-item btn">Page 1</button>
                        <button class="join-item btn">»</button>
                    </div>
                </nav>

                <div class="my-6 bg-white rounded-md" id="chartContainer">
                    <div class="flex justify-center p-2">
                        <h2 class="text-lg md:text-2xl font-bold text-gray-800">Statistik potensi berdasarkan Provinsi
                        </h2>
                    </div>
                    <canvas id="dummyChart" height="120"></canvas>
                </div>

                <div class="mt-6 hidden overflow-x-auto rounded-xl" id="filteredTableContainer">
                    <div id="filteredCardWrapper"></div>
                </div>

                <div id="notFoundMessage"
                    class="hidden mt-6 mx-auto max-w-md bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg shadow text-center text-sm items-center justify-center gap-4">
                    <div>
                        <strong>😕 Oops! Data tidak ditemukan.</strong><br>
                        Coba ubah filter atau kata kunci pencarian Anda.<br>
                        <small class="text-xs">Pastikan pencarian lebih spesifik atau coba dengan kata kunci
                            lain.</small>
                    </div>
                </div>


            </div>
        </div>
    </div>

</body>

</html>
