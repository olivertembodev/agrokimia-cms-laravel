@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Role</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('role-admin')}}">Role</a></li>
                    <li class="breadcrumb-item active">Edit Role</li>
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
                    <form action="{{route('update-role', $role->id)}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Role Name</label>
                                        <input type="text" name="role_name" class="form-control form-control-danger" value="{{ $role->name }}" placeholder="" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Departement</label>
                                        <select class="form-control custom-select" name="id_departement" required>
                                            <option value="">Pilih Departement</option>
                                            @foreach ($departements as $departement)
                                                @if ($role->id_departement == $departement->id)
                                                    <option value="{{$departement->id}}" selected>{{$departement->nama_departement}}</option>
                                                @else
                                                    <option value="{{$departement->id}}">{{$departement->nama_departement}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control custom-select" name="status" required>
                                            @if ($role->status == 1)
                                                <option value="1" selected>Aktif</option>
                                                <option value="0">Tidak Aktif</option>
                                            @else
                                                <option value="1">Aktif</option>
                                                <option value="0" selected>Tidak Aktif</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                             <label>Akses Menu</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Sub Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $j=1;
                                    @endphp
                                    @foreach ($menu_utamas as $menu_utama)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input menu_utama menu_utama_{{$j}}" name="menus[]" type="checkbox" value="{{$menu_utama->id}}" id="{{$j}}" 
                                                        @foreach ($role_menus as $role)
                                                            @if ($role->menu_id == $menu_utama->id)
                                                                checked
                                                            @endif
                                                        @endforeach    
                                                    >
                                                    <label class="form-check-label" for="menu_utama_{{$j}}">
                                                        {{$menu_utama->nama_menu}}
                                                    </label>
                                                </div>
                                            </td>
                                            @php
                                                $i=1;
                                                $k=1;
                                            @endphp
                                           
                                            @foreach ($sub_menus as $sub_menu)
                                                @if ($sub_menu->parent_menu_id == $menu_utama->menu_id)
                                                    @if ($i == 1) 
                                                        <td>
                                                            <div class="form-check">
                                                            <input class="form-check-input child_from_{{$j}} sub_menu" parentid="{{$j}}" name="menus[]" type="checkbox" value="{{$sub_menu->id}}" id="sub_menu_{{$k}}" @foreach ($role_menus as $role)
                                                                                @if ($role->menu_id == $sub_menu->id)
                                                                                    checked
                                                                                @endif
                                                                            @endforeach>
                                                                <label class="form-check-label" for="sub_menu_{{$k}}">
                                                                    {{$sub_menu->nama_menu}}
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                   
                                                    @else
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input child_from_{{$j}} sub_menu" parentid="{{$j}}" name="menus[]" type="checkbox" value="{{$sub_menu->id}}" id="sub_menu_{{$k}}" @foreach ($role_menus as $role)
                                                                                @if ($role->menu_id == $sub_menu->id)
                                                                                    checked
                                                                                @endif
                                                                            @endforeach>
                                                                    <label class="form-check-label" for="sub_menu_{{$k}}">
                                                                        {{$sub_menu->nama_menu}}
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @php
                                                        $i++
                                                    @endphp
                                                @endif
                                                @php
                                                    $k++
                                                @endphp
                                            @endforeach
                                            @php
                                                $j++;
                                            @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('role-admin')}}" type="button" class="btn btn-inverse">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        $(".menu_utama").click(function(){
            id_induk = $(this).attr('id');
            if ($(this).prop('checked') == true) {
                $(".child_from_"+id_induk).prop("checked", true);
            } else {
                $(".child_from_"+id_induk).prop("checked", false);
            }
        });

        $(".sub_menu").click(function(){
            parent_id = $(this).attr('parentid')

            if ($(this).prop('checked') == true) {
                $(".menu_utama_"+parent_id).prop('checked', true);
            } else {
                if ($(".child_from_"+parent_id+":checked").length == 0){
                    $(".menu_utama_"+parent_id).prop('checked', false);
                }
            }
        });
    });


</script>
@endsection
