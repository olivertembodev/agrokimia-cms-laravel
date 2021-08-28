@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Tipe Cicilan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('tipe_cicilan')}}">Tipe Cicilan</a></li>
                    <li class="breadcrumb-item active">Edit Tipe Cicilan</li>
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
                    <form action="{{route('updatecicilan', $data->id)}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tenor</label>
                                        <input type="text" name="tenor" id="tenor" class="form-control" value="{{ $data->tenor }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tipe</label>
                                        <select name="tipe" id="tipe" class="form-control" required>
                                            @if ($data->tipe == 1)
                                                <option value="1" selected>Hari</option>
                                                <option value="2">Minggu</option>
                                                <option value="3">Bulan</option>
                                                <option value="4">Tahun</option>
                                            @elseif ($data->tipe == 2)
                                                <option value="1">Hari</option>
                                                <option value="2" selected>Minggu</option>
                                                <option value="3">Bulan</option>
                                                <option value="4">Tahun</option>
                                            @elseif ($data->tipe == 3)
                                                <option value="1">Hari</option>
                                                <option value="2">Minggu</option>
                                                <option value="3" selected>Bulan</option>
                                                <option value="4">Tahun</option>
                                            @elseif ($data->tipe == 4)
                                                <option value="1">Hari</option>
                                                <option value="2">Minggu</option>
                                                <option value="3">Bulan</option>
                                                <option value="4" selected>Tahun</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Jumlah Hari</label>
                                        <input type="text" name="day_per_month" id="day_per_month" class="form-control" value="{{ $data->day_per_mounth }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            @if ($data->status == 1)
                                                <option value="1" selected>Aktif</option>
                                                <option value="0">Tidak Aktif</option>
                                            @else
                                                <option value="1">Aktif</option>
                                                <option value="0" selected>Tidak Aktif</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{ route('tipe_cicilan') }}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
