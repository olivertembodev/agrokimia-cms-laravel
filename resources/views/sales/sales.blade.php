@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Sales</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                <a href="{{route('list-sales')}}"><li class="breadcrumb-item"><a href="{{ route('list-sales') }}">Sales</a></li></a>
                    <li class="breadcrumb-item active">List Sales</li>
                </ol>
            <a href="{{route('add-sales')}}">
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Tambah Sales</button>
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
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sales</th>
                                    <th>Kota</th>
                                    <th>Area</th>
                                    <th>Alamat Sales</th>
                                    <th>NIK</th>
                                    <th>NIP</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    {{-- <th>Foto</th> --}}
                                    <th>Action</th>


                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($data as $sales)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{$sales->nama_sales }}</td>
                                        <td>{{$sales->id_kota}}</td>
                                        <td>{{$sales->id_area}}</td>
                                        <td>{{$sales->alamat_sales}}</td>
                                        <td>{{$sales->nik}}</td>
                                        <td>{{$sales->nip}}</td>
                                        <td>{{$sales->jenis_kelamin}}</td>
                                        <td>{{$sales->email}}</td>
                                        <td>{{$sales->password}}</td>
                                        <td>{{$sales->status}}</td>
                                        <td>{{$sales->token}}</td>
                                        <td>{{$sales->foto}}</td>
                                        <td>
                                            <a href="{{route('editSales', $sales->id)}}"><button class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></button></a>
                                            <button class="btn btn-xs btn-danger delete-button" deletevalue="{{$sales->id}}" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
                                            <a href="{{ route('detailsales', $sales->id) }}" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>
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

{{-- model hapus --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Hapus Sales</h4>
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
            $.post('/deletesales/' + id).then()
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
            "ajax": "{{ route('getlist-sales') }}",
            columns: [
            {
            "data": null,"sortable": false,
            render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'nama_sales', name: 'nama_sales'},
            {data: 'id_kota', name: 'id_kota'},
            {data: 'id_area', name: 'id_area'},
            {data: 'alamat_sales', name: 'alamat_sales'},
            {data: 'nik', name: 'nik'},
            {data: 'nip', name: 'nip'},
            {data: 'jenis_kelamin', name: 'jenis_kelamin'},
            {data: 'email', name: 'email'},
            {data: 'status', name: 'status'},
            //{data: 'foto', name: 'foto'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    });

</script>
@endsection
