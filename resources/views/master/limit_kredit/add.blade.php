@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Kredit</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Kredit</a></li>
                    <li class="breadcrumb-item active">Tambah Kredit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row ">
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
                    <form action="{{route('limit-kredit-store')}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-body ">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Transaksi</label>
                                        <input spellcheck="false" type="text" name="batas_kredit" id="batas_kredit" class="form-control" value="{{ old('batas_kredit') }}" placeholder="">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <select type="text" class="form-control custom-select" name="tipe">
                                            <option value=">">></option>
                                            <option value=">=">>=</option>
                                            <option value="<">
                                                <</option> <option value="<=">
                                                    <=</option> <option value="=">=
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Limit Kredit</label><br>
                                        <input spellcheck="false" type="text" name="maksimal_boleh_kredit" id="maksimal_boleh_kredit" class="form-control" value="{{ old('maksimal_boleh_kredit') }}" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Urutan</label><br>
                                        <input type="number" name="urutan" id="urutan" class="form-control" value="{{ old('urutan') }}" placeholder="" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions mt-3">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('limit-kredit')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
@endsection
@section('script')
<script>
var batas_kredit = document.getElementById('batas_kredit');
batas_kredit.addEventListener('keyup', function(e) {
    batas_kredit.value = formatRupiah(this.value,'');
});

var maksimal_boleh_kredit = document.getElementById('maksimal_boleh_kredit');
maksimal_boleh_kredit.addEventListener('keyup', function(e) {
    maksimal_boleh_kredit.value = formatRupiah(this.value,'');
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
