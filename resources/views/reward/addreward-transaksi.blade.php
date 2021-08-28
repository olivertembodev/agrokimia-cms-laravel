@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Reward Transaksi</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Reward</a></li>
                    <li class="breadcrumb-item active">Tambah Reward Transaksi</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row ">
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
                    <form action="{{route('storereward-product')}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-body ">
                            <div class="row p-t-20 p-l-30">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Kios</label>
                                        <select class="form-control custom-select" id="nama_kios" name="nama_kios" required>
                                            <option value="">Pilih Nama Kios</option>
                                        @foreach($kios as $tk)
                                            <option value="{{ $tk->id }}">{{ $tk->nama_Kios}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Produk</label>
                                        <select class="form-control custom-select" id="nama_produk" name="nama_produk" required>
                                            <option value="">Pilih Nama Produk</option>
                                        @foreach($produk as $pro)
                                            <option value="{{ $pro->id }}">{{ $pro->nama_produk}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="control-label">Total Reward</label>
                                            <input type="number" name="total_reward" id="total_reward" class="form-control" value="{{ old('total_reward') }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="control-label">Tanggal</label>
                                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status Transaksi Reward</label>
                                        <select class="form-control custom-select" id="nama_produk" name="nama_produk" required>
                                            <option value="">Pilih Status Transaksi</option>
                                        @foreach($status_transaksi as $st)
                                            <option value="{{ $st->nama_status }}">{{ $st->nama_status}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>                    
                            </div>
                            
                        </div>
                        <div class="form-actions p-t-20 p-l-30">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('list-product-reward')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


