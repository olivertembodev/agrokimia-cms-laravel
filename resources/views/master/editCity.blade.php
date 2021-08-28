@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Kota</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                    <li class="breadcrumb-item"><a href="{{route('kota')}}">Kota</a></li>
                    <li class="breadcrumb-item active">Edit Kota</li>
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
                    <form action="{{route('update-city')}}" method="post">@csrf
                        <div class="form-body">
                        <input type="hidden" name="id" value="{{$city['id']}}">
                            <div class="row p-t-20">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <select name="province" id="province" class="form-control select2 col-sm-12 col-md-7" required>
                                        <option value="">Pilih Provinsi</option>
                                            @foreach ($prov  as $item)
                                                @if ($item->province_code == $city['province_code']) 
                                                    <option value="{{$item->province_code}}" selected>{{$item->name}}</option>
                                                @else
                                                    <option value="{{$item->province_code}}">{{$item->name}}</option>
                                                @endif
                                            @endforeach                                            
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Kode Kota</label>
                                        <input type="number" name="city_code" id="nama" class="form-control" value="{{ $city['city_code'] }}" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Nama</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $city['name'] }}" placeholder="" requireds>
                                    </div>
                                </div>
                            </div>
                        </div>
                          
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('kota')}}" type="button" class="btn btn-inverse">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
