<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>

    <div class="col-12 text-center">
        <h2>Laporan Surat Keluar</h2>
        <h4>Faserv Corporation</h4>
        <h6>Jln. Rumah Bari Komp Benteng 30132 Palembang</h6>
    </div>
    <hr>
    <table class="table table-bordered table-responsive mt-3" style="font-size: 11px;">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col" class="text-center">Nomor Surat</th>
                <th scope="col" class="text-center">Nomor Agenda</th>
                <th scope="col" class="text-center">Penerima</th>
                <th scope="col" class="text-center">Tanggal Surat</th>
                <th scope="col" class="text-center">Klasifikasi Kode</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; ?>
            @foreach ($letters as $letter)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$letter->reference_number}}</td>
                <td>{{$letter->agenda_number}}</td>
                <td>{{$letter->to}}</td>
                <td>{{\Carbon\Carbon::parse($letter->letter_date)->isoFormat('dddd, D MMMM YYYY')}}</td>
                <td>{{$letter->classification->type}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        window.print()

    </script>
</body>
</html>
