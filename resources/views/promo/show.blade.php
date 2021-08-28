@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Detail Promotion</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-promo')}}">Promotion</a></li>
                    <li class="breadcrumb-item active">Detail Promotion</li>
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
                                    <th>Nama Kupon</th>
                                    <th>{{ $promo['nama_kupon'] }}</th>
                                </tr>
                                <tr>
                                    <th>Mulai Dari</th>
                                    <th>{{ $promo['start_date'] }}</th>
                                </tr>
                                <tr>
                                    <th>Berakhir</th>
                                    <th>{{ $promo['end_date'] }}</th>
                                </tr>
                                <tr>
                                    <th>Tipe Promo</th>
                                    <th>{{ $promo['promo_types']['nama_type'] }}</th>
                                </tr>
                                <tr>
                                    <th>Jumlah/Persentasi</th>
                                    <th>{{ $promo['is_percentage'] }}%</th>
                                </tr>
                                <tr>
                                    <th>Minimal Transaksi</th>
                                    <th>
                                        @php
                                            echo"Rp. ". number_format($promo['minimal_transaksi'],0,",",".");
                                        @endphp
                                    </th>

                                </tr>
                                <tr>
                                    <th>Potongan</th>
                                    <th>{{ $promo['potongan'] }}</th>
                                </tr>
                                <tr>
                                    <th>Maksimal Potongan</th>
                                    <th>
                                        @php
                                            echo"Rp. ". number_format($promo['max_potongan'],0,",",".");
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
</div>
@endsection
