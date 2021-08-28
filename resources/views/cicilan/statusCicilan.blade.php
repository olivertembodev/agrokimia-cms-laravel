@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Status Cicilan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-cicilan')}}">Cicilan</a></li>
                    <li class="breadcrumb-item active">Status Cicilan</li>
                </ol>
            </div>
        </div>
        
    </div>
    <div  class="row">
        <div  class="col-lg-3"></div>
        <div  class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <tbody>
                                <tr>
                                <th>Status Transaksi Cicilan</th>
                                </tr>
                                <tr>
                                    <th>
                                        @php
                                            if($data[0]->status==1){
                                            echo "Lunas";
                                        } else {
                                            echo "Belum Lunas";
                                        }
                                        @endphp
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
