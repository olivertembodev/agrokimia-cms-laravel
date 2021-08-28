@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Kios</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                <a href="{{route('list-kios')}}"><li class="breadcrumb-item"><a href="{{ route('list-kios') }}">Kios</a></li></a>
                    <li class="breadcrumb-item active">List Kios</li>
                </ol>
            <a href="{{route('add-kios')}}">
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Tambah Kios</button>
            </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Pilih Kota</label>
                                <select name="id_kota" id="id_kota" class="form-control select2">
                                    <option value="">Pilih Kota</option>
                                    @foreach ($cities as $item)
                                        <option value="{{$item->city_code}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Pilih Area</label>
                                <select class="form-control select2" name="area_code" id="area">
                                    <option value=''>Pilih Area</option>
                                </select>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap mdl-data-table dataTable">
                            <thead>
                                <tr>
                                    {{-- <th>No</th> --}}
                                    <th>Nama Kios</th>
                                    <th>PIC</th>
                                    <th>Alamat Kios</th>
                                    <th>Email</th>
                                    <th>No HP PIC</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($data as $kios)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{$kios->nama_Kios }}</td>
                                        <td>{{$kios->nama_pic}}</td>
                                        <td>{{$kios->alamat_kios}}</td>
                                        <td>{{$kios->email}}</td>
                                        <td>{{$kios->nomor_hp_pic}}</td>
                                        <td>{{$kios->status}}</td>
                                        <td>
                                            <a href="{{route('editKios', $kios->id)}}"><button class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></button></a>
                                            <button class="btn btn-xs btn-danger delete-button" deletevalue="{{$kios->id}}" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
                                            <button class="btn btn-xs btn-success status-button" deletevalue="{{$kios->id}}" type="button"><span class="btn-label"><i class="fa fa-undo"></i></span></button>
                                            <a href="{{ route('detailkios', $kios->id) }}" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>
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
{{-- modal status jangan diusik --}}
<div id="status-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        {{-- <form id="update-form" action="" method="POST">@csrf --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Update Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="cb_expdate">
                        <label class="form-check-label" for="exampleCheck1">Expired Date</label>
                      </div>
                    <div class="form-group">
                        <label class="control-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                            <option value="2">Expired</option>
                        </select>
                    </div>
                    <label class="control-label" for="exp_date" id="labelexp">Exp Date</label>
                    <input type="date" class="form-control" id="exp_date" name="exp_date">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info btn-danger waves-effect btn-yes">Update</button>
                </div>
            </div>
        {{-- </form> --}}
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- modal delete monggo disesuaikan --}}
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Hapus Kios</h4>
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
{{-- akhir modal delete --}}
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
            $.post('/kios/delete/' + id).then()
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


    $('#status-modal').on('click', '.btn-yes', function(e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            var date = $('#exp_date').val();
            var status = $('#status').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/updatestatuskios',
                type: 'POST',
                dataType: 'json',
                data: {
                    "id":id,
                    "tanggal":date,
                    "status":status,
                },
                success:function(data){
                    console.log(id);
                },
                error: function(data) {
                    console.log(data);
                }
            })
            $modalDiv.addClass('loading');
            setTimeout(function() {
                $modalDiv.modal('hide').removeClass('loading');
                $('#config-table').DataTable().ajax.reload();
            })
        });
    $('#status-modal').on('show.bs.modal', function(e) {
        var data = $(e.relatedTarget).data();
        $('.title', this).text(data.recordTitle);
        $('.btn-yes', this).data('recordId', data.recordId);
    });


    $(document).ready(function() {
        $('#exp_date').hide();
        $('#labelexp').hide();
        $("#cb_expdate").change(function(){
            if($(this).is(':checked')){
                $('#exp_date').show();
                $('#labelexp').show();
            }else{
                $('#exp_date').hide();
                $('#labelexp').hide();
            }
        });
    });
    $(document).ready(function() {
        var i=0;
        var table=$('#config-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('getkios') }}",
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            columns: [
            {data: 'nama_Kios', name: 'nama_Kios'},
            {data: 'nama_pic', name: 'nama_pic'},
            {data: 'alamat_kios', name: 'alamat_kios'},
            {data: 'email', name: 'email'},
            {data: 'nomor_hp_pic', name: 'Nomor_Hp'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'},
            ],
        });
    });

    $(document).ready(function() {
        $("#id_kota").change(function() {
            var provid = $("#id_kota").val();
            var id_kotaku = $("#area").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(provid){
                $.ajax({
                    type: 'GET',
                    url: '/area/' + provid,
                    dataType: 'json',
                    success: function(data) {
                        $("#area").empty();
                        $("#area").append("<option value=''>Pilih Area</option>");
                        for (let i = 0; i < data.length; i++) {
                            $("#area").append("<option value=" + data[i].area_code + ">" + data[i].name + "</option>");
                        }
                        $("#config-table").DataTable().destroy();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: '/getindexKiosByKota/' + provid,
                    dataType: 'json',
                    success: function(data) {
                        //console.log(data)
                        $("#config-table").DataTable().destroy();
                        var table=$('#config-table').DataTable({
                            processing: true,
                            serverSide: true,
                            "ajax": "/getindexKiosByKota/"+provid,
                            columnDefs: [{
                                targets: [0, 1, 2],
                                className: 'mdl-data-table__cell--non-numeric'
                            }],
                            columns: [
                            {data: 'nama_Kios', name: 'nama_Kios'},
                            {data: 'nama_pic', name: 'nama_pic'},
                            {data: 'alamat_kios', name: 'alamat_kios'},
                            {data: 'email', name: 'email'},
                            {data: 'nomor_hp_pic', name: 'Nomor_Hp'},
                            {data: 'status', name: 'status'},
                            {data: 'action', name: 'action'},
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
                            "ajax": "/getkios",
                            columnDefs: [{
                                targets: [0, 1, 2],
                                className: 'mdl-data-table__cell--non-numeric'
                            }],
                            columns: [
                            {data: 'nama_Kios', name: 'nama_Kios'},
                            {data: 'nama_pic', name: 'nama_pic'},
                            {data: 'alamat_kios', name: 'alamat_kios'},
                            {data: 'email', name: 'email'},
                            {data: 'nomor_hp_pic', name: 'Nomor_Hp'},
                            {data: 'status', name: 'status'},
                            {data: 'action', name: 'action'},
                            ],
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });
        //ajax untuk kota
        //ajax area
        $("#area").change(function() {
            var provid = $("#id_kota").val();
            var id_kotaku = $("#area").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(id_kotaku){
                $.ajax({
                    type: 'GET',
                    url: '/getindexKiosBy/' + id_kotaku,
                    dataType: 'json',
                    success: function(data) {
                        //console.log(data)
                        $("#config-table").DataTable().destroy();
                        var table=$('#config-table').DataTable({
                            processing: true,
                            serverSide: true,
                            "ajax": '/getindexKiosBy/' + id_kotaku,
                            columnDefs: [{
                                targets: [0, 1, 2],
                                className: 'mdl-data-table__cell--non-numeric'
                            }],
                            columns: [
                            {data: 'nama_Kios', name: 'nama_Kios'},
                            {data: 'nama_pic', name: 'nama_pic'},
                            {data: 'alamat_kios', name: 'alamat_kios'},
                            {data: 'email', name: 'email'},
                            {data: 'nomor_hp_pic', name: 'Nomor_Hp'},
                            {data: 'status', name: 'status'},
                            {data: 'action', name: 'action'},
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
                    url: '/getindexKiosByKota/' + provid,
                    dataType: 'json',
                    success: function(data) {
                        //console.log(data)
                        $("#config-table").DataTable().destroy();
                        var table=$('#config-table').DataTable({
                            processing: true,
                            serverSide: true,
                            "ajax": "/getindexKiosByKota/" + provid,
                            columnDefs: [{
                                targets: [0, 1, 2],
                                className: 'mdl-data-table__cell--non-numeric'
                            }],
                            columns: [
                            {data: 'nama_Kios', name: 'nama_Kios'},
                            {data: 'nama_pic', name: 'nama_pic'},
                            {data: 'alamat_kios', name: 'alamat_kios'},
                            {data: 'email', name: 'email'},
                            {data: 'nomor_hp_pic', name: 'Nomor_Hp'},
                            {data: 'status', name: 'status'},
                            {data: 'action', name: 'action'},
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
