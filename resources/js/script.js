$(document).ready(function () {
    window.loadFilteredData = function (desaKelurahan) {
        $.ajax({
            url: "/filter", // Endpoint untuk mendapatkan data
            method: "GET",
            data: { desa_kelurahan: desaKelurahan }, // Kirim parameter desa_kelurahan
            beforeSend: function () {
                $("#filteredCardWrapper").html(
                    `<div class="card w-96 bg-base-100 shadow-sm mx-auto my-8">
                    <div class="card-body">
                        <div class="animate-pulse h-8 w-1/2 bg-gray-200 rounded mb-4"></div>
                        <ul class="mt-6 flex flex-col gap-2 text-xs">
                            <li class="h-4 bg-gray-100 rounded"></li>
                            <li class="h-4 bg-gray-100 rounded"></li>
                            <li class="h-4 bg-gray-100 rounded"></li>
                        </ul>
                    </div>
                </div>`
                );
            },
            success: function (response) {
                // Ambil nama desa dari filter yang dipilih user
                const namaDesa = $("#desaSelect option:selected").text();

                let potensials = [];
                if (response.data && response.data.length > 0) {
                    response.data.forEach((item) => {
                        if (item.podes && Array.isArray(item.podes)) {
                            item.podes.forEach((podes) => {
                                if (podes.nilai > 0) {
                                    potensials.push(`<li>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>${podes.nama} <b class="ml-1">${podes.nilai}</b></span>
                                </li>`);
                                }
                            });
                        }
                    });
                }

                if (potensials.length === 0) {
                    potensials.push(`<li>Tidak ada data potensial desa.</li>`);
                }

                // Render card
                $("#filteredCardWrapper").html(`
                <div class="card bg-base-100 w-full shadow-sm mx-auto my-8">
                  <div class="card-body">
                    <span class="badge badge-xs badge-warning">Potensi Desa</span>
                    <div class="flex justify-between">
                      <h2 class="text-3xl font-bold">${namaDesa}</h2>
                    </div>
                    <ul class="mt-6 flex flex-col gap-2 text-xs">
                      ${potensials.join("")}
                    </ul>
                  </div>
                </div>
            `);
            },
            error: function (xhr, status, error) {
                $("#filteredCardWrapper").html(
                    `<div class="card w-96 bg-base-100 shadow-sm mx-auto my-8">
                    <div class="card-body">
                        <h2 class="text-3xl font-bold text-error">Error</h2>
                        <div class="mt-4 text-sm">Terjadi kesalahan saat memuat data.</div>
                    </div>
                </div>`
                );
            },
        });
    };
});

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
        $("#filteredTableBody").html("");
        $("#filteredTableContainer").addClass("hidden");
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
        $("#kabupatenSelect").html("<option selected>Pilih Kabupaten</option>");
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

    // Reset dan disable dropdown kecamatan dan desa jika pilihan default
    if (kodeKabupaten === "Pilih Kabupaten") {
        $("#kecamatanSelect")
            .prop("disabled", true)
            .html("<option selected>Pilih Kecamatan</option>");
        $("#desaSelect")
            .prop("disabled", true)
            .html("<option selected>Pilih Desa/Kelurahan</option>");
        $("#filteredTableBody").html("");
        $("#filteredTableContainer").addClass("hidden");
        return;
    }

    // Enable dropdown kecamatan dan reset desa
    $("#kecamatanSelect").prop("disabled", false);
    $("#desaSelect")
        .prop("disabled", true)
        .html("<option selected>Pilih Desa/Kelurahan</option>");

    // Mengambil data kecamatan berdasarkan kabupaten
    $.get(`/kabupatenkota/${kodeKabupaten}/kecamatan`, function (data) {
        $("#kecamatanSelect").html("<option selected>Pilih Kecamatan</option>");
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

    // Reset dan disable dropdown desa jika pilihan default
    if (kodeKecamatan === "Pilih Kecamatan") {
        $("#desaSelect")
            .prop("disabled", true)
            .html("<option selected>Pilih Desa/Kelurahan</option>");
        $("#filteredTableBody").html("");
        $("#filteredTableContainer").addClass("hidden");
        return;
    }

    // Enable dropdown desa
    $("#desaSelect").prop("disabled", false);

    // Mengambil data desa berdasarkan kecamatan
    $.get(`/kecamatan/${kodeKecamatan}/desakelurahan`, function (data) {
        $("#desaSelect").html("<option selected>Pilih Desa/Kelurahan</option>");
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
    const namaDesa = $("#desaSelect option:selected").text();

    // Jika desa tidak dipilih atau dropdown disabled, kosongkan dan sembunyikan div filteredTableContainer
    if (
        !kodeDesa ||
        kodeDesa === "Pilih Desa/Kelurahan" ||
        $(this).prop("disabled")
    ) {
        $("#filteredTableBody").html("");
        $("#filteredTableContainer").addClass("hidden");
        return;
    }

    // Set judul H2 sesuai nama desa yang dipilih
    $("#filteredTableContainer h2").text("POTENSIAL DARI DESA : " + namaDesa);

    // Jika desa dipilih dan input enabled, tampilkan div filteredTableContainer
    $("#filteredTableContainer").removeClass("hidden");

    // Jika desa dipilih, panggil fungsi loadFilteredData
    loadFilteredData(kodeDesa);
});

// Define loadPodesData in global scope
window.loadPodesData = function (page = 1) {
    const provinsi = $("#provinsiSelect").val();
    const kabupaten = $("#kabupatenSelect").val();
    const kecamatan = $("#kecamatanSelect").val();
    const desa = $("#desaSelect").val();

    let url = "/filter";
    url += `?page=${page}`;

    if (provinsi && provinsi !== "Pilih Provinsi")
        url += `&provinsi=${provinsi}`;
    if (kabupaten && kabupaten !== "Pilih Kabupaten")
        url += `&kabupaten_kota=${kabupaten}`;
    if (kecamatan && kecamatan !== "Pilih Kecamatan")
        url += `&kecamatan=${kecamatan}`;
    if (desa && desa !== "Pilih Desa/Kelurahan")
        url += `&desa_kelurahan=${desa}`;

    $.ajax({
        url: url,
        method: "GET",
        beforeSend: function () {
            $("#loadingIndicator").removeClass("hidden");
            $("#podesTable tbody").html("");
            $("#pagination").html("");
            $("#notFoundMessage").addClass("hidden");
        },
        success: function (response) {
            let tableContent = "";

            if (response.data.length === 0) {
                $("#notFoundMessage").removeClass("hidden");
            } else {
                $("#notFoundMessage").addClass("hidden");

                response.data.forEach((item) => {
                    let row = "<tr>";
                    let i = 0;
                    for (let key in item) {
                        if (i >= 5) break;
                        row += `<td>${item[key]}</td>`;
                        i++;
                    }
                    row += "</tr>";
                    tableContent += row;
                });
            }

            $("#podesTable tbody").html(tableContent);

            let paginationHtml = "";

            if (response.data.length > 0) {
                paginationHtml += `<button class="join-item btn" ${
                    response.prev_page_url
                        ? `onclick="window.loadPodesData(${
                              response.current_page - 1
                          })"`
                        : "disabled"
                }>«</button>`;

                const totalPages = response.last_page;
                const currentPage = response.current_page;
                let startPage = Math.max(currentPage - 2, 1);
                let endPage = Math.min(currentPage + 2, totalPages);

                if (startPage > 1) {
                    paginationHtml += `<button class="join-item btn" onclick="window.loadPodesData(1)">1</button>`;
                    if (startPage > 2) {
                        paginationHtml += `<button class="join-item text-white btn btn-disabled">...</button>`;
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    paginationHtml += `<button class="join-item btn ${
                        i === currentPage ? "btn-active" : ""
                    }" onclick="window.loadPodesData(${i})">${i}</button>`;
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        paginationHtml += `<button class="join-item btn btn-disabled text-white">...</button>`;
                    }
                    paginationHtml += `<button class="join-item btn" onclick="window.loadPodesData(${totalPages})">${totalPages}</button>`;
                }

                paginationHtml += `<button class="join-item btn" ${
                    response.next_page_url
                        ? `onclick="window.loadPodesData(${
                              response.current_page + 1
                          })"`
                        : "disabled"
                }>»</button>`;
            }

            $("#pagination").html(paginationHtml);
        },
        complete: function () {
            $("#loadingIndicator").addClass("hidden");
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
$("#provinsiSelect, #kabupatenSelect, #kecamatanSelect, #desaSelect").change(
    function () {
        window.loadPodesData(1);
    }
);
