@extends('layouts._layout')
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
            <h4 class="text-themecolor">List Product</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Product</a></li>
                    <li class="breadcrumb-item active">List Product</li>
                </ol>
                <a href="{{route('add-product')}}"><button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Product</button></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap mdl-data-table">
                            <thead>
                                <tr class="text-center">
                                    <!-- <th>No</th> -->
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Nama Principle</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Harga Jual</th>
                                    <th class="text-center">Harga Beli</th>
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
<!-- Modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Hapus Product</h4>
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
$('#delete-modal').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    $('.title', this).text(data.recordTitle);
    $('.btn-ok', this).data('recordId', data.recordId);
});

$('#delete-modal').on('click', '.btn-ok', function(e) {
    var $modalDiv = $(e.delegateTarget);
    var id = $(this).data('recordId');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post('/product/delete/' + id).then()
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
    var i = 0;
    var table = $('#config-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('list-product-data') }}",
        columnDefs: [
            { targets: [0, 1, 2], className: 'mdl-data-table__cell--non-numeric' },
            { targets: [3], className: 'text-right' },
            { targets: [4,5], className: 'text-left' }
        ],
        columns: [

            {
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'nama_product', name: 'nama_product' },
            { data: 'principles.nama_principle', name: 'nama_principle' },
            { data: 'stok', name: 'stok' },
            { data: 'c_harga_jual', name: 'c_harga_jual' },
            { data: 'c_harga_beli', name: 'c_harga_beli' },
            { data: 'action', name: 'action' },
        ],
    });
});

</script>
@endsection
