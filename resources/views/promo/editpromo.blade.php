@extends('layouts._layout')
@section('asset')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Promotion</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('list-promo') }}">Promotion</a></li>
                    <li class="breadcrumb-item active">Edit Promotion</li>
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
                    <form action="{{route('update-promo',$promo->id)}}" method="post" enctype="multipart/form-data">@csrf
                        <div class="form-body">
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama Kupon</label>
                                        <input type="text" name="nama_kupon" id="nama_kupon" class="form-control" value="{{$promo->nama_kupon}}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Mulai Dari</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{$promo->start_date}}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Berakhir</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{$promo->end_date}}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control custom-select" name="type_id" required>
                                            @foreach($type_promo as $type_promo)
                                            @if($type_promo['id'] == $type_promo['type_id'])
                                            <option value="{{ $type_promo->id }}" selected>{{ $type_promo->nama_type }}</option>
                                            @else
                                            <option value="{{ $type_promo->id }}">{{ $type_promo->nama_type }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Jumlah / Persentasi</label>
                                        <select name="is_percentage" id="is_percentage" class="form-control select2" required>
                                            <option value="">Pilih</option>
                                            @if ($promo->is_percentage == 1)
                                            <option value="0">Jumlah</option>
                                            <option value="1" selected>Persentasi</option>
                                            @else
                                            <option value="0" selected>Jumlah</option>
                                            <option value="1">Persentasi</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Minimal Transaksi</label>
                                        <input spellcheck="false" type="text" name="minimal_transaksi" id="minimal_transaksi" class="form-control" value="{{ $promo->minimal_transaksi }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Potongan</label>
                                        <input spellcheck="false" type="text" name="potongan" id="potongan" class="form-control" value="{{ $promo->potongan }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Maximal Potongan</label>
                                        <input spellcheck="false" type="text" name="max_potongan" id="max_potongan" class="form-control" value="{{$promo->max_potongan}}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{ route('list-promo')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
    });
    $("#id_kota").change(function() {
        console.log("jaya tampan");
        var provid = $("#id_kota").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (provid) {

            $.ajax({
                type: 'GET',
                url: '/master/area/' + provid,
                dataType: 'json',
                success: function(data) {
                    $("#area").empty();
                    $("#area").append("<option value=''>Pilih Area</option>");
                    for (let i = 0; i < data.length; i++) {

                        $("#area").append("<option value=" + data[i].area_code + ">" + data[i].name + "</option>");
                    }
                    console.log(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });
});

var max_potongan = document.getElementById('max_potongan');
max_potongan.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    max_potongan.value = formatRupiah(this.value,'');
});

var potongan = document.getElementById('potongan');
potongan.addEventListener('keyup', function(e) {
    potongan.value = formatRupiah(this.value,'');
});

var minimal_transaksi = document.getElementById('minimal_transaksi');
minimal_transaksi.addEventListener('keyup', function(e) {
    minimal_transaksi.value = formatRupiah(this.value,'');
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
