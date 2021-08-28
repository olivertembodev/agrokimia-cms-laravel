@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Status Transaksi Reward</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Status Transaksi Reward</a></li>
                    <li class="breadcrumb-item active">Edit Status Transaksi Reward</li>
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
                    <form action="{{route('update-statusreward', $status_reward->id)}}" method="post">@csrf
                        <div class="form-body">
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama Status</label>
                                        <input type="text" name="nama_status" id="nama_status" class="form-control" value="{{ $status_reward->nama_status }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Kode</label>
                                        <input type="text" name="kode_status" id="kode_status" class="form-control" value="{{ $status_reward->kode_status}}" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{ route('statustransaksi-reward')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
