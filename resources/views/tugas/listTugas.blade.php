@extends('layouts._layout')
@section('style')
<style>
    html {
  scroll-behavior: smooth;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Tugas</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tugas</a></li>
                    <li class="breadcrumb-item active">List Tugas</li>
                </ol>
                <a href="{{ route('add-tugas')}}">
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Tugas</button>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filter</h4>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control select2 col-md-4" name="city_code" style="width:100%;" id="select_city">
                                        <option value=''>Pilih Kota</option>
                                        @foreach ($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control select2 col-md-4" name="area" style="width:100%;" id="select_area">
                                        <option value=''>Pilih Area</option>
                                        @foreach ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control select2 col-md-4" name="sales" style="width:100%;" id="select_sales">
                                        <option value=''>Pilih Sales</option>
                                        @foreach ($saleses as $sales)
                                        <option value="{{$sales->id}}">{{$sales->nama_sales}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' name="fromdate" id="fromdate" placeholder="from Date" class="form-control" value="{{ old('fromdate') }}" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text' name="todate" id="todate" placeholder="to Date" class="form-control" value="{{ old('todate') }}" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control select2 col-md-4" name="statustrans" style="width:100%;" id="statustugas">
                                        <option value=''>Pilih Status Tugas</option>
                                        <option value="0">Belum Terealisasi</option>
                                        <option value="1">Sedang Dalam Perjalanan</option>
                                        <option value="2">Perjalanan Selesai</option>
                                        <option value="3">Tugas Selesai</option>
                                        <option value="4">Dibatalkan Admin</option>
                                        <option value="5">Dibatalkan Sales</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button style="width:80%;padding:5px;" class="btn btn-success mt-3" id="btn_filter"><span>FILTER</span> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Task</h4>
                    <div class="table-responsive m-t-40">
                        <table id="alltugas-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tugas</th>
                                    <th>Kota Tugas</th>
                                    <th>Area Tugas</th>
                                    <th>Nama Kios</th>
                                    <th>Nama Sales</th>
                                    <th>Tanggal Tugas</th>
                                    <th>Status Tugas</th>
                                    <th>Change Status Tugas</th>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Today Task</h4>
                    <div class="table-responsive m-t-40">
                        <table id="today-task-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tugas</th>
                                    <th>Kota Tugas</th>
                                    <th>Area Tugas</th>
                                    <th>Nama Kios</th>
                                    <th>Nama Sales</th>
                                    <th>Tanggal Tugas</th>
                                    <th>Status Tugas</th>
                                    <th>Change Status Tugas</th>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Unsigned Task</h4>
                    <div class="table-responsive m-t-40">
                        <table id="unsigned-task-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tugas</th>
                                    <th>Kota Tugas</th>
                                    <th>Area Tugas</th>
                                    <th>Nama Kios</th>
                                    <th>Nama Sales</th>
                                    <th>Tanggal Tugas</th>
                                    <th>Approval</th>
                                    <th>Status Tugas</th>
                                    <th>Change Status Tugas</th>
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
{{-- modal status jangan diusik --}}
<div class="modal fade" id="confirm-status" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="update-form" action="" method="get">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Ubah Status Tugas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Status Tugas</label>
                        <select name="no_status" id="status" class="form-control">
                            <option value="0">Belum Terealisasi</option>
                            <option value="1">Sedang Dalam Perjalanan</option>
                            <option value="2">Perjalanan Selesai</option>
                            <option value="3">Tugas Selesai</option>
                            <option value="4">Dibatalkan Admin</option>
                            <option value="5">Dibatalkan Sales</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info btn-danger waves-effect btn-ok">Save</button>
                </div>
            </div>
        </form>
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
                <h4 class="modal-title" id="vcenter">Hapus Tugas</h4>
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
{{-- is approved --}}
<div class="modal fade" id="confirm-approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Approve Tugas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin Mengapprove data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-ok">Approve</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- This is data table -->
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/moment/moment.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>
<script>
var ListTugas = function() {
    var DatatableAll = function(param = {}) {
        let city = (param.city) ? param.city : null;
        let area = (param.area) ? param.area : null;
        let sales = (param.sales) ? param.sales : null;
        let datefrom = (param.datefrom) ? param.datefrom : null;
        let dateto = (param.dateto) ? param.dateto : null;
        let statustugas = (param.statustugas) ? param.statustugas : null;

        // var city = city === undefined ? null : opts.city;
        // var areas = .areas === undefined ? null : opts.areas;
        var all_table = $('#alltugas-table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            "ajax": {
                "url": "{{ url('/tugas/get-tugas-alls') }}",
                "dataType": "json",
                "type": "POST",
                "data": { _token: "{{csrf_token()}}", 'city': city, 'area': area, 'sales': sales, 'datefrom': datefrom, 'dateto': dateto, 'statustugas': statustugas }
            },
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'nama_tugas', name: 'nama_tugas' },
                { data: 'nama_kota', name: 'nama_kota' },
                { data: 'nama_area', name: 'nama_area' },
                { data: 'nama_kios', name: 'nama_kios' },
                { data: 'nama_sales', name: 'nama_sales' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'status', name: 'status' },
                { data: 'statusbutton', name: 'statusbutton' },
                { data: 'action', name: 'action' },
            ],
        });
        return all_table;

    };

    var DatatableToday = function() {
        var today_table = $('#today-task-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('list-tugas-today') }}",
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'nama_tugas', name: 'nama_tugas' },
                { data: 'nama_kota', name: 'nama_kota' },
                { data: 'nama_area', name: 'nama_area' },
                { data: 'nama_kios', name: 'nama_kios' },
                { data: 'nama_sales', name: 'nama_sales' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'status', name: 'status' },
                { data: 'statusbutton', name: 'statusbutton' },
                { data: 'action', name: 'action' },
            ],
        });
    }

    var DataTableUnsigned = function() {
        var unsigned_table = $('#unsigned-task-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('list-tugas-unsigned') }}",
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'nama_tugas', name: 'nama_tugas' },
                { data: 'nama_kota', name: 'nama_kota' },
                { data: 'nama_area', name: 'nama_area' },
                { data: 'nama_kios', name: 'nama_kios' },
                { data: 'nama_sales', name: 'nama_sales' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'approval', name: 'approval' },
                { data: 'status', name: 'status' },
                { data: 'statusbutton', name: 'statusbutton' },
                { data: 'action', name: 'action' },
            ],
        });
    }

    var FilterCity = function() {
        $("#select_city").change(function() {
            let KOTAs = $("#select_city").val();
            let AREAs = $("#select_area").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (KOTAs != null) {
                let p = { city: KOTAs, area: AREAs }
                DatatableAll().destroy();
                DatatableAll(p);
            }
        });
    }

    var FilterButtonClicked = function() {
        $('#btn_filter').on('click', function(e) {
            let KOTAs = $("#select_city").val();
            let AREAs = $("#select_area").val();
            let SALESs = $("#select_sales").val();
            let FROMDATE = $("#fromdate").val();
            let Todates = $("#todate").val();
            let StatusTugas = $("#statustugas").val();
            // alert(`${KOTAs}${AREAs}${SALESs}${FROMDATE}${Todates}${StatusTugas}`)
            let param = {
                city: KOTAs,
                area: AREAs,
                sales: SALESs,
                datefrom: FROMDATE,
                dateto: Todates,
                statustugas: parseInt(StatusTugas)
            }

            DatatableAll().destroy();
            DatatableAll(param);

        });
    }
    var OthersFunction = function() {


        $('#confirm-approve').on('click', '.btn-ok', function(e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //$.ajax({url: '/deletekios/' + id, type: 'POST'})
            $.post('/tugas/changestatusapprove/' + id).then()
            $modalDiv.addClass('loading');
            setTimeout(function() {
                $modalDiv.modal('hide').removeClass('loading');
                $('#alltugas-table').DataTable().ajax.reload();
                $('#today-task-table').DataTable().ajax.reload();
                $('#unsigned-task-table').DataTable().ajax.reload();

                $.get("{{ route('unsigned-task-count')}}", function(data, status) {
                    console.log(data.count)
                    console.log(data.list)
                    if (data.count < 1) {
                        $('#notify').hide()
                        $('#mailbox').empty()
                        var a = '<ul><li><div class="drop-title">Tidak ada notifikasi terbaru</div></li></ul>'
                        $('#mailbox').append(a)
                    } else {
                        $('#task_count').html(data.count)
                        $('#message-center').empty()
                        $.each(data.list, function(key, value) {
                            var a = '<a href="/tugas/list-tugas/1"><div class="btn btn-success btn-circle"><i class="ti-bell"></i></div><div class="mail-contnet"><h6 style="color:black;">' + value.tipe_tasks.nama_kode + ' Pada Kios ' + value.kioss.nama_Kios + '</h6> <span class="mail-desc">Nama Sales : ' + value.saless.nama_sales + '</span> <span class="time">' + value.date + '</span></div></a>'
                            $('#message-center').append(a)
                        });
                        if (data.count < 6) {
                            $('#lainnya').hide()
                        }
                    }
                });
            })
        });
        $('#confirm-approve').on('show.bs.modal', function(e) {
            var data = $(e.relatedTarget).data();
            $('.title', this).text(data.recordTitle);
            $('.btn-ok', this).data('recordId', data.recordId);
        });
        $('#confirm-delete').on('click', '.btn-ok', function(e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //$.ajax({url: '/deletekios/' + id, type: 'POST'})
            $.post('/tugas/delete/' + id).then()
            $modalDiv.addClass('loading');
            setTimeout(function() {
                $modalDiv.modal('hide').removeClass('loading');
                $('#alltugas-table').DataTable().ajax.reload();
                $('#today-task-table').DataTable().ajax.reload();
                $('#unsigned-task-table').DataTable().ajax.reload();
            })
        });
        $('#confirm-delete').on('show.bs.modal', function(e) {
            var data = $(e.relatedTarget).data();
            $('.title', this).text(data.recordTitle);
            $('.btn-ok', this).data('recordId', data.recordId);
        });

        $('#confirm-status').on('click', '.btn-ok', function(e) {
            e.preventDefault();
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            var nostatus = $("#status").val();
            // alert(nostatus);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //$.ajax({url: '/deletekios/' + id, type: 'POST'})
            $.post('/tugas/changestatus/' + id + '/' + nostatus).then()

            $modalDiv.addClass('loading');
            setTimeout(function() {
                $modalDiv.modal('hide').removeClass('loading');
                $('#alltugas-table').DataTable().ajax.reload();
                $('#today-task-table').DataTable().ajax.reload();
                $('#unsigned-task-table').DataTable().ajax.reload();
            })
        });
        $('#confirm-status').on('show.bs.modal', function(e) {
            var data = $(e.relatedTarget).data();
            $('.title', this).text(data.recordTitle);
            $('.btn-ok', this).data('recordId', data.recordId);
        });


    }
    return {
        init: function() {
            DatatableAll();
            OthersFunction();
            // FilterCity();
            FilterButtonClicked();
            DatatableToday();
            DataTableUnsigned();
        }
    }
}();

$(document).ready(function() {
    ListTugas.init();

    $('.select2').select2();
    $(function() {
        $('#datetimepicker1').datepicker({
            format: "mm/dd/yyyy",
            autoclose: true
        });
        $('#datetimepicker2').datepicker({
            format: "mm/dd/yyyy",
            autoclose: true
        });
    });
    a = "{{ request()->unsigned_task }}"
    if (a) {
        $('html, body').animate({
            scrollTop: $("#unsigned-task-table").offset().top
        }, 1000);
    }
})

</script>
@endsection
