@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Detail Transaksi</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-transaksi')}}">Transaksi</a></li>
                    <li class="breadcrumb-item active">Detail Transaksi</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <tbody>
                                <tr>
                                    <th>Nama Kios</th>
                                    <td>{{ $transaksis[0]->nama_Kios }}</td>
                                </tr>
                                <tr>
                                    <th>No. Invoice</th>
                                    <td>
                                        {{$transaksis[0]->no_invoice}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>
                                        {{$transaksis[0]->tanggal}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Transaksi</th>
                                    <td>{{$transaksis[0]->id_status_transaksi }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>{{ $transaksis[0]->id_tipe_pembayaran}}</td>
                                </tr>
                                <tr>
                                    <th>Total Transaksi</th>
                                    <td>Rp. {{ number_format($transaksis[0]->total, 0, ",", ".")}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div>
                        <h5>List Product</h5>
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaksi->nama_product }}</td>
                                        <td>{{ $transaksi->jumlah }}</td>
                                        <td>Rp. {{ number_format($transaksi->harga_jual, 0, ",", ".") }}</td>
                                        <td>Rp. {{ number_format($transaksi->harga_jual*$transaksi->jumlah, 0, ",", ".") }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

@endsection
