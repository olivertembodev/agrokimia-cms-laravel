@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Tipe User</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Master</a></li>
                    <li class="breadcrumb-item"><a href="{{route('tipe_user')}}">Tipe User</a></li>
                    <li class="breadcrumb-item active">Tambah Tipe User</li>
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
                    <form action="{{route('store-tipe_user')}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Kode Tipe User</label>
                                        <input type="number" name="kode_user" id="nama" class="form-control" value="{{ old('kode_user') }}" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Nama Tipe User</label>
                                        <input type="text" name="nama_kode" id="nama" class="form-control" value="{{ old('nama_kode') }}" placeholder="" required>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                            <!--/row-->
                          
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('tipe_user')}}" type="button" class="btn btn-inverse">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
