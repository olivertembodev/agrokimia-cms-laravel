@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Report Kios</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Report</li>
                    <li class="breadcrumb-item active">Report Kios</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                   <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Pilih Kios</label>
                                <select name="id_kios" id="id_kios" class="form-control select2">
                                    <option value="">Pilih Kios</option>
                                    @foreach ($data as $item)
                                    <option value="{{$item->id}}">{{$item->nama_Kios}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label">Start Date</label>
                                    <div class="controls">
                                        <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">End Date</label>
                                    <div class="controls">
                                        <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="controls">
                                        <button style="margin-top: 30px;" type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                    </div>   
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Pilih Tanggal</label>
                                    <select class="form-control select2" name="id" id="area">
                                        <option value=''>Pilih Tanggal</option>
                                    </select>
                                </div>
                            </div> -->
                </div>
                <div class="table-responsive m-t-40">
                    <table id="config-table" class="table display table-bordered table-striped no-wrap mdl-data-table dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kios</th>
                                <th>Nama Produk</th>
                                <th>Harga Jual</th>
                                <th>Harga Beli</th>
                                <th>Profit</th>
                                <!-- <th>Nominal</th> -->
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
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Expired">Expired</option>
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
<script src="{{URL::asset('assets')}}/node_modules/datatablecetak/dataTables.buttons.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatablecetak/buttons.flash.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatablecetak/jszip.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatablecetak/pdfmake.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatablecetak/vfs_fonts.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatablecetak/buttons.html5.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatablecetak/buttons.print.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatablecetak/moment.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatablecetak/date.min.js"></script>

<script>

    $(document).ready(function() {
       
        var i=0;
        var table=$('#config-table').DataTable({
            dom: "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                { extend: 'excel', className: 'btn btn-primary' },
                { extend: 'pdf', className: 'btn btn-primary' }
            ],
            processing: true,
            serverSide: true,
            ajax: {
              url: "{{ url('listreport') }}",
              type: 'GET',
              data: function (d) {
              d.start_date = $('#start_date').val();
              d.end_date = $('#end_date').val();
              }
            },
            columns: [
            { 
                "data": null,"sortable": false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'nama_Kios', name: 'nama_Kios'},
            {data: 'nama_product', name: 'nama_product'},
            {data: 'harga_jual', name: 'harga_jual', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
            {data: 'harga_beli', name: 'harga_beli', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
            {data: 'profit', name: 'profit', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
            // {data: 'nominal', name: 'nominal', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
            ],
        });
    });

    $('#btnFiterSubmitSearch').click(function(){
     $('#config-table').DataTable().draw(true);
  });


    $(document).ready(function() {
        $("#id_kios").change(function() {
            var provid = $("#id_kios").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(provid){
                $.ajax({
                    type: 'GET',
                    url: '/listreport-bynamakios/' + provid,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $("#config-table").DataTable().destroy();
                        var table=$('#config-table').DataTable({
                            dom: "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>>" +
                              "<'row'<'col-sm-12'tr>>" +
                              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                            buttons: [
                                { extend: 'excel', className: 'btn btn-primary btn-xs mb-3' },
                                { extend: 'pdf', className: 'btn btn-primary btn-xs mb-3' }
                            ],
                            processing: true,
                            serverSide: true,
                            "ajax": "/listreport-bynamakios/"+provid,
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
                            {data: 'harga_jual', name: 'harga_jual', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
                            {data: 'harga_beli', name: 'harga_beli', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
                            {data: 'profit', name: 'profit', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
                            // {data: 'nominal', name: 'nominal', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
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
                var table=$('#config-table').DataTable({
                    dom: "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>>" +
                      "<'row'<'col-sm-12'tr>>" +
                      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                    buttons: [
                        { extend: 'excel', className: 'btn btn-primary btn-xs mb-3' },
                        { extend: 'pdf', className: 'btn btn-primary btn-xs mb-3' }
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: {
                      url: "{{ url('listreport') }}",
                      type: 'GET',
                      data: function (d) {
                      d.start_date = $('#start_date').val();
                      d.end_date = $('#end_date').val();
                      }
                    },
                    columns: [
                    { 
                        "data": null,"sortable": false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'nama_Kios', name: 'nama_Kios'},
                    {data: 'nama_product', name: 'nama_product'},
                    {data: 'harga_jual', name: 'harga_jual', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
                    {data: 'harga_beli', name: 'harga_beli', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
                    {data: 'profit', name: 'profit', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
                    // {data: 'nominal', name: 'nominal', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
                    ],
                });
                
            }
        });
        //ajax untuk kota

    });

    // $(document).ready(function() {
    //     $("#id").change(function() {
    //         var provid = $("#id").val();
    //         // var id_kotaku = $("#area").val();
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //         if(provid){
    //             $.ajax({
    //                 type: 'GET',
    //                 url: '/listreport-bytgl/' + provid,
    //                 dataType: 'json',
    //                 success: function(data) {
    //                     console.log(data)
    //                     $("#config-table").DataTable().destroy();
    //                     var table=$('#config-table').DataTable({
    //                         dom: 'Bfrtip',
    //                         buttons: [
    //                         'excel', 'pdf'
    //                         ],
    //                         processing: true,
    //                         serverSide: true,
    //                         "ajax": "/listreport-bytgl/"+provid,
    //                         columnDefs: [{
    //                             targets: [0, 1, 2],
    //                             className: 'mdl-data-table__cell--non-numeric'
    //                         }],
    //                         columns: [
    //                         { 
    //                             "data": null,"sortable": false,
    //                             render: function (data, type, row, meta) {
    //                                 return meta.row + meta.settings._iDisplayStart + 1;
    //                             }
    //                         },
    //                         {data: 'nama_Kios', name: 'nama_Kios'},
    //                         {data: 'nama_product', name: 'nama_product'},
    //                         {data: 'profit', name: 'profit'},
    //                         {data: 'nominal', name: 'nominal'},
    //                         {data: 'tanggal', name: 'tanggal'},
    //                         ],
    //                     });
    //                 },
    //                 error: function(data) {
    //                     console.log(data);
    //                 }
    //             });
    //         }
    //         else{
    //            $("#config-table").DataTable().destroy();
    //             var table=$('#config-table').DataTable({
    //                 dom: 'Bfrtip',
    //                 buttons: [
    //                 'excel', 'pdf'
    //                 ],
    //                 processing: true,
    //                 serverSide: true,
    //                 "ajax": "{{ route('listreport') }}",
    //                 columns: [
    //                 { 
    //                     "data": null,"sortable": false,
    //                     render: function (data, type, row, meta) {
    //                         return meta.row + meta.settings._iDisplayStart + 1;
    //                     }
    //                 },
    //                 {data: 'nama_Kios', name: 'nama_Kios'},
    //                 {data: 'nama_product', name: 'nama_product'},
    //                 {data: 'profit', name: 'profit'},
    //                 {data: 'nominal', name: 'nominal'},
    //                 {data: 'tanggal', name: 'tanggal'},
    //                 ],
    //             });
    //         }
    //     });
    //     //ajax untuk kota

    // });
</script>
@endsection
