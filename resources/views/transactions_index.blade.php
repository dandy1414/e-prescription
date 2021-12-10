@extends('layouts.navbar')

@section('title')List Transaksi Resep @endsection

@section('content')

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Daftar Transaksi Resep</h5>
            <div class="card-body">
                <table class="table table-hover mt-3">
                    <thead>
                      <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama Pelanggan</th>
                        <th scope="col">Jenis Racikan</th>
                        <th scope="col">Nama Racikan</th>
                        <th scope="col">Obat atau Alkes</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $key => $trans)
                        @php
                        $medicines = DB::table('obat_receipt_t as or')
                        ->join('obatalkes_m as o', 'or.medicine_id', '=', 'o.obatalkes_id')
                        ->selectRaw('o.obatalkes_nama as medicine_name, or.quantity as qty')
                        ->where('receipt_id', $trans->id)
                        ->get();
                        @endphp
                        <tr>
                            <td>{{ $transactions->firstItem() + $key }}</td>
                            <td>{{ $trans->transaction_number }}</td>
                            <td>{{ $trans->customer_name }}</td>
                            <td>{{ ($trans->is_racikan == 0) ? "Non-racikan" : "Racikan" }}</td>
                            <td>{{ ($trans->is_racikan == 1) ? $trans->combine_name : "-"}}</td>
                            <td>
                                @foreach ($medicines as $med)
                                <ul>
                                    <li>{{ $med->medicine_name }}</li>
                                </ul>
                                @endforeach
                            </td>
                            <td><a href="{{ route('detail.transaksi', ['id'=>$trans->id]) }}" class="btn btn-primary">Detail</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  {!! $transactions->links() !!}
            </div>
        </div>
    </div>
</div>

@endsection
