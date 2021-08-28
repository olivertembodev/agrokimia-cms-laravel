@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Role Pembayaran</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('role_pembayaran') }}">Role Pembayaran</a></li>
                    <li class="breadcrumb-item active">Edit Role Pembayaran</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
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
                    <form action="{{route('updaterole_pembayaran', $role_pembayarans[0]->id)}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tipe Kios</label>
                                        <select class="form-control custom-select" id="id_tipe_kios" name="id_tipe_kios" required>
                                            <option value="">Pilih Tipe Kios</option>
                                        @foreach($tipe_kios as $tk)
                                            @if ($tk->id == $role_pembayarans[0]->id_tipe_kios)
                                                <option value="{{ $tk->id }}" selected>{{ $tk->nama_tipe_kios}}</option>
                                            @else
                                                <option value="{{ $tk->id }}">{{ $tk->nama_tipe_kios}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tipe Pembayaran</label>
                                        <select class="form-control custom-select" id="id_tipe_pembayaran" name="id_tipe_pembayaran" required>
                                            <option value="">Pilih Tipe Pembayaran</option>
                                        @foreach($tipe_pembayarans as $mp)
                                            @if ($mp->id == $role_pembayarans[0]->id_tipe_pembayaran)
                                                <option value="{{ $mp->id }}" selected>{{ $mp->nama_metode}}</option>
                                            @else
                                                <option value="{{ $mp->id }}">{{ $mp->nama_metode}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                        </div>
                        <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{ route('role_pembayaran') }}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
