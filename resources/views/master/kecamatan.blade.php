@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Kecamatan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                    <li class="breadcrumb-item active">Kecamatan</li>
                </ol>
                <button type="button" onclick="location.href='{{ url('/master/kecamatan/add-kecamatan') }}'"class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Tambah Kecamatan</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="kecamatan-table" class="table display table-bordered table-striped no-wrap mdl-data-table dataTable">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama Provinsi</th>
                                    <th>Nama Kota</th>
                                    <th>Kode Kecamatan</th>
                                    <th>Nama Kecamatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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
                    <h4 class="modal-title" id="vcenter">Hapus Kecamatan</h4>
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

    $(document).on('click', '.delete-button', function(){
        var id = $(this).attr('deletevalue');
        $("#delete-form").attr('action', '../master/kecamatan/delete-kecamatan/'+id);
        $('#delete-modal').modal();
    });

    $(document).ready( function() {
        $('#kecamatan-table').DataTable({
            responsive : true,
            processing : true,
            serverSide : true,
            ajax       : "{{ route('get-data-kecamatan') }}",
            columns    : [
                { data : 'DT_RowIndex', orderable : false, searchable: false },
                { data : 'province_name', name : 'province_name' },
                { data : 'city_name', name : 'city_name' },
                { data : 'kecamatan_code', name : 'kecamatan_code' },
                { data : 'name', name : 'name' },
                { data : 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    });

</script>
@endsection
