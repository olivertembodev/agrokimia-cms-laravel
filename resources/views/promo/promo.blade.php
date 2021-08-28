@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Promotion</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                <a href="{{route('list-promo')}}"><li class="breadcrumb-item"><a href="{{ route('list-promo') }}">Sales</a></li></a>
                    <li class="breadcrumb-item active">Promotion</li>
                </ol>
            <a href="{{route('add-promo')}}">
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Tambah Promo</button>
            </a>
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
                                    <th>Nama Kupon</th>
                                    <th>Mulai Dari</th>
                                    <th>Berakhir Dari</th>
                                    <th>Potongan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($promo as $data)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{$data->nama_kupon }}</td>
                                        <td>{{$data->start_date}}</td>
                                        <td>{{$data->end_date}}</td>
                                        <td>{{$data->potongan}}</td>
                                        <td>
                                            <a href="{{route('edit-promo', $data->id)}}"><button class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></button></a>
                                            <button class="btn btn-xs btn-danger delete-button" deletevalue="{{$data->id}}" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
                                            <a href="{{ route('show-promo', $data->id) }}" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>
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
                <h4 class="modal-title" id="vcenter">Hapus Promo</h4>
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
            $.post('/promo/delete/' + id).then()
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
            "ajax": "{{ route('getindexPromo') }}",
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
            {data: 'nama_kupon', name: 'nama_kupon'},
            {data: 'start_date', name: 'start_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'c_potongan', name: 'c_potongan'},
            {data: 'action', name: 'action'},
            ],
        });
    });
</script>
@endsection
