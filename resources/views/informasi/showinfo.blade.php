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
            <h4 class="text-themecolor">Detail Notifikasi</h4>
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
                                <th width="35%">Judul</th>
                                <td>{{ $notif[0]->judul}}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>{{ $notif[0]->nama_Kios ? $notif[0]->nama_Kios :$notif[0]->nama_sales }}</td>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <td>{{ $notif[0]->area_name }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $notif[0]->tanggal }}</td>
                            </tr>
                            <tr>
                                <th>Waktu</th>
                                <td>{{$notif[0]->waktu }}</td>
                                {{-- <td>{{ date('H:i:s', strtotime($notif[0]->created_at) ) }}</td> --}}
                            </tr>
                            <tr>
                                <th>Dibuat Oleh</th>
                                <td>{{ $notif[0]->admin_name }}</td>
                            </tr>
                            <tr>
                                    <th>Deskripsi</th>
                                    <td>{!! $notif[0]->deskripsi !!}</td>
                            </tr> 
                        </tbody>
                    </table>
                    <a href="{{route('list-notification')}}"><button type="button" class="btn btn-info float-right">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
