@extends('layouts._layout')
@section('asset')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Stok</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Produk</a></li>
                    <li class="breadcrumb-item active">Tambah Stok</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body ml-5">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form id="form_id" action="" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-body ">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pilih Kategori Produk</label>
                                        <select class="select2 form-control custom-select" name="id_category_product" id="category_product">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['nama_category'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pilih Principle</label>
                                        <select class="select2 form-control custom-select" name="id_principle" id="select_principle">
                                            <option value="">Pilih Priciple</option>
                                            @foreach($principles as $principle)
                                            <option value="{{ $principle['id'] }}">{{ $principle['nama_principle'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Pilih Produk</label>
                                        <select id="select_product" class="select2 form-control custom-select" name="id_produk">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Stock</label><br>
                                        <input type="number" name="stok" class="form-control col-md-11" value="{{ old('stok') }}"><span class="float-right mt-2" id="satuan"></span>
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
@endsection
@section('script')
<script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});

$("#select_principle").on('change', function() {
    var category_product = $("#category_product").val();
    var principle = $("#select_principle").val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/get-produk/' + category_product + '/' + principle,
        dataType: 'json',
        success: function(data) {
            console.log(data)

            $("#select_product").empty();
            $("#select_product").append("<option value=''>Pilih Produk</option>");
            for (let i = 0; i < data.length; i++) {

                $("#select_product").append("<option value=" + data[i].id + ">" + data[i].nama_product + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
});

$("#select_product").on('change', function() {
    product_id = $("#select_product").val();
    $.get("/get-satuan/" + product_id, function(data, status) {
        console.log(data.satuan)
        $('#satuan').text(data.satuan)
    });
    $("#form_id").attr("action", "/product/stock/update/" + product_id);
});

</script>
@endsection
