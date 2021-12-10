@extends('layouts.navbar')

@section('title')Tambah Resep Non-Racikan @endsection

@section('content')

@if ($message = Session::get('fail'))
      <div class="alert alert-danger alert-block mt-3">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ $message }}</strong>
      </div>
@endif

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Tambah Resep Non-Racikan</h5>
            <div class="card-body">
                <form method="POST" action="{{ route('store.resep.non.racikan') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->first('customer_name') ? "has-error": "" }}">
                        <label for="exampleFormControlInput1">Nama Pelanggan</label>
                        <input type="text" class="form-control" name="customer_name" id="exampleFormControlInput1"
                            placeholder="Nama Pelanggan" required>
                        <span class="help-block">{{ $errors->first('customer_name') }}</span>
                    </div>
                    <div id="medicines-form">
                        <div class="form-row">
                            <div class="form-group col-md-10">
                                <label for="inputState">Obat atau Alkes</label>
                                <select class="form-control" name="medicines[]" required>
                                    <option selected disabled>Silahkan pilih</option>
                                    @foreach ($medicines as $med)
                                    <option value="{{ $med->obatalkes_id }}" {{ ($med->stok == 0.00) ? "disabled" : "" }}>{{ $med->obatalkes_nama }} || stok : {{ $med->stok }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="inputZip">Jumlah</label>
                                <input type="number" name="qty[]" class="form-control" placeholder="Jumlah" required>
                            </div>
                            <div class="form-group col-md-1">
                                <label>Hapus</label>
                                <a id="delete" class='btn btn-xs btn-danger form-control'>Hapus</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Signa</label>
                            <select class="form-control" name="signas[]" required>
                                <option selected disabled>Silahkan pilih</option>
                                @foreach ($signas as $sign)
                                <option value="{{ $sign->signa_id }}">{{ $sign->signa_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <a id="add" class='btn btn-sm btn-primary'>Tambah Obat</a>

                    <p id="medicines-form-b" class="mt-2"></p>

                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $("#add").click(function() {
            $("#medicines-form:last").clone(true).appendTo("#medicines-form-b");
        });

        $("#delete").click(function() {

            $(this).closest("#medicines-form").remove();
        });

    });
</script>

@endpush
