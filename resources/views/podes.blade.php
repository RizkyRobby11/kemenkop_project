<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podes 2025</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="flex flex-col p-4">
        <div class="rounded shadow bg-red-400 mb-4 p-4">
            <h1 class="text-2xl font-bold text-white">PODES 2025</h1>
        </div>

        <div class="overflow-x-auto  shadow rounded-2xl p-4">
            <table class="min-w-full table-auto border border-gray-300">
                <thead class="bg-gray-200 text-gray-800 text-sm">
                    <tr>
                        @foreach ($labels as $label )
                            <th>
                            {{ $label }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($filteredData as $data)
                        <tr> @for ($i = 1; $i <= 45; $i++)
                            <td class="border border-gray-300 px-4 py-2">
                                <div>{{ $data->{'COL_' . $i} }}</div>
                            </td>

                        @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $dataDesa->links() }}
            </div>
        </div>
    </div>
</body>
</html>
