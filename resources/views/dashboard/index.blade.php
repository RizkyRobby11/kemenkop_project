<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite('resources/js/app.js')
</head>

<body>
    <div class="container">
        <h1>Dashboard</h1>
        <select class="form-select" aria-label="Select province" id="provinsiSelect">
            <option selected>Pilih Provinsi</option>
        </select>
        <select class="form-select mt-3" aria-label="Select kabupaten" id="kabupatenSelect" disabled>
            <option selected>Pilih Kabupaten</option>
        </select>
        <select class="form-select mt-3" aria-label="Select kecamatan" id="kecamatanSelect" disabled>
            <option selected>Pilih Kecamatan</option>
        </select>
        <select class="form-select mt-3" aria-label="Select desa" id="desaSelect" disabled>
            <option selected>Pilih Desa/Kelurahan</option>
        </select>

        <div class="mt-4">
            <table class="table table-bordered" id="podesTable">
                <thead>
                    <tr>
                        <th>Nama Desa/Kelurahan</th>
                        <th>Kode Desa/Kelurahan</th>
                        @foreach($labels as $label)
                            <th>{{ $label->{'COL 1'} }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <nav aria-label="Page navigation" class="mt-3">
                <ul class="pagination" id="pagination"></ul>
            </nav>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Mengambil data provinsi dari endpoint
            $.get('/provinsi', function (data) {
                data.forEach(function (provinsi) {
                    $('#provinsiSelect').append(
                        `<option value="${provinsi.kode_provinsi}">${provinsi.nama_provinsi}</option>`
                    );
                });
            });

            // Event handler saat provinsi dipilih
            $('#provinsiSelect').change(function () {
                const kodeProvinsi = $(this).val();
                const namaProvinsi = $(this).find('option:selected').text();

                // Reset dan disable dropdown kabupaten, kecamatan, dan desa jika pilihan default
                if (kodeProvinsi === "Pilih Provinsi") {
                    $('#kabupatenSelect').prop('disabled', true).html('<option selected>Pilih Kabupaten</option>');
                    $('#kecamatanSelect').prop('disabled', true).html('<option selected>Pilih Kecamatan</option>');
                    $('#desaSelect').prop('disabled', true).html('<option selected>Pilih Desa/Kelurahan</option>');
                    return;
                }

                // Enable dropdown kabupaten dan reset dropdown lainnya
                $('#kabupatenSelect').prop('disabled', false);
                $('#kecamatanSelect').prop('disabled', true).html('<option selected>Pilih Kecamatan</option>');
                $('#desaSelect').prop('disabled', true).html('<option selected>Pilih Desa/Kelurahan</option>');

                // Mengambil data kabupaten berdasarkan provinsi
                $.get(`/kabupatenbyprovinsi?provinsi=${kodeProvinsi}`, function (data) {
                    $('#kabupatenSelect').html('<option selected>Pilih Kabupaten</option>');
                    data.forEach(function (kabupaten) {
                        $('#kabupatenSelect').append(
                            `<option value="${kabupaten.kode_kabupaten_kota}">${kabupaten.nama_kabupaten_kota}</option>`
                        );
                    });
                });
            });

            // Event handler saat kabupaten dipilih
            $('#kabupatenSelect').change(function () {
                const kodeKabupaten = $(this).val();
                const namaKabupaten = $(this).find('option:selected').text();

                // Reset dan disable dropdown kecamatan dan desa jika pilihan default
                if (kodeKabupaten === "Pilih Kabupaten") {
                    $('#kecamatanSelect').prop('disabled', true).html('<option selected>Pilih Kecamatan</option>');
                    $('#desaSelect').prop('disabled', true).html('<option selected>Pilih Desa/Kelurahan</option>');
                    return;
                }

                // Enable dropdown kecamatan dan reset desa
                $('#kecamatanSelect').prop('disabled', false);
                $('#desaSelect').prop('disabled', true).html('<option selected>Pilih Desa/Kelurahan</option>');

                // Mengambil data kecamatan berdasarkan kabupaten
                $.get(`/kecamatanbykabupaten?kabupaten=${kodeKabupaten}`, function (data) {
                    $('#kecamatanSelect').html('<option selected>Pilih Kecamatan</option>');
                    data.forEach(function (kecamatan) {
                        $('#kecamatanSelect').append(
                            `<option value="${kecamatan.kode_kecamatan}">${kecamatan.nama_kecamatan}</option>`
                        );
                    });
                });
            });

            // Event handler saat kecamatan dipilih
            $('#kecamatanSelect').change(function () {
                const kodeKecamatan = $(this).val();
                const namaKecamatan = $(this).find('option:selected').text();

                // Reset dan disable dropdown desa jika pilihan default
                if (kodeKecamatan === "Pilih Kecamatan") {
                    $('#desaSelect').prop('disabled', true).html('<option selected>Pilih Desa/Kelurahan</option>');
                    return;
                }

                // Enable dropdown desa
                $('#desaSelect').prop('disabled', false);

                // Mengambil data desa berdasarkan kecamatan
                $.get(`/desakelurahanbykecamatan?kecamatan=${kodeKecamatan}`, function (data) {
                    $('#desaSelect').html('<option selected>Pilih Desa/Kelurahan</option>');
                    data.forEach(function (desa) {
                        $('#desaSelect').append(
                            `<option value="${desa.kode_desa_kelurahan}">${desa.nama_desa_kelurahan}</option>`
                        );
                    });
                });
            });

            // Event handler saat desa dipilih
            $('#desaSelect').change(function () {
                const kodeDesa = $(this).val();
                const namaDesa = $(this).find('option:selected').text();
                console.log('Desa/Kelurahan terpilih:', {
                    kode: kodeDesa,
                    nama: namaDesa
                });
            });

            function loadPodesData(page = 1) {
                const provinsi = $('#provinsiSelect').val();
                const kabupaten = $('#kabupatenSelect').val();
                const kecamatan = $('#kecamatanSelect').val();
                const desa = $('#desaSelect').val();

                let url = `/podesbyfilter?page=${page}`;
                if (provinsi && provinsi !== 'Pilih Provinsi') url += `&provinsi=${provinsi}`;
                if (kabupaten && kabupaten !== 'Pilih Kabupaten') url += `&kabupaten_kota=${kabupaten}`;
                if (kecamatan && kecamatan !== 'Pilih Kecamatan') url += `&kecamatan=${kecamatan}`;
                if (desa && desa !== 'Pilih Desa/Kelurahan') url += `&desa_kelurahan=${desa}`;

                $.get(url, function (response) {
                    // Populate table
                    let tableContent = '';
                    response.data.forEach(item => {
                        let row = '<tr>';
                        // Dynamically add all properties from item object
                        Object.keys(item).forEach(key => {
                            row += `<td>${item[key]}</td>`;
                        });
                        row += '</tr>';
                        tableContent += row;
                    });
                    $('#podesTable tbody').html(tableContent);

                    // Generate pagination
                    let paginationHtml = '';
                    response.links.forEach(link => {
                        if (link.url === null) {
                            paginationHtml += `
                                <li class="page-item disabled">
                                    <span class="page-link">${link.label}</span>
                                </li>
                            `;
                        } else {
                            paginationHtml += `
                                <li class="page-item ${link.active ? 'active' : ''}">
                                    <a class="page-link" href="#" data-page="${link.url.split('page=')[1]}">${link.label}</a>
                                </li>
                            `;
                        }
                    });
                    $('#pagination').html(paginationHtml);
                });
            }

            // Load initial data
            loadPodesData();

            // Handle pagination clicks
            $(document).on('click', '.pagination .page-link', function (e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) {
                    loadPodesData(page);
                }
            });

            // Update table when filters change
            $('#provinsiSelect, #kabupatenSelect, #kecamatanSelect, #desaSelect').change(function () {
                loadPodesData();
            });
        });
    </script>
</body>
</html>
