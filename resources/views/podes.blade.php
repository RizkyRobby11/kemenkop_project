<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>DATABASE</title>
</head>

<body>
    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">

        <!-- card -->

        <div class="rounded overflow-hidden shadow bg-red-400 mx-2 w-full">
            <div class="px-6 py-2 border-b border-light-grey">
                <div class="font-bold text-xl text-white">PODES 2025</div>
            </div>
            <div class="bg-gray-50 py-16">
                <div class="container mx-auto px-4">
                    <div class="mb-12 text-center">
                        <h2 class="mb-4 text-4xl font-bold text-[#2563EA]">Discover Our Products</h2>
                        {{-- <p class="mx-auto max-w-3xl text-xl text-gray-700">
                            Explore our range of high-quality cement products designed to meet the needs of any construction
                            project, from small residential builds to large commercial developments.
                        </p> --}}
                    </div>
                    <div class="overflow-x-auto bg-slate-600/50 rounded-2xl">
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Desa</th>
                                    <th>Nama Kabupaten</th>
                                    <th>Nama Kecamatan</th>
                                    <th>Nama Provinsi</th>
                                    <th>INDUSTRI MIKRO DAN KECIL KULIT BARANG DARI KULIT DAN ALAS KAKI TAS SEPATU SANDAL
                                        IKAT
                                        PINGGANG DLL</th>
                                    <th>INDUSTRI MIKRO DAN KECIL PERCETAKAN DAN REPRODUKSI MEDIA REKAMAN BUKU BROSUR
                                        KARTU NAMA
                                        KALENDER SPANDUK DLL</th>
                                    <th>INDUSTRI MIKRO DAN KECIL ALAT ANGKUTAN LAINNYA PERAHU KLOTOK RAKIT KURSI RODA
                                        DLL</th>
                                    <th>INDUSTRI MIKRO DAN KECIL KERAJINAN DAN LAINNYA KERAJINAN TANGAN MAINAN ANAK ANAK
                                        BATU
                                        AKIK PERHIASAN EMAS IMITASI</th>
                                    <th>REPARASI DAN PEMASANGAN MESIN DAN PERALATAN LAS KELILING REPARASI DINAMO
                                        REPARASI MESIN
                                        PENGGILING PADI DLL</th>
                                    <th>INDUSTRI MIKRO DAN KECIL LAINNYA TULISKAN</th>
                                    <th>INDUSTRI MIKRO DAN KECIL FURNITUR DARI KAYU ROTAN BAMBU PLASTIK LOGAM MEJA KURSI
                                        TEMPAT
                                        TIDUR LEMARI DLL</th>
                                    <th>INDUSTRI MIKRO DAN KECIL BARANG LOGAM BUKAN MESIN DAN PERALATANNYA TERALIS PAGAR
                                        SABIT
                                        PISAU PARANG GUNTING SENDOK GOLOK DLL</th>
                                    <th>INDUSTRI MIKRO DAN KECIL TEKSTIL KAIN ULOS KAIN SONGKET KAIN TENUN DAN
                                        PERCETAKAN BATIK
                                        DLL</th>
                                    <th>INDUSTRI MIKRO DAN KECIL PAKAIAN JADI KONVEKSI PAKAIAN KEMEJA ROK CELANA MUKENA
                                        BORDIR
                                    </th>
                                    <th>INDUSTRI MIKRO DAN KECIL BARANG GALIAN BUKAN LOGAM INDUSTRI GERABAH KERAMIK BATU
                                        BATA
                                        GENTENG BATU BATA PORSELIN TEGEL KERAMIK KACA PATRI CANGKIR GUCI DLL</th>
                                    <th>JUMLAH KOPERASI UNIT DESA KUD YANG MASIH AKTIF UNIT</th>
                                    <th>JUMLAH KOPERASI INDUSTRI KECIL DAN KERAJINAN RAKYAT KOPINKRA YANG MASIH AKTIF
                                        UNIT</th>
                                    <th>JUMLAH KOPERASI SIMPAN PINJAM KOSPIN YANG MASIH AKTIF UNIT</th>
                                    <th>JUMLAH KOPERASI LAINNYA YANG MASIH AKTIF UNIT</th>
                                    <th>JUMLAH BAITUL MAAL WA TANWIL BMT</th>
                                    <th>JUMLAH ATM</th>
                                    <th>JUMLAH AGEN BANK</th>
                                    <th>JUMLAH PERUSAHAAN PEMBIAYAAN</th>
                                    <th>JUMLAH PEDAGANG VALUTA ASING</th>
                                    <th>JUMLAH PERGADAIAN</th>
                                    <th>JUMLAH AGEN TIKET TRAVEL BIRO PERJALANAN</th>
                                    <th>JUMLAH BENGKEL MOBIL MOTOR</th>
                                    <th>JUMLAH SALON KECANTIKAN</th>
                                    <th>JUMLAH KELOMPOK PERTOKOAN</th>
                                    <th>JUMLAH PASAR DENGAN BANGUNAN PERMANEN</th>
                                    <th>JUMLAH PASAR DENGAN BANGUNAN SEMI PERMANEN</th>
                                    <th>JUMLAH PASAR TANPA BANGUNAN</th>
                                    <th>JUMLAH MINIMARKET SWALAYAN SUPERMARKET</th>
                                    <th>JUMLAH RESTORAN RUMAH MAKANN</th>
                                    <th>JUMLAH WARUNG KEDAI MAKANAN MINUMAN</th>
                                    <th>JUMLAH HOTEL</th>
                                    <th>JUMLAH PENGINAPAN</th>
                                    <th>JUMLAH TOKO WARUNG KELONTONG</th>

                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                <tr>
                                    <th>1</th>
                                    <td>Cy Ganderton</td>
                                    <td>Quality Control Specialist</td>
                                    <td>Blue</td>
                                    <td>Blue</td>
                                </tr>
                                <!-- row 2 -->
                                <tr>
                                    <th>2</th>
                                    <td>Hart Hagerty</td>
                                    <td>Desktop Support Technician</td>
                                    <td>Purple</td>
                                    <td>Purple</td>
                                </tr>
                                <!-- row 3 -->
                                <tr>
                                    <th>3</th>
                                    <td>Brice Swyre</td>
                                    <td>Tax Accountant</td>
                                    <td>Red</td>
                                </tr>
                                <!-- row 3 -->
                                <tr>
                                    <th>3</th>
                                    <td>Brice Swyre</td>
                                    <td>Tax Accountant</td>
                                    <td>Red</td>
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
