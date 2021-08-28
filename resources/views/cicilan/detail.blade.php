@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Detail Cicilan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-cicilan')}}">Cicilan</a></li>
                    <li class="breadcrumb-item active">Detail Cicilan</li>
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
                                    <th>No Invoice</th>
                                    <th>{{ $data[0]->no_invoice }}</th>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>{{ $data[0]->date }}</th>
                                </tr>
                                <tr>
                                    <th>Kios</th>
                                    <th>{{ $data[0]->id_kios }}</th>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th>@php
                                        echo"Rp. ". number_format($data->sum('total'),0,",",".");
                                    @endphp
                                    </th>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $data)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{$data->id_product }}</td>
                                        <td>
                                            {{$data->jumlah }}
                                        </td>
                                        <td>
                                            @php
                                                echo"Rp. ". number_format($data->harga,0,",",".");
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                echo"Rp. ". number_format($data->total,0,",",".");
                                            @endphp
                                        </td>
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
