@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Role Pembayaran</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('role_pembayaran')}}">Role Pembayaran</a></li>
                    <li class="breadcrumb-item active">Tambah Role Pembayaran</li>
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
                    <form action="{{route('storerole_pembayaran')}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <label>Tipe Kios</label>
                                    <select class="form-control custom-select" id="id_tipe_kios" name="id_tipe_kios" required>
                                        <option value="">Pilih Tipe Kios</option>
                                    @foreach($tipe_kios as $tk)
                                        <option value="{{ $tk->id }}">{{ $tk->nama_tipe_kios}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Metode Pembayaran</label>
                                    <select class="form-control custom-select" id="id_tipe_pembayaran" name="id_tipe_pembayaran" required>
                                        <option value="">Pilih Metode Pembayaran</option>
                                    @foreach($tipe_pembayarans as $mp)
                                        <option value="{{ $mp->id }}">{{ $mp->nama_metode}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                        <a href="{{ route('role_pembayaran')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection