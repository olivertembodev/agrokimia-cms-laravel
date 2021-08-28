@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Fee Admin</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('fee_admin')}}">Fee Admin</a></li>
                    <li class="breadcrumb-item active">Edit Fee Admin</li>
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
                    <form action="{{route('updatefee_admin')}}" method="post">@csrf
                    <input type="hidden" name="id" id="id" class="form-control" value="{{$fee_admin[0]->id}}" placeholder="" required>

                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pilih Type</label>
                                        <select class="form-control custom-select" id="tipe" name="tipe" required>
                                            @if ($fee_admin[0]->tipe == 2)
                                                <option value="2" selected>Nominal</option>
                                                <option value="1">Prosentase</option>
                                            @endif
                                            @if ($fee_admin[0]->tipe == 1)
                                                <option value="2" >Nominal</option>
                                                <option value="1" selected>Prosentase</option>

                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 hide" id="option-1">
                                    <div class="form-group">
                                        <label class="control-label">Presentase</label>
                                        <input type="number" name="is_precentage" id="is_precentage" class="form-control" value="0" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select class="form-control custom-select" id="status" name="status" required>
                                        @if ($fee_admin[0]->status == 1)
                                                <option value="1" selected>Aktif</option>
                                                <option value="0">Tidak Aktif</option>
                                            @endif
                                            @if ($fee_admin[0]->status == 0)
                                                <option value="1" >Aktif</option>
                                                <option value="0" selected>Tidak Aktif</option>

                                            @endif
                                    </select>
                                </div>
                                <div class="col-md-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label">Nominal</label>
                                        <input type="number" name="nominal" id="nominal" class="form-control" value="0" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6 hide" id="option-2" style="display: inline;">
                                    <div class="form-group">
                                        <label class="control-label">Jumlah</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{$fee_admin[0]->jumlah}}" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                        <a href="{{ route('fee_admin')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script src="{{URL::asset('js')}}/add-feeadmin.js"></script>
@endsection