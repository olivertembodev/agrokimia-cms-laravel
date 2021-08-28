@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Password Principle</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('list-principle') }}">Principle</a></li>
                    <li class="breadcrumb-item active">Edit Password Principle</li>
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
                    @if (session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif (session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.update.principle', [$principle->id]) }}">

                    {{ csrf_field() }}
                    {{ method_field('put') }}

                    <div class="form-group">
                        <label for="current_password" class="col-md-4 control-label">Password Lama</label>
                        <div class="col-md-6">
                            <input id="current_password" type="password" class="form-control" name="current_password" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Password Baru</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="col-md-4 control-label">Konfirmasi Password Baru</label>
                        <div class="col-md-6">
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-success">
                                Change Password
                            </button>
                            <a href="{{route('list-principle')}}" class="btn btn-inverse">Cancel</a>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
