@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Aktivitas Log</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('aktifitas_logs')}}">Aktifitas Log</a></li>
                    <li class="breadcrumb-item active">Tambah Aktivitas Log</li>
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
                    <form action="{{route('update-aktifitaslog', $aktifity_logs->id)}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama Aktivitas</label>
                                        <input type="text" name="nama_aktifitas" id="nama_aktifitas" class="form-control" placeholder="" value="{{$aktifity_logs->nama_aktifitas}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Kode Aktivitas</label>
                                        <input type="text" name="kode_aktifitas" id="kode_aktifitas" class="form-control" placeholder="" value="{{$aktifity_logs->kode_aktifitas}}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                        <a href="{{ route('aktifitas_logs')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection