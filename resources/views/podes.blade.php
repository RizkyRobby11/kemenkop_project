<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DATABASE</title>
</head>
<body>
    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">

        <!-- card -->

        <div class="rounded overflow-hidden shadow bg-white mx-2 w-full">
            <div class="px-6 py-2 border-b border-light-grey">
                <div class="font-bold text-xl">PODES 2025</div>
            </div>
            <div class="table-responsive">
                <table class="table text-grey-darkest">
                    <thead class="bg-grey-dark text-white text-normal">
                        <tr>
                            @foreach ($columns as $col)
                            <th scope="col">{{ $col }}</th>
                        @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataDesa as $data)
                        <tr>
                            @foreach ($columns as $col)
                                <td>{{ $data->$col }}</td>
                            @endforeach
                        </tr>
                    @endforeach


                    </tbody>
                </table>
                {{ $dataDesa->links() }}
            </div>
        </div>
        <!-- /card -->

    </div>
</body>
</html>
