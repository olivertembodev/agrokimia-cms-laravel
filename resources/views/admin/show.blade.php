@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Show Administrator</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-admin')}}">Administrator</a></li>
                    <li class="breadcrumb-item active">Show Administrator</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Nama</label>
                        <div>{{$admin[0]->name}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Alamat</label>
                        <div>{{$admin[0]->address}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Email</label>
                        <div>{{$admin[0]->email}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">No. Telp</label>
                        <div>{{$admin[0]->phone}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">NIP</label>
                        <div>{{$admin[0]->nip}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">NIK</label>
                        <div>{{$admin[0]->nik}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Tanggal Lahir</label>
                        <div>{{$admin[0]->tanggal_lahir}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Status</label>
                        <div>{{$admin[0]->status}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Role</label>
                        <div>{{$admin[0]->role_name}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

@endsection
