@extends('layouts._layout')
@section('asset')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Promo</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('list-promo') }}">Promo</a></li>
                    <li class="breadcrumb-item active">Tambah Promo</li>
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
                    <form action="{{route('store-promo')}}" method="post" enctype="multipart/form-data">@csrf
                        <div class="form-body">
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama Kupon</label>
                                        <input type="text" name="nama_kupon" id="nama_kupon" class="form-control" value="{{ old('nama_kupon') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Mulai Dari</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Berakhir</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tipe Promo</label>
                                        <select name="type_id" id="type_id" class="form-control select2" required>
                                            <option value="">Pilih Tipe Promo</option>
                                            @foreach ($type_promo as $item)
                                            <option value="{{$item['id']}}">{{$item['nama_type']}}</option>
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
                                            <option value="0">Jumlah</option>
                                            <option value="1">Persentasi</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Minimal Transaksi</label>
                                        <input spellcheck="false" type="text" name="minimal_transaksi" id="minimal_transaksi" class="form-control" value="{{ old('minimal_transaksi') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Potongan</label>
                                        <input spellcheck="false" type="text" name="potongan" id="potongan" class="form-control" value="{{ old('potongan') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Maximal Potongan</label>
                                        <input spellcheck="false" type="text" name="max_potongan" id="max_potongan" class="form-control" value="{{ old('max_potongan') }}" placeholder="" required>
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
        var provid = $("#id_kota").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (provid) {

            $.ajax({
                type: 'GET',
                url: '/area/' + provid,
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
