@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Reward Kios</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                <a href="{{route('list-kios')}}"><li class="breadcrumb-item"><a href="{{ route('list-kios') }}">Reward</a></li></a>
                    <li class="breadcrumb-item active">List Reward Kios</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap mdl-data-table dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto Kios</th>
                                    <th>Nama Kios</th>
                                    <th>Alamat Kios</th>
                                    <th>Jumlah Reward</th>
                                    <th>Detail Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($kios as $ks)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{$ks->image_kios_depan }}</td>
                                        <td>{{$ks->nama_Kios}}</td>
                                        <td>{{$ks->alamat_kios}}</td>
                                        <td>{{$ks->reward_poin }}</td>
                                        <td>
                                            <a href="{{route('editKios', $ks->id)}}"><button class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></button></a>
                                            <button class="btn btn-xs btn-danger delete-button" deletevalue="{{$ks->id}}" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
                                            <button class="btn btn-xs btn-success status-button" deletevalue="{{$ks->id}}" type="button"><span class="btn-label"><i class="fa fa-undo"></i></span></button>
                                            <a href="{{ route('detailkios', $ks->id) }}" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>
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
            $.post('/deletekios/' + id).then()
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
            "ajax": "{{ route('getkiosreward') }}",
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

            {
                "data": 'image_kios_depan', name: 'image_kios_depan',
                "render": function (data) {
                           return '<img src="' +data+ '" width="100px" height="100px" />';
                       }
            },
            {data: 'nama_Kios', name: 'nama_Kios'},
            {data: 'alamat_kios', name: 'alamat_kios'},
            {data: 'total_reward', name: 'total_reward'},
            {data: 'action', name: 'action'},
            ],
        });
    });
</script>
@endsection
