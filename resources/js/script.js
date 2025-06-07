$(document).ready(function () {
    const kategoriPotensi = [
        {
            nama: "Industri Mikro dan Kecil",
            keywords: ["INDUSTRI MIKRO DAN KECIL"],
        },
        {
            nama: "Reparasi dan Jasa",
            keywords: ["REPARASI", "BENGKEL", "SALON KECANTIKAN"],
        },
        {
            nama: "Koperasi dan Lembaga Keuangan",
            keywords: [
                "KOPERASI",
                "BAITUL MAAL",
                "ATM",
                "AGEN BANK",
                "PERUSAHAAN PEMBIAYAAN",
                "PEDAGANG VALUTA",
                "PERGADAIAN",
            ],
        },
        {
            nama: "Perdagangan dan Pasar",
            keywords: [
                "PASAR",
                "TOKO",
                "WARUNG",
                "MINIMARKET",
                "SWALAYAN",
                "SUPERMARKET",
                "KELOMPOK PERTOKOAN",
                "WARUNG KEDAI",
            ],
        },
        {
            nama: "Jasa Lainnya",
            keywords: [
                "AGEN TIKET",
                "TRAVEL",
                "BIRO PERJALANAN",
                "RESTORAN",
                "RUMAH MAKAN",
                "HOTEL",
                "PENGINAPAN",
            ],
        },
        {
            nama: "Produk Unggulan",
            keywords: ["PRODUK UNGGULAN"],
        },
    ];
    // =========================
    // Helper: Reset Dropdown
    // =========================
    function resetDropdown($el, placeholder) {
        $el.prop("disabled", true).html(
            `<option selected>${placeholder}</option>`
        );
    }

    function getKategoriPotensi(nama) {
        nama = (nama || "").toUpperCase();
        for (const kategori of kategoriPotensi) {
            for (const key of kategori.keywords) {
                if (nama.includes(key)) {
                    return kategori.nama;
                }
            }
        }
        return "Lainnya";
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
                                            
                                            <span>👉 ${podes.nama} <b class="ml-1">${podes.nilai}</b></span>
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
                    <div class="card w-full max-w-md bg-white shadow-lg mx-auto my-8 rounded-xl border border-gray-100">
                        <div class="card-body p-6">
                            <span class=" mb-2 text-2xl uppercase">Potensi dari Desa/Kelurahan :</span>
                            <h2 class="text-2xl font-bold text-gray-800 mb-1">${namaDesa}</h2>
                            <hr>
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

    // // Fungsi untuk render chart
    // function renderPotensiChart(labels, data) {
    //     const ctx = document.getElementById("potensiChart").getContext("2d");
    //     if (window.potensiChart) {
    //         window.potensiChart.destroy();
    //     }
    //     window.potensiChart = new Chart(ctx, {
    //         type: "bar",
    //         data: {
    //             labels: labels,
    //             datasets: [
    //                 {
    //                     label: "Nilai Potensi",
    //                     data: data,
    //                     backgroundColor: "#42aafa",
    //                 },
    //             ],
    //         },
    //         options: {
    //             responsive: true,
    //             plugins: {
    //                 legend: { display: false },
    //             },
    //             scales: {
    //                 y: { beginAtZero: true },
    //             },
    //         },
    //     });
    // }

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
            $kabupaten.html(
                "<option selected disabled>Pilih Kabupaten</option>"
            );
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
            $kecamatan.html(
                "<option selected disabled>Pilih Kecamatan</option>"
            );
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
            $desa.html(
                "<option selected disabled>Pilih Desa/Kelurahan</option>"
            );
            data.forEach(function (desa) {
                $desa.append(
                    `<option value="${desa.kode_desa_kelurahan}">${desa.nama_desa_kelurahan}</option>`
                );
            });
        });
    }

    window.getPodesByWilayah = function (
        kodeWilayah,
        isDesa = false,
        page = 1
    ) {
        $.ajax({
            url: `/podes/${kodeWilayah}?page=${page}`,
            method: "GET",
            success: function (response) {
                console.log(response);
                let tableContent = "";
                if (response.detail.data.length === 0) {
                    $("#notFoundMessage").removeClass("hidden");
                } else {
                    $("#notFoundMessage").addClass("hidden");
                    response.detail.data.forEach((item) => {
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
                if (response.detail.data.length > 0) {
                    paginationHtml += `<button class="join-item btn" ${
                        response.detail.prev_page_url
                            ? `onclick="window.getPodesByWilayah(${
                                  response.detail.current_page - 1
                              })"`
                            : "disabled"
                    }>«</button>`;

                    const totalPages = response.detail.last_page;
                    const currentPage = response.detail.current_page;
                    let startPage = Math.max(currentPage - 2, 1);
                    let endPage = Math.min(currentPage + 2, totalPages);

                    if (startPage > 1) {
                        paginationHtml += `<button class="join-item btn" onclick="window.getPodesByWilayah(1)">1</button>`;
                        if (startPage > 2) {
                            paginationHtml += `<button class="join-item  btn ">...</button>`;
                        }
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `<button class="join-item btn ${
                            i === currentPage ? "btn-active" : ""
                        }" onclick="window.getPodesByWilayah(${kodeWilayah}, ${isDesa},${i})">${i}</button>`;
                    }

                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<button class="join-item btn ">...</button>`;
                        }
                        paginationHtml += `<button class="join-item btn" onclick="window.getPodesByWilayah(${kodeWilayah}, ${isDesa}, ${totalPages})">${totalPages}</button>`;
                    }

                    paginationHtml += `<button class="join-item btn" ${
                        response.next_page_url
                            ? `onclick="window.getPodesByWilayah(${
                                  response.current_page + 1
                              })"`
                            : "disabled"
                    }>»</button>`;
                }
                $("#pagination").html(paginationHtml);

                let dataArr = Array.isArray(response.detail.data)
                    ? response.detail.data
                    : [];
                console.log(dataArr);
                dataArr.forEach((item, idx) => {
                    if (Array.isArray(item.PODES)) {
                        item.PODES.forEach((podesObj, i) => {
                            // podesObj adalah object, ambil key dan value-nya
                            Object.entries(podesObj).forEach(([key, value]) => {
                                // console.log(`Key: ${key}, Value: ${value}`);
                                // Lakukan sesuatu dengan key dan value
                            });
                        });
                    }
                });

                // Jika desa, ambil nama desa dari summary atau dari dropdown
                let title = "-";
                if (isDesa) {
                    title = $("#desaSelect option:selected").text();
                } else if (dataArr.length > 0) {
                    title = dataArr[0]["NAMA PROVINSI"] || "-";
                    console.log("title", title);
                }
                // Kategorikan summaryList
                let potensiByKategori = {};
                dataArr
                    .slice(2)
                    .filter((item) => Number(item.nilai) !== 0)
                    .forEach((item) => {
                        const kategori = getKategoriPotensi(item.nama);
                        if (!potensiByKategori[kategori])
                            potensiByKategori[kategori] = [];
                        potensiByKategori[kategori].push(`
            <li class="flex items-center">
                <span>👉 ${item.nama || "-"} <b class="ml-1">${
                            item.nilai ?? ""
                        }</b></span>
            </li>
        `);
                    });

                let cards = [];
                const namaWilayah = title;
                if (Object.keys(potensiByKategori).length === 0) {
                    cards.push(`
        <div class="card w-full max-w-md bg-white shadow-lg mx-auto my-8 rounded-xl border border-gray-100">
            <div class="card-body p-6">
                <span class="text-xl font-bold text-center mb-2">${
                    isDesa ? "Potensi Desa/Kelurahan" : "POTENSI DARI WILAYAH :"
                }</span>
                <div class="w-full flex justify-center rounded-full h-full">
                    <h2 class="text-xl bg-[#42aafa] p-3 rounded-lg w-fit block text-white font-bold text-center">${namaWilayah}</h2>
                </div>
                <hr>
                <ul class="mt-2 flex flex-col gap-3 text-sm">
                    <li class="flex items-center opacity-60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Tidak ada data potensial.</span>
                    </li>
                </ul>
            </div>
        </div>
    `);
                } else {
                    for (const kategori in potensiByKategori) {
                        cards.push(`
            <div class="card w-full max-w-md bg-white shadow-lg mx-auto my-8 rounded-xl border border-gray-100">
                <div class="card-body shadow p-6">
                    <span class="text-xl font-bold text-[#0E5367] block mb-2">${kategori}</span>
                    
                    <hr>
                    <ul class="mt-4 flex flex-col gap-3 text-sm">
                        ${potensiByKategori[kategori].join("")}
                    </ul>
                </div>
            </div>
        `);
                    }
                }

                if (dataArr.length > 0) {
                    // Tampilkan nama wilayah di atas grid card
                    $("#filteredTableContainer").removeClass("hidden").html(`
        <div class=" w-full p-2 text-2xl flex justify-center font-bold text-center text-[#0E5367]">
            <div class="w-fit p-2 border-b  uppercase shadow-[0_4px_8px_-4px_rgba(14,83,103,0.25)] h-full">
                <h2>Potensial dari wilayah : ${namaWilayah}</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            ${cards.join("")}
        </div>
    `);
                }
            },
            error: function () {
                $("#filteredTableContainer").addClass("hidden").html("");
            },
        });
    };

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
            $("#chartContainer").removeClass("hidden");
            window.loadPodesData(1);
            $("#kabupatenSelect").prop("disabled", true);
            return;
        }
        $("#kabupatenSelect").prop("disabled", false);
        loadKabupaten(kodeProvinsi);
        $("#chartContainer").addClass("hidden");
        getPodesByWilayah(kodeProvinsi);
        // window.loadPodesData(1);
    });

    $("#kabupatenSelect").change(function () {
        const kodeKabupaten = $(this).val();
        resetDropdown($("#kecamatanSelect"), "Pilih Kecamatan");
        resetDropdown($("#desaSelect"), "Pilih Desa/Kelurahan");
        $("#filteredTableContainer").addClass("hidden"); // Tambahkan baris ini
        if (kodeKabupaten === "Pilih Kabupaten") {
            window.getPodesByWilayah($("#provinsiSelect").val());
            $("#kecamatanSelect").prop("disabled", true);
            return;
        }
        $("#kecamatanSelect").prop("disabled", false);
        loadKecamatan(kodeKabupaten);
        $("#chartContainer").addClass("hidden");
        getPodesByWilayah(kodeKabupaten);
    });

    $("#kecamatanSelect").change(function () {
        const kodeKecamatan = $(this).val();
        resetDropdown($("#desaSelect"), "Pilih Desa/Kelurahan");
        $("#filteredTableContainer").addClass("hidden"); // Tambahkan baris ini
        if (kodeKecamatan === "Pilih Kecamatan") {
            window.getPodesByWilayah($("#kabupatenSelect").val());
            $("#desaSelect").prop("disabled", true);
            return;
        }
        $("#desaSelect").prop("disabled", false);
        loadDesa(kodeKecamatan);
        $("#chartContainer").addClass("hidden");
        getPodesByWilayah(kodeKecamatan);
    });

    $("#desaSelect").change(function () {
        const kodeDesa = $(this).val();
        if (
            !kodeDesa ||
            kodeDesa === "Pilih Desa/Kelurahan" ||
            $(this).prop("disabled")
        ) {
            $("#filteredTableContainer").addClass("hidden");
            window.getPodesByWilayah($("#kecamatanSelect").val(), true, 1);
            return;
        }
        window.loadPodesData(1); // Panggil loadPodesData, bukan loadFilteredData
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
                // console.log(response);
                let tableContent = "";
                if (response.data.length === 0) {
                    $("#notFoundMessage").removeClass("hidden");
                } else {
                    $("#notFoundMessage").addClass("hidden");
                    response.data.forEach((item, idx) => {
                        // Tambahkan class ganjil/genap
                        const rowClass =
                            idx % 2 === 0 ? "bg-white" : "bg-[#F9F7F1]";
                        let row = `<tr class="${rowClass}">`;
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
                    paginationHtml += `<button class="join-item btn " ${
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
                            paginationHtml += `<button class="join-item  btn ">...</button>`;
                        }
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `<button class="join-item btn ${
                            i === currentPage ? "btn-active" : ""
                        }" onclick="window.loadPodesData(${i})">${i}</button>`;
                    }

                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHtml += `<button class="join-item btn  ">...</button>`;
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
                // Tambahkan ini untuk summary desa
                const desa = $("#desaSelect").val();
                if (desa && desa !== "Pilih Desa/Kelurahan") {
                    let labels = [];
                    let values = [];
                    // Ambil nama desa dari dropdown
                    const namaDesa = $("#desaSelect option:selected").text();
                    let potensials = [];

                    if (response.data && response.data.length > 0) {
                        response.data.forEach((item) => {
                            if (Array.isArray(item.podes)) {
                                item.podes.forEach((podes) => {
                                    if (podes.nilai > 0) {
                                        potensials.push(`
                                <li class="flex items-center">
                                    <span>👉 ${podes.nama} <b class="ml-1">${podes.nilai}</b></span>
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

                    $("#filteredTableContainer").removeClass("hidden").html(`
            <div class="card w-full max-w-md bg-white shadow-lg mx-auto my-8 rounded-xl border border-gray-100">
                <div class="card-body p-6">
                    <span class="mb-2 text-2xl text-center uppercase font-bold">Potensi dari Desa/Kelurahan :</span>
                    <div class="w-full flex justify-center rounded-full h-full">
                                <h2 class="text-2xl  w-fit block text-[#0E5367] font-bold text-center">${namaDesa}</h2>
                            </div>
                    <hr>
                    <ul class="mt-4 flex flex-col gap-3 text-sm">
                        ${potensials.join("")}
                    </ul>
                </div>
            </div>
        `);
                } else {
                    $("#filteredTableContainer").addClass("hidden").html("");
                }
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

    // Dummy chart di bawah tabel, data dari API summary provinsi
    if ($("#dummyChart").length) {
        $.get("/podes/summary/provinsi", function (response) {
            // Asumsi response array objek {nama: ..., nilai: ...}
            const labels = [];
            const data = [];
            if (Array.isArray(response)) {
                response.forEach((item) => {
                    labels.push(item.nama_provinsi || "-");
                    data.push(Number(item.total_semua_podes) || 0);
                });
            }
            const colors = [
                "#2563eb", // biru utama
                "#60a5fa", // biru muda
                "#38bdf8", // biru cyan
                "#a5b4fc", // biru keunguan muda
                "#64748b", // abu-abu biru
                "#cbd5e1", // abu-abu muda
                "#3b82f6", // biru sedang
                "#1e293b", // biru gelap
                "#0ea5e9", // cyan terang
                "#6366f1", // indigo
                "#818cf8", // indigo muda
                "#e0e7ef", // abu-abu sangat muda
                "#93c5fd",
                "#bae6fd", // cyan pastel
                "#334155",
            ];
            const ctx = document.getElementById("dummyChart").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Total Potensi per Provinsi",
                            data: data,
                            backgroundColor: colors.slice(0, data.length),
                        },
                    ],
                },
                options: {
                    animation: {
                        duration: 1200, // ms
                        easing: "easeOut",
                    },
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                    },
                    scales: {
                        y: { beginAtZero: true },
                    },
                },
            });
        });
    }
});
