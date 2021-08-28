@extends('layouts._layout')
@section('content')
<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Logs Admin</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap mdl-data-table dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Admin</th>
                                    <th>Nama Principle</th>
                                    <th>Deskripsi Aktifitas</th>
                                    <th>Modul</th>
                                    <th>Tanggal</th>
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
@endsection
@section('script')
<!-- This is data table -->
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
<script>

$(document).ready(function() {
    var i = 0;
    var table = $('#config-table').DataTable({
        processing: true,
        serverSide: true,
        "ajax": "{{ route('logs-admin-data') }}",
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
            { data: 'admin' },
            { data: 'principle' },
            { data: 'aktifitass.nama_aktifitas' },
            { data: 'modul' },
            { data: 'date' },
        ],
    });
});

</script>
@endsection
