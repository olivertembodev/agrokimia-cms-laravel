@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Show Kios</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-kios')}}">Kios</a></li>
                    <li class="breadcrumb-item active">Show Kios</li>
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
                                    <th>{{ $data[0]->nama_Kios }}</th>
                                </tr>
                                <tr>
                                    <th>Nama Kios Utama</th>
                                    <th>
                                        @if (iterator_count($kios_utama))
                                            @php
                                                echo $kios_utama[0]->nama_Kios;
                                            @endphp
                                        @else
                                            @php
                                                echo "-";
                                            @endphp
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th>Tipe Kios</th>
                                    <th>
                                        {{$data[0]->nama_tipe_kios}}
                                    </th>
                                </tr>
                                <tr>
                                    <th>Category Kios</th>
                                    <th>
                                        {{$data[0]->tipe_kios}}
                                    </th>
                                </tr>
                                <tr>
                                    <th>Kota</th>
                                    <th>{{$data[0]->id_kota }}</th>
                                </tr>
                                <tr>
                                    <th>Area</th>
                                    <th>{{ $data[0]->id_area}}</th>
                                </tr>
                                <tr>
                                    <th>Alamat Kios</th>
                                    <th>{{ $data[0]->alamat_kios }}</th>
                                </tr>
                                <tr>
                                    <th>Maps</th>
                                    <th>
                                        <div class="mapouter">
                                            <div class="gmap_canvas">
                                                @php
                                                    $link="https://maps.google.com/maps?q=".$data[0]->latitude.",".$data[0]->longitude."&t=&z=20&ie=UTF8&iwloc=&output=embed";
                                                @endphp
                                                <iframe width="600" height="500" id="gmap_canvas" src="<?= $link; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                                                </iframe>
                                                <a href="https://www.bitgeeks.net"></a>
                                            </div>
                                            <style>
                                            .mapouter{position:relative;text-align:right;height:500px;width:600px;}
                                            .gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}
                                            </style>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Latitude</th>
                                    <th>{{ $data[0]->latitude }}</th>
                                </tr>
                                <tr>
                                    <th>Longitude</th>
                                    <th>{{ $data[0]->longitude }}</th>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th>{{$data[0]->email }}</th>
                                </tr>
                                <tr>
                                    <th>Nama PIC</th>
                                    <th>{{$data[0]->nama_pic }}</th>
                                </tr>
                                <tr>
                                    <th>Nomor HP PIC</th>
                                    <th>{{$data[0]->nomor_hp_pic }}</th>
                                </tr>
                                <tr>
                                    <th>Nomor KTP PIC</th>
                                    <th>{{$data[0]->nomor_ktp_pic }}</th>
                                </tr>
                                <tr>
                                    <th>Nomor NPWP PIC</th>
                                    <th>{{ $data[0]->nomor_npwp_pic }}</th>
                                </tr>
                                <tr>
                                    <th>Image KTP</th>
                                    <th>
                                        <img src="{{ $data[0]->image_ktp }}" alt="icon" class="rounded float-left" style=" width:10%;">

                                    </th>
                                </tr>
                                <tr>
                                    <th>Image NPWP</th>
                                    <th><img src="{{ $data[0]->image_npwp }}" alt="icon" class="rounded float-left" style=" width:10%;"></th>
                                </tr>
                                <tr>
                                    <th>Image Kios Depan</th>
                                    <th><img src="{{ $data[0]->image_kios_depan }}" alt="icon" class="rounded float-left" style=" width:10%;"></th>
                                </tr>
                                <tr>
                                    <th>Image Kios Dalam</th>
                                    <th><img src="{{ $data[0]->image_kios_dalam }}" alt="icon" class="rounded float-left" style=" width:10%;"></th>
                                </tr>
                                <tr>
                                    <th>Image Selfie KTP</th>
                                    <th><img src="{{ $data[0]->image_selfi_ktp }}" alt="icon" class="rounded float-left" style=" width:10%;"></th>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <th>
                                        @if ($data[0]->status==1)
                                            Aktif
                                        @elseif($data[0]->status==0)
                                            Tidak Aktif
                                        @else
                                            Expired
                                        @endif
                                    </th>
                                </tr>
                                {{-- <tr>
                                    <th>Status</th>
                                    <th>{{ $data[0]->status }}</th>
                                </tr> --}}
                                <tr>
                                    <th>Date Exp</th>
                                    <th>{{ $data[0]->exp_date }}</th>
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

@section('script')

@endsection
