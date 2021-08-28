@extends('layouts._layout')
@section('style')
<style>
    .thumbnail{

    height: 100px;
    margin: 10px; 
    float: left;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Detail Produk</h4>
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="detail-table" class="table display table-bordered table-striped no-wrap">
                        <tbody>
                            <tr>
                                <th width="35%">Nama Produk</th>
                                <td>{{ $product->nama_product }}</td>
                            </tr>
                            <tr>
                                <th>Lot Produk</th>
                                <td>{{ $product->lot_product }}</td>
                            </tr>
                            <tr>
                                <th>Nama Principle</th>
                                <td>{{ $product->principles->nama_principle }}</td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td>Rp. {{ $product->harga_jual }} / {{ $product->satuan }}</td>
                            </tr>
                            <tr>
                                <th>Harga Beli</th>
                                <td>Rp. {{ $product->harga_beli }} / {{ $product->satuan }}</td>
                            </tr>
                            <tr>
                                <th>Berat Product</th>
                                <td>{{ $product->berat_product }} gram</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{!! $product->deskripsi !!}</td>
                            </tr>
                            <tr>
                                <th>Cara Pakai</th>
                                <td>{!! $product->cara_pakai !!}</td>
                            </tr>
                            <tr>
                                <th>Expired Date</th>
                                <td>{{ $product->expired_date }}</td>
                            </tr>
                            <tr>
                                <th>Reward Poin</th>
                                <td>{{ $product->reward_poin }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>{{ $product->stocks->stok }} {{ $product->satuan }}</td>
                            </tr>

                            <tr>
                                <th>Images</th>
                                <th>
                                    @foreach ( $product->images as $image)
                                    <div>
                                        <img class="thumbnail" src="{{ $image->image }}" title="preview image">
                                    </div>
                                    @endforeach
                                </th>
                            </tr>
                            <tr>
                                <th>Created by</th>
                                <td>{{ $product->dibuat }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{route('list-product')}}"><button type="button" class="btn btn-info float-right">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
