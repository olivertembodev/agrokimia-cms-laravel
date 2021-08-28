@extends('layouts._layout')
@section('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Top Product</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Kredit</a></li>
                    <li class="breadcrumb-item active">Tambah Kredit</li>
                </ol> -->
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
                    <form action="{{route('top-product-update', $top_product['id'])}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-body ">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pilih Produk</label>
                                        <select class="select2 form-control custom-select" name="id_product[]" id="product" multiple>
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $product)
                                                @if ($product['id'] == $top_product['id_product'])
                                                <option value="{{ $product['id'] }}" selected>{{ $product['nama_product'] }}</option>
                                                @else
                                                <option value="{{ $product['id'] }}">{{ $product['nama_product'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Expired Top Produk</label>
                                        <input name="expired_top_product" id="expired_top_product" class="form-control datepicker" value="{{ $top_product['expired_top_product'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions mt-3">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('top-product')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
    });
});

</script>
@endsection
