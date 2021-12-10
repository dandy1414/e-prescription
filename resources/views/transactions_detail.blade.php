@extends('layouts.navbar')

@section('title')Detail Transaksi Resep @endsection

@section('content')
@if ($message = Session::get('success'))
      <div class="alert alert-success alert-block mt-3">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ $message }}</strong>
      </div>
@endif

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Detail Transaksi Resep</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title">Nomor Transaksi : </h5>
                        <p class="card-text">{{ $receipt->transaction_number }}</p>
                        <br>
                        <h5 class="card-title">Tanggal Transaksi : </h5>
                        <p class="card-text">{{ $receipt->created_at }}</p>
                        <br>
                        <h5 class="card-title">Nama Pelanggan : </h5>
                        <p class="card-text">{{ $receipt->customer_name }}</p>
                        <br>
                    </div>
                    <div class="col-md-4">
                        <h5 class="card-title">Jenis Obat : </h5>
                        <p class="card-text">{{ ($receipt->is_racikan == 1) ? "Obat racikan" : "Obat non-racikan" }}</p>
                        <br>
                        <h5 class="card-title">Nama Racikan : </h5>
                        <p class="card-text">{{ ($receipt->is_racikan == 1) ? $receipt->combine_name : "-" }}</p>
                        <br>
                        @if ($receipt->is_racikan == 1)
                        <h5 class="card-title">Signa : </h5>
                        <p class="card-text">{{ $signa }}</p>
                        <br>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ route('export.pdf', ['id' => $receipt->id]) }}" class="btn btn-success">Export PDF</a>
                    </div>
                </div>

                <hr>

                @if ($receipt->is_racikan == 1)
                <h5 class="card-title mt-3">Daftar Racikan Obat : </h5>
                @else
                <h5 class="card-title mt-3">Daftar Obat : </h5>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover mt-3">
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
        </div>
    </div>

    @endsection

    @push('scripts')

    <script>
        $(document).ready(function () {
            $("#add").click(function () {
                $("#medicines-form:last").clone(true).appendTo("#medicines-form-b");
            });

            $("#delete").click(function () {

                $(this).closest("#medicines-form").remove();
            });

        });

    </script>

    @endpush
