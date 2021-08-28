@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Fee Admin</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('fee_admin')}}">Fee Admin</a></li>
                    <li class="breadcrumb-item active">Tambah Fee Admin</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{route('storefee_admin')}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <select class="form-control custom-select" id="tipe" name="tipe" required>
                                            <option value="0">Pilih Tipe</option>
                                            <option value="1">Prosentase</option>
                                            <option value="2">Nominal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 hide" id="option-1">
                                    <div class="form-group">
                                        <label class="control-label">Presentase</label>
                                        <input type="number" name="is_precentage" id="is_precentage" class="form-control" min="0" max="100" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select class="form-control custom-select" id="status" name="status" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="col-md-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label">Nominal</label>
                                        <input type="number" name="nominal" id="nominal" class="form-control" value="0" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6 hide" id="option-2" style="display: inline;">
                                    <div class="form-group">
                                        <label class="control-label">Jumlah</label>
                                        <input spellcheck="false" type="text" name="jumlah" id="jumlah" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{ route('fee_admin')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{URL::asset('js')}}/add-feeadmin.js"></script>
<script>
var jumlah = document.getElementById('jumlah');
jumlah.addEventListener('keyup', function(e) {
    jumlah.value = formatRupiah(this.value, '');
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

</script>
@endsection
