@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Administrator</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-admin')}}">Administrator</a></li>
                    <li class="breadcrumb-item active">List Administrator</li>
                </ol>
                <a href="{{route('add-admin')}}" type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Tambah Administrator</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Pilih Role</label>
                                <select name="id_role" id="id_role" class="form-control select2">
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>NIP</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($admins as $admin)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$admin->name}}</td>
                                        <td>{{$admin->nik}}</td>
                                        <td>{{$admin->nip}}</td>
                                        <td>{{$admin->email}}</td>
                                        <td>{{$admin->role_name}}</td>
                                        <td>{{$admin->status}}</td>
                                        <td>
                                            <a href="{{route('edit-admin', $admin->id)}}" class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></a>
                                            <button class="btn btn-xs btn-danger delete-button" deletevalue="{{$admin->id}}" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
                                            <a href="{{route('show-admin', $admin->id)}}" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>
                                        </td>
                                    </tr>
                                @endforeach --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Hapus Admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-ok">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- This is data table -->
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

<script>
    $('#confirm-delete').on('click', '.btn-ok', function(e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //$.ajax({url: '/deletekios/' + id, type: 'POST'})
            $.post('/administrator/delete/' + id).then()
            $modalDiv.addClass('loading');
            setTimeout(function() {
                $modalDiv.modal('hide').removeClass('loading');
                $('#config-table').DataTable().ajax.reload();
            })
        });
    $('#confirm-delete').on('show.bs.modal', function(e) {
        var data = $(e.relatedTarget).data();
        $('.title', this).text(data.recordTitle);
        $('.btn-ok', this).data('recordId', data.recordId);
    });

    $(document).ready(function() {
        var i=0;
        var table=$('#config-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('list-admin-index') }}",
            columns: [
            {
            "data": null,"sortable": false,
            render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                }

            },
            {data: 'name', name: 'name'},
            {data: 'nik', name: 'nik'},
            {data: 'nip', name: 'nip'},
            {data: 'email', name: 'email'},
            {data: 'role_name', name: 'role_name'},
            {data: 'status', name: 'status'},
            //{data: 'foto', name: 'foto'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    });
    $(document).ready(function() {
        $("#id_role").change(function() {
            var role = $("#id_role").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(role){
                $.ajax({
                    type: 'GET',
                    url: '/roleadministrator/' + role,
                    dataType: 'json',
                    success: function(data) {
                        //console.log(data)
                        $("#config-table").DataTable().destroy();
                        var table=$('#config-table').DataTable({
                            processing: true,
                            serverSide: true,
                            "ajax": "/roleadministrator/" + role,
                            columns: [
                            {
                            "data": null,"sortable": false,
                            render: function (data, type, row, meta) {
                                        return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {data: 'name', name: 'name'},
                            {data: 'nik', name: 'nik'},
                            {data: 'nip', name: 'nip'},
                            {data: 'email', name: 'email'},
                            {data: 'role_name', name: 'role_name'},
                            {data: 'status', name: 'status'},
                            //{data: 'foto', name: 'foto'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                            ],
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
            else{
                $.ajax({
                    type: 'GET',
                    url: '/getkios',
                    dataType: 'json',
                    success: function(data) {
                        //console.log(data)
                        $("#config-table").DataTable().destroy();
                        var table=$('#config-table').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": "{{ route('list-admin-index') }}",
                        columns: [
                        {
                        "data": null,"sortable": false,
                        render: function (data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                            }

                        },
                        {data: 'name', name: 'name'},
                        {data: 'nik', name: 'nik'},
                        {data: 'nip', name: 'nip'},
                        {data: 'email', name: 'email'},
                        {data: 'role_name', name: 'role_name'},
                        {data: 'status', name: 'status'},
                        //{data: 'foto', name: 'foto'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                        ],
                    });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });
    });
</script>
@endsection
