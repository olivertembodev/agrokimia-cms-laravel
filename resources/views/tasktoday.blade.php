@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Tugas Hari Ini</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                <a href="{{route('departement')}}"><li class="breadcrumb-item"><a href="{{ route('tugashariini') }}">Tugas Hari Ini</a></li></a>
                    <li class="breadcrumb-item active">List Tugas Hari Ini</li>
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
                                    <th>Nomor</th>
                                    <th>Nama Tugas</th>
                                    <th>Kota Tugas</th>
                                    <th>Area Tugas</th>
                                    <th>Nama Kios</th>
                                    <th>Tanggal Tugas</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($data as $mp)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{$mp->nama_departement }}</td>
                                        <td>{{$mp->kode_departement}}</td>
                                        <td>{{$mp->deskripsi}}</td>
                                        <td>
                                            <a href="{{route('editdepartement', $mp->id)}}"><button class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></button></a>
                                            <button class="btn btn-xs btn-danger delete-button" deletevalue="{{$mp->id}}" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
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

{{-- modal delete monggo disesuaikan --}}
<div class="modal fade" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Tracking Sales</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div id="map">

                </div>
            </div>
            <div class="modal-footer">
                <p style="text-align: center;">Marker Akan Ter-update selama 5 menit sekali</p>
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
<script async defer
    src="/https://maps.googleapis.com/maps/api/js?key=AIzaSyAvTkPKa1jErT_Kh9ZPTIP2az48f8y0WGo
    &callback=initMap">
</script>

<script>
    function initMap() {
        var myLatLng = {lat: -25.363, lng: 131.044};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Hello World!'
        });
      }
    $(document).ready(function() {
        var i=0;
        var table=$('#config-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('indextugashariini') }}",
            columns: [
            {
            "data": null,"sortable": false,
            render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'nama_tugas', name: 'nama_sales'},
            {data: 'id_kota', name: 'id_kota'},
            {data: 'id_area', name: 'id_area'},
            {data: 'id_kios', name: 'id_kios'},
            {data: 'date', name: 'date'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    });
</script>
@endsection
