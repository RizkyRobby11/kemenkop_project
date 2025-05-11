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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.provinsi-radio').on('change', function () {
            var provinsi = $(this).val();
            $.ajax({
                url: '{{ route("podes.getKabupaten") }}',
                type: 'GET',
                data: { provinsi: provinsi },
                success: function (kabupatens) {
                    let container = $('#kabupaten-container');
                    container.empty(); // kosongkan dulu

                    kabupatens.forEach(function (kab) {
                        container.append(
                            `<label class="flex items-center gap-2">
                                <input type="radio" name="kabupaten" value="${kab}" class="radio kabupaten-radio">
                                ${kab}
                            </label>`
                        );
                    });
                }
            });
        });
    });
</script>

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
                            <label class="input w-3/4 md:w-[85%] lg:w-[93%]">
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

                                <form method="POST" action="{{ route('podes.filter') }}" enctype="multipart/form-data">
                                    @csrf
                                    <h3 class="text-lg font-bold mb-2">Provinsi</h3>
                                    <hr class="mb-4">
                                    <!-- Checkbox list -->
                                    <div id="kabupaten-container" class="space-y-2 max-h-64 overflow-y-auto">
                                        @foreach ($provinsi as $item)
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="provinsi" value="{{ $item->COL_1 }}" class="radio provinsi-radio">
                                            {{ $item->COL_1 }}
                                        </label>
                                        @endforeach

                                        <!-- Tambahkan provinsi lainnya sesuai kebutuhan -->
                                    </div>

                                    <h3 class="text-lg font-bold mb-2">Kabupaten</h3>
                                    <hr class="mb-4">
                                    <!-- Checkbox list -->
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        @foreach ($kabupaten as $item)
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kabupaten" value="{{ $item->COL_2 }}" class="radio">
                                            {{ $item->COL_2 }}
                                        </label>
                                        @endforeach

                                        <!-- Tambahkan provinsi lainnya sesuai kebutuhan -->
                                    </div>

                                    <h3 class="text-lg font-bold mb-2">Kecamatan</h3>
                                    <hr class="mb-4">
                                    <!-- Checkbox list -->
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        @foreach ($kecamatan as $item)
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="kecamatan" value="{{ $item->COL_3 }}" class="radio">
                                            {{ $item->COL_3 }}
                                        </label>
                                        @endforeach

                                        <!-- Tambahkan provinsi lainnya sesuai kebutuhan -->
                                    </div>

                                    <h3 class="text-lg font-bold mb-2">Desa/Kelurahan</h3>
                                    <hr class="mb-4">

                                    <!-- Checkbox list -->
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        @foreach ($desa as $item)
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="desa" value="{{ $item->COL_4 }}" class="radio">
                                            {{ $item->COL_4 }}
                                        </label>
                                        @endforeach

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

                    <div class="overflow-x-auto rounded-lg shadow-md bg-red-400 dark:bg-gray-300">
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead class="sticky top-0 bg-[#3c6795] text-[#dbf2ff] text-xs uppercase">
                                <tr>

                                    <th class="px-4 py-3">No</th>
                                    @foreach ($labels as $label )
                                    <th>
                                        {{ $label }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300 dark:divide-gray-400">
                                <!-- row 1 -->
                                @foreach ($filteredData as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @for ($i = 1; $i <= 45; $i++)
                                        <td class="px-4 py-3 text-sm">
                                            {{ $item->{ 'COL_' . $i } }}
                                        </td>

                                    @endfor
                                </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $filteredData->links() }}
            </div>
        </div>
        <!-- /card -->

    </div>
</body>

</html>
