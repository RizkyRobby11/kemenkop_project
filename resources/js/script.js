$(document).ready(function () {
    // Mengambil data provinsi dari endpoint
    $.get("/provinsi", function (data) {
        data.forEach(function (provinsi) {
            $("#provinsiSelect").append(
                `<option value="${provinsi.kode_provinsi}">${provinsi.nama_provinsi}</option>`
            );
        });
    });

    // Event handler saat provinsi dipilih
    $("#provinsiSelect").change(function () {
        const kodeProvinsi = $(this).val();
        const namaProvinsi = $(this).find("option:selected").text();

        // Reset dan disable dropdown kabupaten, kecamatan, dan desa jika pilihan default
        if (kodeProvinsi === "Pilih Provinsi") {
            $("#kabupatenSelect")
                .prop("disabled", true)
                .html("<option selected>Pilih Kabupaten</option>");
            $("#kecamatanSelect")
                .prop("disabled", true)
                .html("<option selected>Pilih Kecamatan</option>");
            $("#desaSelect")
                .prop("disabled", true)
                .html("<option selected>Pilih Desa/Kelurahan</option>");
            return;
        }

        // Enable dropdown kabupaten dan reset dropdown lainnya
        $("#kabupatenSelect").prop("disabled", false);
        $("#kecamatanSelect")
            .prop("disabled", true)
            .html("<option selected>Pilih Kecamatan</option>");
        $("#desaSelect")
            .prop("disabled", true)
            .html("<option selected>Pilih Desa/Kelurahan</option>");

        // Mengambil data kabupaten berdasarkan provinsi
        $.get(`/provinsi/${kodeProvinsi}/kabupatenkota`, function (data) {
            $("#kabupatenSelect").html(
                "<option selected>Pilih Kabupaten</option>"
            );
            data.forEach(function (kabupaten) {
                $("#kabupatenSelect").append(
                    `<option value="${kabupaten.kode_kabupaten_kota}">${kabupaten.nama_kabupaten_kota}</option>`
                );
            });
        });
    });

    // Event handler saat kabupaten dipilih
    $("#kabupatenSelect").change(function () {
        const kodeKabupaten = $(this).val();
        const namaKabupaten = $(this).find("option:selected").text();

        // Reset dan disable dropdown kecamatan dan desa jika pilihan default
        if (kodeKabupaten === "Pilih Kabupaten") {
            $("#kecamatanSelect")
                .prop("disabled", true)
                .html("<option selected>Pilih Kecamatan</option>");
            $("#desaSelect")
                .prop("disabled", true)
                .html("<option selected>Pilih Desa/Kelurahan</option>");
            return;
        }

        // Enable dropdown kecamatan dan reset desa
        $("#kecamatanSelect").prop("disabled", false);
        $("#desaSelect")
            .prop("disabled", true)
            .html("<option selected>Pilih Desa/Kelurahan</option>");

        // Mengambil data kecamatan berdasarkan kabupaten
        $.get(`/kabupatenkota/${kodeKabupaten}/kecamatan`, function (data) {
            $("#kecamatanSelect").html(
                "<option selected>Pilih Kecamatan</option>"
            );
            data.forEach(function (kecamatan) {
                $("#kecamatanSelect").append(
                    `<option value="${kecamatan.kode_kecamatan}">${kecamatan.nama_kecamatan}</option>`
                );
            });
        });
    });

    // Event handler saat kecamatan dipilih
    $("#kecamatanSelect").change(function () {
        const kodeKecamatan = $(this).val();
        const namaKecamatan = $(this).find("option:selected").text();

        // Reset dan disable dropdown desa jika pilihan default
        if (kodeKecamatan === "Pilih Kecamatan") {
            $("#desaSelect")
                .prop("disabled", true)
                .html("<option selected>Pilih Desa/Kelurahan</option>");
            return;
        }

        // Enable dropdown desa
        $("#desaSelect").prop("disabled", false);

        // Mengambil data desa berdasarkan kecamatan
        $.get(`/kecamatan/${kodeKecamatan}/desakelurahan`, function (data) {
            $("#desaSelect").html(
                "<option selected>Pilih Desa/Kelurahan</option>"
            );
            data.forEach(function (desa) {
                $("#desaSelect").append(
                    `<option value="${desa.kode_desa_kelurahan}">${desa.nama_desa_kelurahan}</option>`
                );
            });
        });
    });

    // Event handler saat desa dipilih
    $("#desaSelect").change(function () {
        const kodeDesa = $(this).val();
        const namaDesa = $(this).find("option:selected").text();
        console.log("Desa/Kelurahan terpilih:", {
            kode: kodeDesa,
            nama: namaDesa,
        });
    });

    // Define loadPodesData in global scope
    window.loadPodesData = function (page = 1, isSearch = false) {
        const provinsi = $("#provinsiSelect").val();
        const kabupaten = $("#kabupatenSelect").val();
        const kecamatan = $("#kecamatanSelect").val();
        const desa = $("#desaSelect").val();
        const searchQuery = $("#search").val();

        let url = isSearch ? "/search" : "/filter";
        url += `?page=${page}`;

        if (!isSearch) {
            if (provinsi && provinsi !== "Pilih Provinsi")
                url += `&provinsi=${provinsi}`;
            if (kabupaten && kabupaten !== "Pilih Kabupaten")
                url += `&kabupaten_kota=${kabupaten}`;
            if (kecamatan && kecamatan !== "Pilih Kecamatan")
                url += `&kecamatan=${kecamatan}`;
            if (desa && desa !== "Pilih Desa/Kelurahan")
                url += `&desa_kelurahan=${desa}`;
        }

        const method = isSearch ? "POST" : "GET";
        const data = isSearch
            ? {
                  search: searchQuery,
                  _token: $('input[name="_token"]').val(),
              }
            : {};

        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function (response) {
                // Populate table
                let tableContent = "";
                response.data.forEach((item) => {
                    let row = "<tr>";
                    Object.keys(item).forEach((key) => {
                        row += `<td>${item[key]}</td>`;
                    });
                    row += "</tr>";
                    tableContent += row;
                });
                $("#podesTable tbody").html(tableContent);

                // Generate pagination
                let paginationHtml = "";
                response.links.forEach((link) => {
                    if (link.url === null) {
                        paginationHtml += `
                                    <li class="page-item disabled">
                                        <span class="page-link">${link.label}</span>
                                    </li>
                                `;
                    } else {
                        const pageNum = link.url.split("page=")[1];
                        paginationHtml += `
                                    <li class="page-item ${
                                        link.active ? "active" : ""
                                    }">
                                        <a class="page-link" href="#" onclick="window.loadPodesData(${pageNum}, ${isSearch}); return false;">
                                            ${link.label}
                                        </a>
                                    </li>
                                `;
                    }
                });
                $("#pagination").html(paginationHtml);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat memuat data");
            },
        });
    };

    // Load initial data
    window.loadPodesData();

    // Update table when filters change
    $(
        "#provinsiSelect, #kabupatenSelect, #kecamatanSelect, #desaSelect"
    ).change(function () {
        window.loadPodesData(1, false);
    });

    // Handle search form submission
    $("form").on("submit", function (e) {
        e.preventDefault();
        window.loadPodesData(1, true);
    });
});
