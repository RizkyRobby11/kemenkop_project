<!DOCTYPE html>
<html lang="en" class="light scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/d8c46daaeb.js" crossorigin="anonymous"></script>

</head>

<body class="font-[Inter]">

    {{-- NAVBAR START --}}
    <div class="navbar ">
        <a href="/" class=" text-xl">
            <img src="{{ asset('images/logo/logo-kemenkop.png') }}" alt="logo kementerian koperasi" class="w-48">
        </a>
    </div>
    {{-- NAVBAR END --}}

    <div class="flex flex-1 flex-col md:flex-row lg:flex-row">
        <div class="overflow-hidden shadow w-full">
            <div class="bg-white w-full py-16 px-5 min-h-screen h-auto">

                {{-- TITLE START --}}
                <div class="container mx-auto px-4">
                    <div class="mb-5 text-center">
                        <h2 class="text-4xl font-bold text-[#0E5367] uppercase">Hasil Pengolahan Podes 2024</h2>
                    </div>
                </div>
                {{-- TITLE END --}}

                {{-- FILTER START --}}

                <div class="w-full lg:flex lg:justify-between">
                    <div class="flex flex-wrap w-full lg:w-auto justify-center lg:justify-start gap-2">
                        <!-- Provinsi -->
                        <div class="dropdown dropdown-bottom">
                            <select id="provinsiSelect" aria-label="Select province"
                                class="btn m-1 px-4 py-2 rounded-lg font-semibold bg-[#A1BB3A] text-[#f8f8ff] border-2 focus:border-[#E5A821] focus:ring-2 focus:ring-[#A1BB3A] transition disabled:bg-gray-100 disabled:text-gray-400 disabled:border-gray-200">
                                <option selected>Pilih Provinsi</option>
                            </select>
                        </div>

                        <!-- Kabupaten -->
                        <div class="dropdown dropdown-bottom">
                            <select id="kabupatenSelect" aria-label="Select kabupaten"
                                class="btn m-1 px-4 py-2 rounded-lg font-semibold bg-[#A1BB3A] text-[#f8f8ff] border-2 focus:border-[#E5A821] focus:ring-2 focus:ring-[#A1BB3A] transition disabled:bg-gray-100 disabled:text-gray-400 disabled:border-gray-200"
                                disabled>
                                <option selected>Pilih Kabupaten</option>
                            </select>
                        </div>

                        <!-- Kecamatan -->
                        <div class="dropdown dropdown-bottom">
                            <select id="kecamatanSelect" aria-label="Select kecamatan"
                                class="btn m-1 px-4 py-2 rounded-lg font-semibold bg-[#A1BB3A] text-[#f8f8ff] border-2 focus:border-[#E5A821] focus:ring-2 focus:ring-[#A1BB3A] transition disabled:bg-gray-100 disabled:text-gray-400 disabled:border-gray-200"
                                disabled>
                                <option selected>Pilih Kecamatan</option>
                            </select>
                        </div>

                        <!-- Desa -->
                        <div class="dropdown dropdown-bottom">
                            <select id="desaSelect" aria-label="Select desa"
                                class="btn m-1 px-4 py-2 rounded-lg font-semibold bg-[#A1BB3A] text-[#f8f8ff] border-2 focus:border-[#E5A821] focus:ring-2 focus:ring-[#A1BB3A] transition disabled:bg-gray-100 disabled:text-gray-400 disabled:border-gray-200"
                                disabled>
                                <option selected>Pilih Desa/Kelurahan</option>
                            </select>
                        </div>
                    </div>

                </div>
                {{-- FILTER END --}}


                {{-- TABLE WILAYAH START --}}

                <div class="mt-2 bg-white overflow-x-auto rounded-xl shadow-lg">
                    <table class="table min-w-max text-sm text-left text-[#22223B] bg-white border border-[#0E5367] "
                        id="podesTable">
                        <thead class="bg-[#0E5367] text-white uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Nama Provinsi</th>
                                <th class="px-4 py-3">Nama Kabupaten</th>
                                <th class="px-4 py-3">Nama Kecamatan</th>
                                <th class="px-4 py-3">Nama Desa</th>
                                <th class="px-4 py-3">Kode Desa/Kelurahan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#A1BB3A]">
                        </tbody>
                    </table>
                </div>
                <div id="loadingIndicator" class="hidden flex justify-center my-6">
                    <span class="loading loading-spinner loading-lg text-white"></span>
                </div>
                {{-- TABLE WILAYAH END --}}



                {{-- PAGINATION START --}}
                <nav aria-label="Page navigation" class="mt-4 flex justify-center">
                    <div id="pagination" class="join">
                        <!-- Akan diisi dengan JavaScript atau Blade -->
                        <button class="join-item btn">«</button>
                        <button class="join-item btn">Page 1</button>
                        <button class="join-item btn">»</button>
                    </div>
                </nav>
                {{-- PAGINATION END --}}

                {{-- CHART PROVINSI START --}}

                <div class="my-6 bg-white rounded-md" id="chartContainer">
                    <div class="flex justify-center p-2">
                        <h2 class="text-lg md:text-2xl font-bold text-gray-800">Statistik potensi berdasarkan Provinsi
                        </h2>
                    </div>
                    <canvas id="dummyChart" height="120"></canvas>
                </div>
                {{-- CHART PROVINSI END --}}

                {{-- POTENTIAL CARD BASE ON REGION OR DESA/KELURAHAN START --}}

                <div class="mt-6 hidden overflow-x-auto rounded-xl" id="filteredTableContainer">
                    <div id="filteredCardWrapper"></div>
                </div>
                {{-- POTENTIAL CARD BASE ON REGION OR DESA/KELURAHAN END --}}

                {{-- DETAIL POTENTIAL START --}}
                <div class="mt-2 bg-white overflow-x-auto rounded-xl shadow-lg" id="detailPotentialTableContainer">
                    <table class="table min-w-max text-sm text-left text-[#22223B] bg-white border border-[#E5A821] "
                        id="detailPotentialTable">
                        <thead id="detailPotentialTableThead" class="bg-[#E5A821] text-white uppercase text-xs hidden">
                            <tr>

                            </tr>
                        </thead>
                        <tbody id="detailPotentialTableTBody" class="divide-y divide-[#A1BB3A] hidden">
                        </tbody>
                    </table>
                </div>
                <div id="loadingIndicator" class="hidden flex justify-center my-6">
                    <span class="loading loading-spinner loading-lg text-white"></span>
                </div>
                {{-- DETAIL POTENTIAL END --}}

                {{-- <div id="notFoundMessage"
                    class="hidden mt-6 mx-auto max-w-md bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg shadow text-center text-sm items-center justify-center gap-4">
                    <div>
                        <strong>😕 Oops! Data tidak ditemukan.</strong><br>
                        Coba ubah filter atau kata kunci pencarian Anda.<br>
                        <small class="text-xs">Pastikan pencarian lebih spesifik atau coba dengan kata kunci
                            lain.</small>
                    </div>
                </div> --}}


            </div>
        </div>
    </div>

</body>

</html>
