<!DOCTYPE html>
<html>

<head>
    {{-- <title>Generate PDF using Laravel TCPDF - ItSolutionStuff.com</title> --}}
</head>

@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/dropzone.min.js'])

<body>




    <br>

    <table>
        <tr>
            <th>Omschrijving</th>
            <th>Aantal</th>
            <th>Tarief</th>
            <th>Bedrag</th>
        </tr>

        @foreach ($details as $detail)
            <tr>
                <td>{{ $detail->description }}</td>
                <td>{{ $detail->number }}</td>
                <td>{{ $detail->rate }}</td>
                <td halign='right'>
                    {{ number_format($detail->item_amount / 100, 2, ',', '.') }}
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
