$(document).ready(function () {
    // Load all provinsi
    $.get("{{ route('provinsi.all') }}", function (data) {
        data.forEach(function (provinsi) {
            $("#provinsi").append(
                `<option value="${provinsi.kode_provinsi}">${provinsi.nama_provinsi}</option>`
            );
        });
    });

    // Load kabupaten based on selected provinsi
    $("#provinsi").change(function () {
        const kodeProvinsi = $(this).val();
        $("#kabupaten")
            .empty()
            .append('<option value="">-- Select Kabupaten --</option>');
        $("#kecamatan")
            .empty()
            .append('<option value="">-- Select Kecamatan --</option>');
        $("#kelurahan")
            .empty()
            .append('<option value="">-- Select Kelurahan --</option>');

        if (kodeProvinsi) {
            $.get(`/kabupaten/${kodeProvinsi}`, function (data) {
                data.forEach(function (kabupaten) {
                    $("#kabupaten").append(
                        `<option value="${kabupaten.kode_kabupaten_kota}">${kabupaten.nama_kabupaten_kota}</option>`
                    );
                });
            });
        }
    });

    // Load kecamatan based on selected kabupaten
    $("#kabupaten").change(function () {
        const kodeKabupaten = $(this).val();
        $("#kecamatan")
            .empty()
            .append('<option value="">-- Select Kecamatan --</option>');
        $("#kelurahan")
            .empty()
            .append('<option value="">-- Select Kelurahan --</option>');

        if (kodeKabupaten) {
            $.get(`/kecamatan/${kodeKabupaten}`, function (data) {
                data.forEach(function (kecamatan) {
                    $("#kecamatan").append(
                        `<option value="${kecamatan.kode_kecamatan}">${kecamatan.nama_kecamatan}</option>`
                    );
                });
            });
        }
    });

    // Load kelurahan based on selected kecamatan
    $("#kecamatan").change(function () {
        const kodeKecamatan = $(this).val();
        $("#kelurahan")
            .empty()
            .append('<option value="">-- Select Kelurahan --</option>');

        if (kodeKecamatan) {
            $.get(`/kelurahan/${kodeKecamatan}`, function (data) {
                data.forEach(function (kelurahan) {
                    $("#kelurahan").append(
                        `<option value="${kelurahan.kode_desa_kelurahan}">${kelurahan.nama_desa_kelurahan}</option>`
                    );
                });
            });
        }
    });
});
