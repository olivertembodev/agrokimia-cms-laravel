@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Transaksi Reward</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Reward</a></li>
                    <li class="breadcrumb-item active">List Transaksi Reward</li>
                </ol><!-- 
                <a href="{{ route('add-transaksi-reward')}}">
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                            class="fa fa-plus-circle"></i> Tambah Transaksi Reward</button>
                </a> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                     <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label">Start Date</label>
                                    <div class="controls">
                                        <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">End Date</label>
                                    <div class="controls">
                                        <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Pilih Status</label>
                                        <select name="str" id="str" class="form-control select2">
                                            <option value="">Pilih Status</option>
                                            @foreach ($str as $str)
                                            <option value="{{$str->id}}">{{$str->nama_status}}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                </div>
                                <div class="col-md-2">
                                    <div class="controls">
                                        <button style="margin-top: 30px;" type="text" id="btnFiterSubmitSearch" class="btn btn-info">Filter</button>
                                    </div>   
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kios</th>
                                    <th>Nama Produk</th>
                                    <th>Total Reward</th>
                                    <th>Tanggal</th>
                                    <th>Status Transaksi Reward</th>
                                    <th>Detail Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($reward_transaksi as $rt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$rt->nama_kios}}</td>
                                        <td>{{$rt->nama_product}}</td>
                                        <td>{{$rt->total_reward}}</td>
                                        <td>{{$rt->tanggal}}</td>
                                        <td>{{$rt->status_transaksi_reward}}</td>
                                        <td>{{$rt->detail_transaksi}}</td>
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

<div id="delete-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="delete-form" action="" method="post">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Hapus Reward Product</h4>
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
            ajax: {
              url: "{{ url('gettransaksireward') }}",
              type: 'GET',
              data: function (d) {
              d.start_date = $('#start_date').val();
              d.end_date = $('#end_date').val();
              }
            },
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

            {data: 'nama_Kios', name: 'nama_Kios'},
            {data: 'nama_product', name: 'nama_product'},
            {data: 'total_reward', name: 'total_reward'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'nama_status', name: 'nama_status'},
            {data: 'action', name: 'action'},
            ],
        });
    });
    $('#btnFiterSubmitSearch').click(function(){
        $('#config-table').DataTable().draw(true);
    });

    $(document).ready(function() {
        $("#str").change(function() {
            var provid = $("#str").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(provid){
                $.ajax({
                    type: 'GET',
                    url: '/filter-statustransaksi-reward/' + provid,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $("#config-table").DataTable().destroy();
                        var table=$('#config-table').DataTable({
                            processing: true,
                            serverSide: true,
                            "ajax": "/filter-statustransaksi-reward/" + provid,
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
                            {data: 'nama_Kios', name: 'nama_Kios'},
                            {data: 'nama_product', name: 'nama_product'},
                            {data: 'total_reward', name: 'total_reward', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
                            {data: 'tanggal', name: 'tanggal'},
                            {data: 'nama_status', name: 'nama_status'},
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
               $("#config-table").DataTable().destroy();
                var i=0;
                var table=$('#config-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                      url: "{{ url('gettransaksireward') }}",
                      type: 'GET',
                      data: function (d) {
                      d.start_date = $('#start_date').val();
                      d.end_date = $('#end_date').val();
                      }
                    },
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

                    {data: 'nama_Kios', name: 'nama_Kios'},
                    {data: 'nama_product', name: 'nama_product'},
                    {data: 'total_reward', name: 'total_reward'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'nama_status', name: 'nama_status'},
                    {data: 'action', name: 'action'},
                    ],
                });
                
            }
        });
        //ajax untuk kota

    });

</script>
@endsection
