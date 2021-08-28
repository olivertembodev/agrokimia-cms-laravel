@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Running Text</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                <a href="{{route('running_text')}}"><li class="breadcrumb-item"><a href="{{ route('running_text') }}">Running Text</a></li></a>
                    <li class="breadcrumb-item active">Running text</li>
                </ol>
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
                                    <th>Runnig Text</th>
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

{{-- model hapus --}}
@endsection

@section('script')
<!-- This is data table -->
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

<script>

    $(document).ready(function() {
        var i=0;
        var table=$('#config-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('getRunningText') }}",
            columnDefs: [{
                targets: [0, 1],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            columns: [   
            { 
            "data": null,"sortable": false,
            render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'text', name: 'text'},
            {data: 'action', name: 'action'}
            ],
        });
    });
</script>
@endsection
