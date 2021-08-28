@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Details Berita</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Informasi</a></li>
                    <li class="breadcrumb-item"><a href="{{route('list-news')}}">Berita</a></li>
                    <li class="breadcrumb-item active">Details Berita</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <tbody>
                                
                                <tr>
                                    <th><h3>{{ $news['judul'] }}</h3></th>
                                </tr>
                                <tr>
                                    <th>
                                        <img src="{{ $news['image'] }}" class="rounded mx-auto d-block" style="max-height:400px;" alt="icon">
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="text-justify text-wrap">
                                          {!! $news['deskripsi'] !!}
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Dibuat oleh : {{ $news['admins']['name'] }}</th>
                                </tr>
                                <tr>
                                    <th><a href="">{{ $news['categories']['nama_kategori'] }}</a></th>
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
