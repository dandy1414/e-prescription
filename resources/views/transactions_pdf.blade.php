<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Transaksi Resep</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Google Font -->
    {{-- <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}
</head>

<body>
    <div class="container">
        <h2 style="text-align: center">Transaksi Resep</h2>
        <div class="row">
            <div class="col-md-8">
                <h5>Nomor Transaksi : </h5>
                <p>{{ $receipt->transaction_number }}</p>
                <br>
                <h5>Tanggal Transaksi : </h5>
                <p>{{ $receipt->created_at }}</p>
                <br>
                <h5>Nama Pelanggan : </h5>
                <p>{{ $receipt->customer_name }}</p>
                <br>
            </div>
            <div class="col-md-4">
                <h5>Jenis Obat : </h5>
                <p>{{ ($receipt->is_racikan == 1) ? "Obat racikan" : "Obat non-racikan" }}</p>
                <br>
                <h5>Nama Racikan : </h5>
                <p>{{ ($receipt->is_racikan == 1) ? $receipt->combine_name : "-" }}</p>
                <br>
                @if ($receipt->is_racikan == 1)
                <h5>Signa : </h5>
                <p>{{ $signa }}</p>
                <br>
                @endif
            </div>
        </div>

        <hr>

        @if ($receipt->is_racikan == 1)
        <h5>Daftar Racikan Obat : </h5>
        @else
        <h5>Daftar Obat : </h5>
        @endif
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Kode Obat/Alkes</th>
                            <th scope="col">Nama Obat/Alkes</th>
                            <th scope="col">Jumlah</th>
                            @if ($receipt->is_racikan == 0)
                            <th scope="col">Kode Signa</th>
                            <th scope="col">Signa</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicines as $key => $med)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $med->medicine_code }}</td>
                            <td>{{ $med->medicine_name }}</td>
                            <td>{{ $med->qty }}</td>
                            @if ($receipt->is_racikan == 0)
                            <td>{{ $med->signa_code }}</td>
                            <td>{{ $med->signa_name }}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
