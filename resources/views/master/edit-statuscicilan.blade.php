@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Status Cicilan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Status Cicilan</a></li>
                    <li class="breadcrumb-item active">Edit Status Cicilan</li>
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
                    <form action="{{route('update-statuscicilan', $status_cicilan->id)}}" method="post">@csrf
                        <div class="form-body">
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama Status</label>
                                        <input type="text" name="nama_status" id="nama_status" class="form-control" value="{{ $status_cicilan->nama_status }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Kode</label>
                                        <input type="text" name="kode" id="kode" class="form-control" value="{{ $status_cicilan->kode}}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select class="form-control custom-select" id="status" name="status" required>
                                        <option value="0">Aktif</option>
                                        <option value="1">Tidak Aktif</option>
                                    </select>
                                </div>
                                <!--/span-->
                            </div>
                        </div>
                        <br><br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{ route('status_cicilan')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
