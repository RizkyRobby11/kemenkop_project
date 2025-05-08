<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="https://kit.fontawesome.com/d8c46daaeb.js" crossorigin="anonymous"></script>
    <title>DATABASE</title>
</head>

<body>
    <div class="flex flex-1 flex-col md:flex-row lg:flex-row">

        <!-- card -->
        <div class="overflow-hidden shadow w-full">
            <div class="bg-[#42aafa] w-full py-16 px-5 h-screen">
                <div class="container mx-auto px-4">
                    <div class="mb-5 text-center">
                        <h2 class="text-4xl font-bold text-white uppercase">Hasil Pengolahan Podes 2024</h2>
                        {{-- <p class="mx-auto max-w-3xl text-xl text-gray-700">
                            Explore our range of high-quality cement products designed to meet the needs of any construction
                            project, from small residential builds to large commercial developments.
                        </p> --}}
                    </div>
                    <div class="w-full flex justify-end items-center gap-2 mb-3">
                        <div class="w-full flex justify-between">
                            <label class="input">
                                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                        stroke="currentColor">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </g>
                                </svg>
                                <input type="search" class="grow" placeholder="Search" />

                            </label>
                            <!-- Tombol open modal -->
                            <button class="btn bg-white text-[#693d00]"
                                onclick="my_modal_3.showModal()"><!-- Ikon filter -->
                                <i class="fa-solid fa-filter"></i> Filter</button>
                        </div>


                        <!-- Modal -->
                        <dialog id="my_modal_3" class="modal ">
                            <div class="modal-box">
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                </form>

                                <form method="POST" action="" enctype="multipart/form-data">
                                    <h3 class="text-lg font-bold mb-2">Provinsi</h3>
                                    <hr class="mb-4">
                                    <!-- Checkbox list -->
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="Jawa Barat" class="radio">
                                            Jawa Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="Jawa Tengah" class="radio">
                                            Jawa Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="Jawa Timur" class="radio">
                                            Jawa Timur
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta" class="radio">
                                            DKI Jakarta
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta" class="radio">
                                            Aceh
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta" class="radio">
                                            Sumatera Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta" class="radio">
                                            Sumatera Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta" class="radio">
                                            Sumatera Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta" class="radio">
                                            Riau
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta" class="radio">
                                            Kepulauan Riau
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta" class="radio">
                                            Jambi
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta" class="radio">
                                            Bangka Belitung
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Bengkulu
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Lampung
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Banten
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            DI Yogyakarta
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Bali
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Nusa Tenggara Barat (NTB)
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Nusa Tenggara Timur (NTT)
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Timur
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Gorontalo
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Tenggara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Maluku
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Maluku Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Papua
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Papua Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Papua Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Papua Pegunungan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Papua Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="DKI Jakarta"
                                                class="radio">
                                            Papua Barat Daya
                                        </label>
                                        <!-- Tambahkan provinsi lainnya sesuai kebutuhan -->
                                    </div>

                                    <h3 class="text-lg font-bold mb-2">Kabupaten</h3>
                                    <hr class="mb-4">
                                    <!-- Checkbox list -->
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="Jawa Barat"
                                                class="radio">
                                            Jawa Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="Jawa Tengah"
                                                class="radio">
                                            Jawa Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="Jawa Timur"
                                                class="radio">
                                            Jawa Timur
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            DKI Jakarta
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Aceh
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Sumatera Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Sumatera Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Sumatera Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Riau
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Kepulauan Riau
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Jambi
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Bangka Belitung
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Bengkulu
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Lampung
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Banten
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            DI Yogyakarta
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Bali
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Nusa Tenggara Barat (NTB)
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Nusa Tenggara Timur (NTT)
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Timur
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Gorontalo
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Tenggara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Maluku
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Maluku Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Papua
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Papua Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Papua Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Papua Pegunungan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Papua Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="DKI Jakarta"
                                                class="radio">
                                            Papua Barat Daya
                                        </label>
                                        <!-- Tambahkan provinsi lainnya sesuai kebutuhan -->
                                    </div>

                                    <h3 class="text-lg font-bold mb-2">Kecamatan</h3>
                                    <hr class="mb-4">
                                    <!-- Checkbox list -->
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="Jawa Barat"
                                                class="radio">
                                            Jawa Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="Jawa Tengah"
                                                class="radio">
                                            Jawa Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="Jawa Timur"
                                                class="radio">
                                            Jawa Timur
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            DKI Jakarta
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Aceh
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Sumatera Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Sumatera Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Sumatera Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Riau
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Kepulauan Riau
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Jambi
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Bangka Belitung
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Bengkulu
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Lampung
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Banten
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            DI Yogyakarta
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Bali
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Nusa Tenggara Barat (NTB)
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Nusa Tenggara Timur (NTT)
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Timur
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Kalimantan Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Gorontalo
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Sulawesi Tenggara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Maluku
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Maluku Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Papua
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Papua Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Papua Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Papua Pegunungan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Papua Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="DKI Jakarta"
                                                class="radio">
                                            Papua Barat Daya
                                        </label>
                                        <!-- Tambahkan provinsi lainnya sesuai kebutuhan -->
                                    </div>

                                    <h3 class="text-lg font-bold mb-2">Desa/Kelurahan</h3>
                                    <hr class="mb-4">

                                    <!-- Checkbox list -->
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="Jawa Barat" class="radio">
                                            Jawa Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="Jawa Tengah" class="radio">
                                            Jawa Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="Jawa Timur" class="radio">
                                            Jawa Timur
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            DKI Jakarta
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Aceh
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Sumatera Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Sumatera Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Sumatera Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Riau
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Kepulauan Riau
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Jambi
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Bangka Belitung
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Bengkulu
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Lampung
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Banten
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            DI Yogyakarta
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Bali
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Nusa Tenggara Barat (NTB)
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Nusa Tenggara Timur (NTT)
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Kalimantan Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Kalimantan Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Kalimantan Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Kalimantan Timur
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Kalimantan Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Gorontalo
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Sulawesi Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Sulawesi Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Sulawesi Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Sulawesi Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Sulawesi Tenggara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Maluku
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Maluku Utara
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Papua
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Papua Barat
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Papua Tengah
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Papua Pegunungan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Papua Selatan
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="DKI Jakarta" class="radio">
                                            Papua Barat Daya
                                        </label>
                                        <!-- Tambahkan provinsi lainnya sesuai kebutuhan -->
                                    </div>

                                    <!-- Tombol submit -->
                                    <div class="mt-4 text-right">
                                        <button type="submit"
                                            class="btn bg-white text-black hover:bg-slate-600 hover:text-white">Terapkan</button>
                                    </div>
                                </form>
                            </div>

                        </dialog>
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow-md bg-white dark:bg-gray-300">
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead class="sticky top-0 bg-[#3c6795] text-[#dbf2ff] text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Nama Desa</th>
                                    <th class="px-4 py-3">Nama Kabupaten</th>
                                    <th class="px-4 py-3">Nama Kecamatan</th>
                                    <th class="px-4 py-3">Nama Provinsi</th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL KULIT BARANG DARI KULIT DAN ALAS
                                        KAKI TAS SEPATU SANDAL
                                        IKAT
                                        PINGGANG DLL</th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL PERCETAKAN DAN REPRODUKSI MEDIA
                                        REKAMAN BUKU BROSUR
                                        KARTU NAMA
                                        KALENDER SPANDUK DLL</th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL ALAT ANGKUTAN LAINNYA PERAHU KLOTOK
                                        RAKIT KURSI RODA
                                        DLL</th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL KERAJINAN DAN LAINNYA KERAJINAN
                                        TANGAN MAINAN ANAK ANAK
                                        BATU
                                        AKIK PERHIASAN EMAS IMITASI</th>
                                    <th class="px-4 py-3">REPARASI DAN PEMASANGAN MESIN DAN PERALATAN LAS KELILING
                                        REPARASI DINAMO
                                        REPARASI MESIN
                                        PENGGILING PADI DLL</th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL LAINNYA TULISKAN</th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL FURNITUR DARI KAYU ROTAN BAMBU
                                        PLASTIK LOGAM MEJA KURSI
                                        TEMPAT
                                        TIDUR LEMARI DLL</th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL BARANG LOGAM BUKAN MESIN DAN
                                        PERALATANNYA TERALIS PAGAR
                                        SABIT
                                        PISAU PARANG GUNTING SENDOK GOLOK DLL</th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL TEKSTIL KAIN ULOS KAIN SONGKET KAIN
                                        TENUN DAN
                                        PERCETAKAN BATIK
                                        DLL</th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL PAKAIAN JADI KONVEKSI PAKAIAN KEMEJA
                                        ROK CELANA MUKENA
                                        BORDIR
                                    </th>
                                    <th class="px-4 py-3">INDUSTRI MIKRO DAN KECIL BARANG GALIAN BUKAN LOGAM INDUSTRI
                                        GERABAH KERAMIK BATU
                                        BATA
                                        GENTENG BATU BATA PORSELIN TEGEL KERAMIK KACA PATRI CANGKIR GUCI DLL</th>
                                    <th class="px-4 py-3">JUMLAH KOPERASI UNIT DESA KUD YANG MASIH AKTIF UNIT</th>
                                    <th class="px-4 py-3">JUMLAH KOPERASI INDUSTRI KECIL DAN KERAJINAN RAKYAT KOPINKRA
                                        YANG MASIH AKTIF
                                        UNIT</th>
                                    <th class="px-4 py-3">JUMLAH KOPERASI SIMPAN PINJAM KOSPIN YANG MASIH AKTIF UNIT
                                    </th>
                                    <th class="px-4 py-3">JUMLAH KOPERASI LAINNYA YANG MASIH AKTIF UNIT</th>
                                    <th class="px-4 py-3">JUMLAH BAITUL MAAL WA TANWIL BMT</th>
                                    <th class="px-4 py-3">JUMLAH ATM</th>
                                    <th class="px-4 py-3">JUMLAH AGEN BANK</th>
                                    <th class="px-4 py-3">JUMLAH PERUSAHAAN PEMBIAYAAN</th>
                                    <th class="px-4 py-3">JUMLAH PEDAGANG VALUTA ASING</th>
                                    <th class="px-4 py-3">JUMLAH PERGADAIAN</th>
                                    <th class="px-4 py-3">JUMLAH AGEN TIKET TRAVEL BIRO PERJALANAN</th>
                                    <th class="px-4 py-3">JUMLAH BENGKEL MOBIL MOTOR</th>
                                    <th class="px-4 py-3">JUMLAH SALON KECANTIKAN</th>
                                    <th class="px-4 py-3">JUMLAH KELOMPOK PERTOKOAN</th>
                                    <th class="px-4 py-3">JUMLAH PASAR DENGAN BANGUNAN PERMANEN</th>
                                    <th class="px-4 py-3">JUMLAH PASAR DENGAN BANGUNAN SEMI PERMANEN</th>
                                    <th class="px-4 py-3">JUMLAH PASAR TANPA BANGUNAN</th>
                                    <th class="px-4 py-3">JUMLAH MINIMARKET SWALAYAN SUPERMARKET</th>
                                    <th class="px-4 py-3">JUMLAH RESTORAN RUMAH MAKANN</th>
                                    <th class="px-4 py-3">JUMLAH WARUNG KEDAI MAKANAN MINUMAN</th>
                                    <th class="px-4 py-3">JUMLAH HOTEL</th>
                                    <th class="px-4 py-3">JUMLAH PENGINAPAN</th>
                                    <th class="px-4 py-3">JUMLAH TOKO WARUNG KELONTONG</th>

                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-400">
                                <!-- row 1 -->
                                <tr>
                                    <th>1</th>
                                    <td>Cy Ganderton</td>
                                    <td>Quality Control Specialist</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                </tr>
                                <!-- row 2 -->
                                <tr>
                                    <th>2</th>
                                    <td>Hart Hagerty</td>
                                    <td>Desktop Support Technician</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                </tr>
                                <!-- row 3 -->
                                <tr>
                                    <th>3</th>
                                    <td>Brice Swyre</td>
                                    <td>Tax Accountant</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                </tr>
                                <!-- row 3 -->
                                <tr>
                                    <th>3</th>
                                    <td>Brice Swyre</td>
                                    <td>Tax Accountant</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /card -->

    </div>
</body>

</html>
