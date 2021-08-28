@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Detail Principles</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-principle')}}">Principles</a></li>
                    <li class="breadcrumb-item active">Detail Principles</li>
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
                                    <th>Name</th>
                                    <th>{{ $principle['nama_principle'] }}</th>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th>{{ $principle['email_principle'] }}</th>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>{{ $principle['alamat_principle'] }}</th>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <th>{{ $principle['phone_principle'] }}</th>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <th>{{ $principle['categories']['name'] }}</th>
                                </tr>
                                <tr>
                                    <th>Logo</th>
                                    <th>
                                        <img src="{{ $principle['logo'] }}" class="rounded float-left" style="height:100px; width:100px;" alt="icon">
                                    </th>
                                </tr>
                                <tr>
                                    <th>Name Pic</th>
                                    <th>{{ $principle['nama_pic'] }}</th>
                                </tr>
                                <tr>
                                    <th>Nomor Pic</th>
                                    <th>{{ $principle['nomor_pic'] }}</th>
                                </tr>
                                <tr>
                                    <th>Email Pic</th>
                                    <th>{{ $principle['email_pic'] }}</th>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <th>{{ $principle['status_principle'] }}</th>
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
