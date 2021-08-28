@extends('layouts._layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />

<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Area</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                    <li class="breadcrumb-item"><a href="{{route('area')}}">Area</a></li>
                    <li class="breadcrumb-item active">Tambah Area</li>
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
                    <form action="{{route('store-area')}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="province_code" value="" id="province" class="form-control select2 col-sm-12 col-md-7" required>
                                            <option value="">Pilih Provinsi</option>
                                            @foreach($provincies as $item)
                                                @if (old('province_code') == $item->province_code)
                                                    <option value="{{ $item->province_code }}" selected>{{ $item->name }}</option>
                                                @else
                                                    <option value="{{ $item->province_code }}">{{$item->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="city_code" value="" id="city" class="form-control select2 col-sm-12 col-md-7" required>
                                            <option value="">Pilih Kota</option>
                                            @foreach ($cities as $item)
                                                @if (old('city_code') == $item->city_code)
                                                    <option value="{{ $item->city_code }}" selected>{{ $item->name }}</option>
                                                @else
                                                    <option value="{{ $item->city_code }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Nama Area</label>
                                        <input type="text" name="name" id="nama" class="form-control" value="{{ old('name') }}" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Kode Area</label>
                                        <input type="number" name="area_code" id="area_code" class="form-control" value="{{ old('area_code') }}" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-12">
                                            <label class="control-label">Pilih Kecamatan</label>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <select name="kecamatan_code[]" value="" id="kecamatan" class="form-control select2 col-sm-12 col-md-7" multiple
                                                @foreach ($kecamatans as $item)
                                                        <option value="{{ $item->kecamatan_code }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('area')}}" type="button" class="btn btn-inverse">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>
    <script>
        $(document).ready(function() {
            $("#province").change(function() {
                var provid = $("#province").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if(provid) {
                    $.ajax({
                        type: 'GET',
                        url: '/master/area/list-cities/' + provid,
                        dataType: 'json',
                        success: function(data) {
                            $("#city").empty();
                            $("#city").append("<option value=''>Pilih Kota</option>");
                            for (let i = 0; i < data.length; i++) {
                                $("#city").append("<option value=" + data[i].city_code + ">" + data[i].name + "</option>");
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });

            $("#city").change(function() {
                var cityid = $("#city").val();
                if(cityid) {
                        $.ajax({
                            type: 'GET',
                            url: '/master/area/list-kecamatan/' + cityid,
                            dataType: 'json',
                            success: function(data) {
                                $("#kecamatan").empty();
                                $("#kecamatan").append("<option value=''>Pilih Kecamatan</option>");
                                for (let i = 0; i < data.length; i++) {
                                    $("#kecamatan").append("<option value=" + data[i].kecamatan_code + ">" + data[i].name + "</option>");
                                }
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    }
            });

            // $("#nama").on('keyup', function() {
            //     var nama = $("#nama").val();
            //     if (nama) {
            //         $.ajax({
            //             type : 'GET',
            //             url  : '/master/area/list-area-code/' + nama,
            //             dataType : 'json',
            //             success  : function(data) {
            //                     $("#area_code").val(data[0].area_code);
            //                     $("#area_code").attr('readonly', true);
            //                 },
            //                     error: function(data) {
            //                     console.log(data);
            //                 }
            //         });
            //     }
            //     nama = $("#area_code").val(null).attr('readonly', false);
            // });

            

        });
    </script>
     <script>
        $(document).ready(function(){
            $('.select2').select2();
        })
    </script>
@endsection
