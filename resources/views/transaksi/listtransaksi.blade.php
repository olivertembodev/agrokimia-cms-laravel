@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Transaksi</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                <a href="{{route('list-sales')}}"><li class="breadcrumb-item"><a href="{{ route('list-sales') }}">Transaksi</a></li></a>
                    <li class="breadcrumb-item active">List Transaksi</li>
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
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Nama Kios</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Total</th>
                                    <th>Status Transaksi</th>
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

<div id="status-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        {{-- <form id="update-form" action="" method="POST">@csrf --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Update Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            @foreach ($data as $status)
                                <option value="{{$status->id}}">{{$status->nama_status}}</option>
                            @endforeach
                        </select>
                    </div>
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

{{-- model hapus --}}

<div id="delete-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="delete-form" action="" method="post">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Hapus Sales</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info btn-danger waves-effect">Delete</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@section('script')
<!-- This is data table -->
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

<script>

    $('#status-modal').on('click', '.btn-yes', function(e) {
        var $modalDiv = $(e.delegateTarget);
        var id = $(this).data('recordId');
        var status = $('#status').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/updatestatustransaksi',
            type: 'POST',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                "id":id,
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

    $(".delete-button").click(function(){
        var id = $(".delete-button").attr('deletevalue');
        $("#delete-form").attr('action', '../deletesales/'+id);
        $('#delete-modal').modal();
    });

    $(document).ready(function() {
        var i=0;
        var table=$('#config-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('getlist-transaksi') }}",
            columns: [
            {
            "data": null,"sortable": false,
            render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'no_invoice', name: 'no_invoice'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'id_kios', name: 'id_kios'},
            {data: 'id_tipe_pembayaran', name: 'id_tipe_pembayaran'},
            {data: 'c_total', name: 'c_total'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    });
</script>
@endsection
