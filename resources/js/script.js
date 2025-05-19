$(document).ready(function () {
    // =========================
    // Helper: Reset Dropdown
    // =========================
    function resetDropdown($el, placeholder) {
        $el.prop("disabled", true).html(
            `<option selected>${placeholder}</option>`
        );
    }

    // =========================
    // Load Potensi Desa Card
    // =========================
    window.loadFilteredData = function (desaKelurahan) {
        const $wrapper = $("#filteredCardWrapper");
        $wrapper.html(`
            <div class="card w-full max-w-md bg-white shadow-lg mx-auto my-8 rounded-xl border border-gray-100">
                <div class="card-body p-6">
                    <div class="animate-pulse h-8 w-1/2 bg-gray-200 rounded mb-4"></div>
                    <ul class="mt-6 flex flex-col gap-2 text-xs">
                        <li class="h-4 bg-gray-100 rounded"></li>
                        <li class="h-4 bg-gray-100 rounded"></li>
                        <li class="h-4 bg-gray-100 rounded"></li>
                    </ul>
                </div>
            </div>
        `);

        $.ajax({
            url: "/filter",
            method: "GET",
            data: { desa_kelurahan: desaKelurahan },
            success: function (response) {
                const namaDesa = $("#desaSelect option:selected").text();
                let potensials = [];

                if (response.data && response.data.length > 0) {
                    response.data.forEach((item) => {
                        if (Array.isArray(item.podes)) {
                            item.podes.forEach((podes) => {
                                if (podes.nilai > 0) {
                                    potensials.push(`
                                        <li class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>${podes.nama} <b class="ml-1">${podes.nilai}</b></span>
                                        </li>
                                    `);
                                }
                            });
                        }
                    });
                }

                if (potensials.length === 0) {
                    potensials.push(`
                        <li class="flex items-center opacity-60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Tidak ada data potensial desa.</span>
                        </li>
                    `);
                }

                $wrapper.html(`
                    <div class="card w-full max-w-md bg-white shadow-lg mx-auto my-8 rounded-xl border border-gray-100 transition-transform hover:scale-[1.02]">
                        <div class="card-body p-6">
                            <span class="badge badge-info badge-sm mb-2">Potensi Desa</span>
                            <h2 class="text-2xl font-bold text-gray-800 mb-1">${namaDesa}</h2>
                            <ul class="mt-4 flex flex-col gap-3 text-sm">
                                ${potensials.join("")}
                            </ul>
                        </div>
                    </div>
                `);
            },
            error: function () {
                $wrapper.html(`
                    <div class="card w-full max-w-md bg-white shadow-lg mx-auto my-8 rounded-xl border border-gray-100">
                        <div class="card-body p-6">
                            <h2 class="text-2xl font-bold text-error">Error</h2>
                            <div class="mt-4 text-sm">Terjadi kesalahan saat memuat data.</div>
                        </div>
                    </div>
                `);
            },
        });
    };

    // =========================
    // Dropdown Data Loaders
    // =========================
    function loadProvinsi() {
        $.get("/provinsi", function (data) {
            const $provinsi = $("#provinsiSelect");
            $provinsi.html("<option selected>Pilih Provinsi</option>");
            data.forEach(function (provinsi) {
                $provinsi.append(
                    `<option value="${provinsi.kode_provinsi}">${provinsi.nama_provinsi}</option>`
                );
            });
        });
    }

    function loadKabupaten(kodeProvinsi) {
        $.get(`/provinsi/${kodeProvinsi}/kabupatenkota`, function (data) {
            const $kabupaten = $("#kabupatenSelect");
            $kabupaten.html("<option selected>Pilih Kabupaten</option>");
            data.forEach(function (kabupaten) {
                $kabupaten.append(
                    `<option value="${kabupaten.kode_kabupaten_kota}">${kabupaten.nama_kabupaten_kota}</option>`
                );
            });
        });
    }

    function loadKecamatan(kodeKabupaten) {
        $.get(`/kabupatenkota/${kodeKabupaten}/kecamatan`, function (data) {
            const $kecamatan = $("#kecamatanSelect");
            $kecamatan.html("<option selected>Pilih Kecamatan</option>");
            data.forEach(function (kecamatan) {
                $kecamatan.append(
                    `<option value="${kecamatan.kode_kecamatan}">${kecamatan.nama_kecamatan}</option>`
                );
            });
        });
    }

    function loadDesa(kodeKecamatan) {
        $.get(`/kecamatan/${kodeKecamatan}/desakelurahan`, function (data) {
            const $desa = $("#desaSelect");
            $desa.html("<option selected>Pilih Desa/Kelurahan</option>");
            data.forEach(function (desa) {
                $desa.append(
                    `<option value="${desa.kode_desa_kelurahan}">${desa.nama_desa_kelurahan}</option>`
                );
            });
        });
    }

    // =========================
    // Dropdown Event Handlers
    // =========================
    $("#provinsiSelect").change(function () {
        const kodeProvinsi = $(this).val();
        resetDropdown($("#kabupatenSelect"), "Pilih Kabupaten");
        resetDropdown($("#kecamatanSelect"), "Pilih Kecamatan");
        resetDropdown($("#desaSelect"), "Pilih Desa/Kelurahan");
        $("#filteredTableContainer").addClass("hidden"); // Tambahkan baris ini
        if (kodeProvinsi === "Pilih Provinsi") {
            window.loadPodesData(1);
            return;
        }
        $("#kabupatenSelect").prop("disabled", false);
        loadKabupaten(kodeProvinsi);
        window.loadPodesData(1);
    });

    $("#kabupatenSelect").change(function () {
        const kodeKabupaten = $(this).val();
        resetDropdown($("#kecamatanSelect"), "Pilih Kecamatan");
        resetDropdown($("#desaSelect"), "Pilih Desa/Kelurahan");
        $("#filteredTableContainer").addClass("hidden"); // Tambahkan baris ini
        if (kodeKabupaten === "Pilih Kabupaten") {
            window.loadPodesData(1);
            return;
        }
        $("#kecamatanSelect").prop("disabled", false);
        loadKecamatan(kodeKabupaten);
        window.loadPodesData(1);
    });

    $("#kecamatanSelect").change(function () {
        const kodeKecamatan = $(this).val();
        resetDropdown($("#desaSelect"), "Pilih Desa/Kelurahan");
        $("#filteredTableContainer").addClass("hidden"); // Tambahkan baris ini
        if (kodeKecamatan === "Pilih Kecamatan") {
            window.loadPodesData(1);
            return;
        }
        $("#desaSelect").prop("disabled", false);
        loadDesa(kodeKecamatan);
        window.loadPodesData(1);
    });

    $("#desaSelect").change(function () {
        const kodeDesa = $(this).val();
        if (
            !kodeDesa ||
            kodeDesa === "Pilih Desa/Kelurahan" ||
            $(this).prop("disabled")
        ) {
            $("#filteredTableContainer").addClass("hidden");
            return;
        }
        $("#filteredTableContainer").removeClass("hidden");
        window.loadFilteredData(kodeDesa);
    });

    // =========================
    // Table Data & Pagination
    // =========================
    window.loadPodesData = function (page = 1) {
        const provinsi = $("#provinsiSelect").val();
        const kabupaten = $("#kabupatenSelect").val();
        const kecamatan = $("#kecamatanSelect").val();
        const desa = $("#desaSelect").val();

        let url = `/filter?page=${page}`;
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
                console.log(response);
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

                // Pagination
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
            error: function () {
                console.error("Error saat memuat data tabel utama");
                alert("Terjadi kesalahan saat memuat data");
            },
        });
    };

    // =========================
    // Inisialisasi
    // =========================
    loadProvinsi();
    window.loadPodesData();

    // Update tabel utama saat filter berubah
    $(
        "#provinsiSelect, #kabupatenSelect, #kecamatanSelect, #desaSelect"
    ).change(function () {
        window.loadPodesData(1);
    });
});
