@extends('layouts._layout')
@section('asset')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('style')
<style>
    .thumbnail{

    height: 100px;
    margin: 10px; 
    float: left;
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
            <h4 class="text-themecolor"><b>Riwayat Stok</b></h4>
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="riwayat-table" class="table display table-bordered table-striped no-wrap mdl-data-table dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Tanggal</th>
                                    <th>Status Stok</th>
                                    <th>Stok</th>
                                    <th>Status Transaksi</th>
                                    <th>Dibuat Oleh</th>
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
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="ModalDetail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="riwayat-detail" class="table display table-bordered table-striped no-wrap mdl-data-table dataTable">
                    <thead>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
$('#ModalDetail').on('show.bs.modal', function(e) {
    var modal_data = $(e.relatedTarget).data();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'GET',
        url: '/detail-riwayat-stok/' + modal_data.recordId,
        dataType: 'json',
        success: function(data) {
            console.log({data})
            $("#riwayat-detail tbody").empty()
            $("#riwayat-detail tbody").append('<tr><th>Nama Produk</th><th>' + data.products.nama_product + '</th></tr><tr><th>Status Transaksi</th><th>' + data.transaksis.nama_status + '</th></tr>');
        },
        error: function(data) {
            console.log(data);
        }
    });
});

$('#delete-modal').on('click', '.btn-ok', function(e) {
    var $modalDiv = $(e.delegateTarget);
    var id = $(this).data('recordId');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post('/delete-product/' + id).then()
    $modalDiv.addClass('loading');
    setTimeout(function() {
        $modalDiv.modal('hide').removeClass('loading');
        $('#config-table').DataTable().ajax.reload();
    })
});

$(document).ready(function() {
    $('#exp_date').hide();
    $('#labelexp').hide();
    $("#cb_expdate").change(function() {
        if ($(this).is(':checked')) {
            $('#exp_date').show();
            $('#labelexp').show();
        } else {
            $('#exp_date').hide();
            $('#labelexp').hide();
        }
    });
});

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var t = $('#riwayat-table').DataTable({
        "processing": true,
        "serverSide": true,
        "destroy": true,
        "ajax": {
            "url": "{{ route('data-riwayat-stok') }}",
            "type": "GET",
        },
        "columns": [{
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { "data": "produk" },
            { "data": "date" },
            { "data": "status" },
            { "data": "stokn" },
            { "data": "status_transaksi" },
            { "data": "created" },

        ],

    });
});

</script>
@endsection
