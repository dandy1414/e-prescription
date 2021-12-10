@extends('layouts.navbar')

@section('title')List Obat @endsection

@section('content')

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Daftar Obat dan Alkes</h5>
            <div class="card-body">
                <div class="col-md-12">
                    <a href="{{ route('create.resep.non.racikan') }}" class="btn btn-primary">Buat Resep Non-Racikan</a>
                    <a href="{{ route('create.resep.racikan') }}" class="btn btn-warning">Buat Resep Racikan</a>
                </div>

                <table class="table table-hover mt-3">
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama Obat</th>
                        <th scope="col">Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicines as $key => $med)
                        <tr>
                            <td>{{ $medicines->firstItem() + $key }}</td>
                            <td>{{ $med->obatalkes_kode }}</td>
                            <td>{{ $med->obatalkes_nama }}</td>
                            <td>{{ $med->stok }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  {!! $medicines->links() !!}
            </div>
        </div>
    </div>
</div>

@endsection
