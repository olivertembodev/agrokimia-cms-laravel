@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Cicilan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                <a href="{{route('list-cicilan')}}"><li class="breadcrumb-item"><a href="{{ route('list-cicilan') }}">Cicilan</a></li></a>
                    <li class="breadcrumb-item active">List Cicilan</li>
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
                                    <th>Tanggal Transaksi</th>
                                    <th>Nama Kios</th>
                                    <th>Total</th>
                                    <th>Status Lunas</th>
                                    <th>Approval</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- model hapus --}}

<div id="status-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-dialog modal-dialog-centered">
        {{-- <form id="update-form" action="{{route('updatestatusCicilan',$status->id)}}" method="POST">@csrf --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Konfirmasi Approval</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                    <h5 class="modal-title" id="vcenter">Anda yakin akan melakukan approval?</h5>
                        <input type="hidden" name="aproved_at" id="aproved_at" value="<?php echo date("Y-m-d H:i:s");?>">
                        <!-- <select name="status" id="status" class="form-control">
                            <option value="1">Aprroved</option>
                            <option value="0">Not Approved</option>
                        </select> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info btn-danger waves-effect btn-yes">Approve</button>
                </div>
            </div>
        {{-- </form> --}}
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
            var loans_id = $(this).data('recordId');
            var aproved_at = $('#aproved_at').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/updatestatusCicilan',
                type: 'POST',
                dataType: 'json',
                data: {
                    "id":loans_id,
                    "aproved_at":aproved_at,
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
        var i=0;
        var table=$('#config-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('getindexCicilan') }}",
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
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
            {data: 'total', name: 'total', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
            {data: 'status_lunas', name: 'status_lunas'},
            {data: 'approval', name: 'approval'},
            {data: 'action', name: 'action'},
            ],
        });
    });
</script>
@endsection
