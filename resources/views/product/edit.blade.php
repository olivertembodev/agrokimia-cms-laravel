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
            <h4 class="text-themecolor">Edit Product</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Product</a></li>
                    <li class="breadcrumb-item active">Edit Product</li>
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
                    <form action="{{route('update-product', $product['id'] )}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-body ">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama Produk</label>
                                        <input type="text" name="nama_product" id="" class="form-control" value="{{ $product['nama_product'] }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select class="form-control custom-select" name="id_category_product" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                            @if ( $product['id_category_product'] == $category['id'] )
                                            <option value="{{ $category['id'] }}" selected>{{ $category['nama_category'] }}</option>
                                            @else
                                            <option value="{{ $category['id'] }}">{{ $category['nama_category'] }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Principle</label>
                                        <select class="form-control custom-select" name="id_principle" required>
                                            <option value="">Pilih Principle</option>
                                            @foreach($principles as $principle)
                                            @if ( $product['id_principle'] == $principle['id'] )
                                            <option value="{{ $principle['id'] }}" selected>{{ $principle['nama_principle'] }}</option>
                                            @else
                                            <option value="{{ $principle['id'] }}">{{ $principle['nama_principle'] }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nomor Lot Produk</label><br>
                                        <input type="text" name="lot_product" class="form-control" value="{{ $product['lot_product'] }}" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Berat Produk &nbsp; <small>(gram)</small></label>
                                        <input type="number" name="berat_product" id="" class="form-control" value="{{ $product['berat_product'] }}" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Deskripsi</label>
                                        <textarea id="deskripsi" class="form-control summernote" name="deskripsi" rows="5" cols="50" required>{{ $product['deskripsi'] }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cara Pakai</label>
                                        <textarea id="deskripsi" class="form-control summernote" name="cara_pakai" rows="5" cols="50" required>{{ $product['cara_pakai'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Expired Date</label><br>
                                        <input type="date" name="expired_date" class="form-control" value="{{ $product['expired_date'] }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Reward Poin</label><br>
                                        <input type="number" name="reward_poin" class="form-control" value="{{ $product['reward_poin'] }}" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Harga Jual</label><br>
                                        <input type="text" id="harga_jual" name="harga_jual" class="form-control" value="{{ $product['harga_jual'] }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Harga Beli</label><br>
                                        <input type="text" id="harga_beli" name="harga_beli" class="form-control" value="{{ $product['harga_beli'] }}" placeholder="" required>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php($total = 0)
                                                @foreach ($product['riwayats'] as $r)
                                                <tr align="center" id="tr-{{ $r->date_id }}">
                                                    <td>{{ $r->date }}
                                                        <input type="hidden" name="date[]" id="date-{{ $r->date_id }}" value="{{ $r->date }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="stok" id="stok-{{ $r->date_id }}" style="text-align: center;" before="{{ $r->stok }}" name="stok[]" min="0" value="{{ $r->stok }}" oninput="ubah_stok(this.value, this.id)">
                                                    </td>
                                                </tr>
                                                @php($total += $r->stok)
                                                @endforeach
                                                <tr align="center">
                                                    <th>Total Stock :</th>
                                                    <th id="total">{{ $total }}</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Satuan</label><br>
                                        <input spellcheck="false" type="text" id="satuan" name="satuan" class="form-control" value="{{ $product['satuan'] }}" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Images</label><br>
                                        <input id="files" class="form-control col-md-8 mb-2" type="file" name="images[]" multiple>
                                        <button class="col-md-2 float-right" type="button" id="clear">Clear</button>
                                        <output class="w-100" id="result">
                                            @foreach ( $images as $image)
                                            <div>
                                                <img class="thumbnail" src="{{ $image['image'] }}" title="preview image">
                                            </div>
                                            @endforeach
                                        </output>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions float-right mt-5">
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
@endsection
@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script>
var array_tgl = [
    @foreach($product['riwayats'] as $r)
    "{{ $r->date_id }}",
    @endforeach
];

$(document).ready(function() {
    $('#clear, #result').show();
    // $(".datepicker").datepicker({
    //     dateFormat: "yy-mm-dd",
    // });
    $('.summernote').summernote({

        height: 200,

    });
});

$(document).keypress(
    function(event) {
        if (event.which == 13) {
            event.preventDefault();
        }
    });

$(".stok").keypress(function(e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        alert('Input hanya angka !')
        return false;
    }
});

function ubah_stok(val, id) {
    var before = parseInt($("#" + id).attr('before'))
    var total_awal = parseInt($("#total").html())
    val = (val == '') ? 0 : val;

    if (before < val) {
        var selisih = val - before
        var total_all = total_awal + selisih
    } else {
        var selisih = before - val
        var total_all = total_awal - selisih
    }
    $("#" + id).attr('before', val)
    $("#total").html(total_all)
}

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
        var stok_awal = parseInt($("#stok-" + tanggal_for_id).val())
        var total = stok_awal + value_stock
        $("#stok-" + tanggal_for_id).attr('before', total)
        $("#stok-" + tanggal_for_id).val(total)
        var total_all = value_stock + total_awal
        $("#total").html(total_all)
        $('#exampleModal').modal('hide');
    } else {
        var add = '<tr align="center" id="tr-' + tanggal_for_id + '"><td>' + value_tanggal + '<input type="hidden" name="new_date[]" id="date-' + tanggal_for_id + '" value="' + value_tanggal + '"></td><td><input type="number" class="stok" id="stok-' + tanggal_for_id + '" style="text-align: center;" name="new_stok[]" min="0" before="' + value_stock + '" value="' + value_stock + '" oninput="ubah_stok(this.value,this.id)"></td></tr>'

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
