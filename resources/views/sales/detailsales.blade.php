@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Show Sales</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-sales')}}">Sales</a></li>
                    <li class="breadcrumb-item active">Show Sales</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Nama Sales</label>
                        <div>{{$sales[0]->nama_sales}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Kota</label>
                        <div>{{$sales[0]->id_kota}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Area</label>
                        <div>{{$sales[0]->id_area}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Alamat Sales</label>
                        <div>{{$sales[0]->alamat_sales}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">NIK</label>
                        <div>{{$sales[0]->nik}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">NIP</label>
                        <div>{{$sales[0]->nip}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Jenis Kelamin</label>
                        <div>{{$sales[0]->jenis_kelamin}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Email</label>
                        <div>{{$sales[0]->email}}</div>
                    </div>
                    {{-- <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Password</label>
                        <div>{{$sales[0]->password}}</div>
                    </div> --}}
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Status</label>
                        <div>
                            @php
                                if($sales[0]->status==0){
                                    echo "Tidak Aktif";
                                }else{
                                    echo "Aktif";
                                }
                            @endphp
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Foto</label>
                        <div>
                            <img src="{{$sales[0]->foto}}" class="img-thumbnail" alt="foto $sales[0]->nama_sales" width="30%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

@endsection
