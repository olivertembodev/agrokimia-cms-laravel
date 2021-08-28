@extends('layouts._layout')
@section('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
<style>
    .thumbnail{

    height: 100px;
    margin: 10px;
    float: left;
}
#clear{
   display:none;
}
#result {
    border: 4px dotted #cccccc;
    display: none;
    float: left;
    margin:0 auto;
    width:1100px;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Product</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Product</a></li>
                    <li class="breadcrumb-item active">Tambah Product</li>
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
                    <form action="{{route('store-product')}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-body ">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama Produk</label>
                                        <input type="text" name="nama_product" id="" class="form-control" value="{{ old('nama_product') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select class="form-control custom-select" name="id_category_product" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['nama_category'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Berat Produk &nbsp; <small>(gram)</small></label>
                                        <input min="0" type="number" name="berat_product" id="" class="form-control" value="{{ old('berat_product') }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Principle</label>
                                        <select class="form-control custom-select" name="id_principle" required>
                                            <option value="">Pilih Principle</option>
                                            @foreach($principles as $principle)
                                            <option value="{{ $principle['id'] }}">{{ $principle['nama_principle'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nomor Lot Produk</label><br>
                                        <input type="text" name="lot_product" class="form-control" value="{{ old('lot_product') }}" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Deskripsi</label>
                                        <textarea id="deskripsi" class="form-control summernote" name="deskripsi" rows="5" cols="50" required>{{ old('deskripsi') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cara Pakai</label>
                                        <textarea id="deskripsi" class="form-control summernote" name="cara_pakai" rows="5" cols="50" required>{{ old('cara_pakai') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Expired Date</label><br>
                                        <input type="date" name="expired_date" class="form-control" value="{{ old('expired_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Reward Poin</label><br>
                                        <input type="number" min="0" name="reward_poin" class="form-control" value="{{ old('reward_poin') }}" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Harga Jual</label><br>
                                        <input spellcheck="false" type="text" id="harga_jual" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Harga Beli</label><br>
                                        <input spellcheck="false" type="text" id="harga_beli" name="harga_beli" class="form-control" value="{{ old('harga_beli') }}" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Stock</label><br>
                                        <button type="button" class="btn btn-success float-left mb-2" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Tambah Stock</button>
                                        <table id='table-stock' class="table display table-bordered table-striped no-wrap">
                                            <thead>
                                                <tr align="center">
                                                    <th>Tanggal</th>
                                                    <th>Stock</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr align="center">
                                                    <th>Total Stock :</th>
                                                    <th id="total">0</th>
                                                    <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Satuan</label><br>
                                        <input spellcheck="false" type="text" id="satuan" name="satuan" class="form-control" value="{{ old('satuan') }}" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Images</label><br>
                                        <input id="files" class="form-control col-md-8 mb-2" type="file" name="image[]" multiple>
                                        <button class="col-md-2 float-right" type="button" id="clear">Clear</button>
                                        <output class="w-100" id="result">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions p-t-20 p-l-30">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('list-product')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="stockForm">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Tanggal:</label>
                        <input type="date" name="stockTanggal" class="form-control" id="stock-tanggal">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Stock:</label>
                        <input type="number" min="0" name="stockJumlah" class="form-control stok" id="stock-jumlah">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addStock()">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Hapus Stok</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-ok">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{URL::asset('assets')}}/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script>
var array_tgl = [];

$(document).ready(function() {
    $('.summernote').summernote({

        height: 200,

    });

});

$(".stok").keypress(function(e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        alert('Input hanya angka !')
        return false;
    }
});

$('#delete-modal').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    $('.title', this).text(data.recordTitle);
    $('.btn-ok', this).data('recordId', data.recordId);
});

$('#delete-modal').on('click', '.btn-ok', function(e) {
    var $modalDiv = $(e.delegateTarget);
    var tanggal = $(this).data('recordId');
    console.log({ tanggal })
    string_tanggal = tanggal.toString()
    index = array_tgl.indexOf(string_tanggal);
    if (index > -1) {
        total_awal = parseInt($("#total").html())
        current_stock = parseInt($("#th-stok-" + tanggal).html())
        total_akhir = total_awal - current_stock
        $("#tr-" + tanggal).remove()
        $("#total").html(total_akhir)
        array_tgl.splice(index, 1);
    }
    console.log({ array_tgl })
    $modalDiv.addClass('loading');
    setTimeout(function() {
        $modalDiv.modal('hide').removeClass('loading');
    })
});

function addStock() {
    var total_awal = parseInt($("#total").html())
    var m_input_tanggal = document.forms["stockForm"]["stockTanggal"];
    var m_input_stock = document.forms["stockForm"]["stockJumlah"];

    if (m_input_tanggal.value == "") {
        window.alert("Please enter date.");
        m_input_tanggal.focus();
        return false;
    } else {
        var value_tanggal = m_input_tanggal.value;
        var tanggal_for_id = value_tanggal.replace(/-/g, "");
    }

    if (m_input_stock.value == "") {
        window.alert("Please enter stock.");
        m_input_stock.focus();
        return false;
    } else {
        var value_stock = parseInt(m_input_stock.value);
    }

    if (array_tgl.includes(tanggal_for_id)) {
        var stok_awal = parseInt($("#th-stok-" + tanggal_for_id).html())
        var total = stok_awal + value_stock
        $("#th-stok-" + tanggal_for_id).html(total)
        $("#stok-" + tanggal_for_id).val(total)
        var total_all = value_stock + total_awal
        $("#total").html(total_all)
        $('#exampleModal').modal('hide');
    } else {
        var add = '<tr align="center" id="tr-' + tanggal_for_id + '"><td>' + value_tanggal + '<input type="hidden" name="date[]" id="date-' + tanggal_for_id + '" value="' + value_tanggal + '"></td><td id="th-stok-' + tanggal_for_id + '">' + value_stock + '</td><td><button class="btn btn-xs btn-danger" data-record-id="' + tanggal_for_id + '" data-record-title="The first one" data-toggle="modal" data-target="#delete-modal" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button><input type="hidden" name="stok[]" class="input-stock" id="stok-' + tanggal_for_id + '" value="' + value_stock + '"></td></tr>'

        array_tgl.push(tanggal_for_id)
        $("#table-stock tbody").prepend(add);
        var total = value_stock + total_awal
        $("#total").html(total)
        $('#exampleModal').modal('hide');
        console.log({ array_tgl })
    }
}
window.onload = function() {
    //Check File API support
    if (window.File && window.FileList && window.FileReader) {
        $('#files').on("change", function(event) {
            var files = event.target.files; //FileList object
            var output = document.getElementById("result");
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                //Only pics
                // if(!file.type.match('image'))
                if (file.type.match('image.*')) {
                    if (this.files[0].size < 2097152) {
                        // continue;
                        var picReader = new FileReader();
                        picReader.addEventListener("load", function(event) {
                            var picFile = event.target;
                            var div = document.createElement("div");
                            div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                                "title='preview image'>";
                            output.insertBefore(div, null);
                        });
                        //Read the image
                        $('#clear, #result').show();
                        picReader.readAsDataURL(file);
                    } else {
                        alert("Image Size is too big. Minimum size is 2MB.");
                        $(this).val("");
                    }
                } else {
                    alert("You can only upload image file.");
                    $(this).val("");
                }
            }

        });
    } else {
        console.log("Your browser does not support File API");
    }
}

$('#files').on("click", function() {
    $('.thumbnail').parent().remove();
    $('result').hide();
    $(this).val("");
});

$('#clear').on("click", function() {
    $('.thumbnail').parent().remove();
    $('#result').hide();
    $('#files').val("");
    $(this).hide();
});

var harga_jual = document.getElementById('harga_jual');
harga_jual.addEventListener('keyup', function(e) {
    harga_jual.value = formatRupiah(this.value, '');
});

var harga_beli = document.getElementById('harga_beli');
harga_beli.addEventListener('keyup', function(e) {
    harga_beli.value = formatRupiah(this.value, '');
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
