@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Detail Transaksi Kios</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-kios-reward')}}">Reward Kios</a></li>
                    <li class="breadcrumb-item active">Detail Transaksi Kios</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <label class="control-label" style="font-weight: bold;">Detail Transaksi</label>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Nama Kios</label>
                        <div>{{$data[0]->nama_Kios}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Alamat</label>
                        <div>{{$data[0]->alamat_kios}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Nama PIC</label>
                        <div>{{$data[0]->nama_pic}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Nomor HP PIC</label>
                        <div>{{$data[0]->nomor_hp_pic}}</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <label class="control-label" style="font-weight: bold;">List Transaksi</label>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label">Start Date</label>
                                    <div class="controls">
                                        <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label">End Date</label>
                                    <div class="controls">
                                        <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="controls">
                                        <button style="margin-top: 30px;" type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                    </div>   
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Pilih Status</label>
                                        <select name="status" id="status" class="form-control select2">
                                            <option value="">--Pilih--</option>
                                            @foreach ($total as $status)
                                            <option value="{{$status->id}}">@php
                                                if($status->kode_status==1){
                                                    echo "Pengajuan Reward Dikirimkan";
                                                }   else if($status->kode_status==2){
                                                    echo "Dalam Proses";
                                                }   else if($status->kode_status==3){
                                                    echo "Berhasil";
                                                }   else if($status->kode_status==4){
                                                    echo "Dibatalkan";
                                                }   else {
                                                    echo "Ditolak Admin";
                                                }
                                            @endphp</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Search No Invoice</label>
                                        <input type="input" name="search-invoice" id="invo" class="form-control" placeholder="Search"> <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive m-t-40">
                        <input type="hidden" value="{{$data[0]->id}}" id="id_kios">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap mdl-data-table dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th id="invo">No Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Total Transaksi</th>
                                    <th>Status Reward</th>
                                    <th>Total Reward</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <label class="control-label" style="font-weight: bold;">Total Reward</label>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold; font-size: 20px;">
                            {{$total->sum('total_reward')}}
                        </label>
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
     
        id_kios = $("#id_kios").val()
        var i=0;
        var table=$('#config-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
              url: "/getkiostransaksireward/"+id_kios,
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

            {data: 'no_invoice', name: 'no_invoice'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'total', name: 'total'},
            {data: 'nama_status', name: 'nama_status'},
            {data: 'total_reward', name:'total_reward', 'searchable': false },
            ],
        });
        $('#invo').on( 'keyup', function () {
            table
                .columns( 1 )
                .search( this.value )
                .draw();
        } );
    });
    $('#btnFiterSubmitSearch').click(function(){
        $('#config-table').DataTable().draw(true);
    });

    //status filter

    $(document).ready(function() {
        $("#status").change(function() {
            var provid = $("#status").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(provid){
                $.ajax({
                    type: 'GET',
                    url: '/filter-status/' + provid,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $("#config-table").DataTable().destroy();
                        id_kios = $("#id_kios").val()
                        var i=0;
                        var table=$('#config-table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                              url: "/filter-status/"+ provid,
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

                            {data: 'no_invoice', name: 'no_invoice'},
                            {data: 'tanggal', name: 'tanggal'},
                            {data: 'total', name: 'total'},
                            {data: 'nama_status', name: 'nama_status'},
                            {data: 'total_reward', name:'total_reward'},
                            ],
                        });
                        $('#invo').on( 'keyup', function () {
                            table
                                .columns( 1 )
                                .search( this.value )
                                .draw();
                        } );
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
            else{
               $("#config-table").DataTable().destroy();
                id_kios = $("#id_kios").val()
                var i=0;
                var table=$('#config-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                      url: "/getkiostransaksireward/"+id_kios,
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

                    {data: 'no_invoice', name: 'no_invoice'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'total', name: 'total'},
                    {data: 'nama_status', name: 'nama_status'},
                    {data: 'total_reward', name:'total_reward'},
                    ],
                });
                $('#invo').on( 'keyup', function () {
                            table
                                .columns( 1 )
                                .search( this.value )
                                .draw();
                } );
            }
        });
        //ajax untuk kota

    });

 
    // Apply the search
   

</script>
@endsection
