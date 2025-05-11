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

        <form action="/search" method="POST" class="mt-3" enctype="multipart/form-data">
            <input type="text" name="search" id="search">
            <button type="submit" class="btn btn-primary">Cari</button>
            @csrf
        </form>

        <div class="mt-4">
            <table class="table table-bordered" id="podesTable">
                <thead>
                    <tr>
                        <th>Nama Provinsi</th>
                        <th>Nama Kabupaten</th>
                        <th>Nama Kecamatan</th>
                        <th>Nama Desa</th>
                        <th>Kode Desa/Kelurahan</th>
                        @foreach($labels as $label)
                            <th>{{ $label->{'COL 2'} }}</th>
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

        </body>
</html>
