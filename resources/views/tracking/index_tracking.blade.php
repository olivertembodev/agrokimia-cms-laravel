@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tracking</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tracking</a></li>
                    <li class="breadcrumb-item active">Index Tracking</li>
                </ol>
               
            </div>
        </div>
    </div>
    
  
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tugas Hari Ini</h4>
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
                                    <th>Change Status</th>
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
    <div class="row" id="mapBoard">
        <div class="card" style="width: 100%">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="card-header">
                        <h4>Map</h4>
                      </div>
                        <div id="map" style="width: 100%; height: 375px;"></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-tracking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Track Tugas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Click 'Confirm' to track this data!</p>
                <p class="text-success">Map ada dibawah Tabel.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info btn-ok">Confirm</button>
            </div>
        </div>
    </div>
</div>
{{-- akhir modal delete --}}
{{-- modal status jangan diusik --}}
<div  class="modal fade" id="confirm-status" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
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

@endsection

@section('script')
    <!-- This is data table -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvTkPKa1jErT_Kh9ZPTIP2az48f8y0WGo&callback=initMap"></script>
    <script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/moment/moment.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>
   

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-database.js"></script>


    <script>
        var ListTugas = function(){
            var LatLong = {
                latitude:"",
                longitude:"",
                printIntroduction: function () {
                    console.log(`My name is ${this.latitude}. Am I human? ${this.longitude}`);
                }
                };
         
            var DatatableToday = function(){
                var today_table= $('#today-task-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": "{{ route('list-tugas-today') }}",
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
                    {data: 'nama_tugas', name: 'nama_tugas'},
                    {data: 'nama_kota', name: 'nama_kota'},
                    {data: 'nama_area', name: 'nama_area'},
                    {data: 'nama_kios', name: 'nama_kios'},
                    {data: 'nama_sales', name: 'nama_sales'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'status', name: 'status'},
                    {data: 'statusbutton', name: 'statusbutton'},
                    {data: 'tracking', name: 'tracking'},
                    ],
                });
            }
            var initDB = function(){
                var firebaseConfig = {
                                apiKey: '{{ env('API_KEY_FIREBASE') }}',
                                authDomain: "fir-tracking-5b368.firebaseapp.com",
                                databaseURL: "https://fir-tracking-5b368.firebaseio.com",
                                projectId: "fir-tracking-5b368",
                                storageBucket: "fir-tracking-5b368.appspot.com",
                                messagingSenderId: "523761130715",
                                appId: '{{ env('APP_ID_FIREBASE') }}',
                                measurementId: "G-H87LHRFB4T"
                            };
                            // Initialize Firebase
                firebase.initializeApp(firebaseConfig);
                firebase.analytics();
            }
            var dbFire = function(id_share_loc){
                
                // Initialize Firebase
                var database = firebase.database();
                //var leadsRef = database.ref('tracking/');
                var ref= database.ref('tracking/'+id_share_loc);
                ref.on("value", function(snapshot) {
                    //console.log(snapshot.val());
                   // LatLong.push({latitude:snapshot.val().latitude,longitude:snapshot.val().longitude});
                    // $.extend( LatLong[0], {latitude:snapshot.val().latitude,longitude:snapshot.val().longitude});
                    LatLong.latitude = snapshot.val().latitude
                    LatLong.longitude = snapshot.val().longitude
                }, function (error) {
                    console.log("Error: " + error.code);
                });

            }
            var mapTracker = function(idshare){
                dbFire(idshare);
                const me = Object.create(LatLong);
                console.log(me);
                $('#map').show();
                    
                // me.printIntroduction();
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 6,
                    center: new google.maps.LatLng(-7.50166466, 111.257832302),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                setTimeout(function(){
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(me.latitude,me.longitude),
                        map: map,
                        icon: "/assets/images/sales2.png"
                    });

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent("Sales");
                            infowindow.open(map, marker);
                        }
                    })(marker))
                }, 2000)

            }

            var OthersFunction = function(){

                $('#confirm-tracking').on('click', '.btn-ok', function(e) {
                    var $modalDiv = $(e.delegateTarget);
                    var id = $(this).data('recordId');

                   // $.post('/tugas/delete/' + id).then()
                    $modalDiv.addClass('loading');
                    $modalDiv.modal('hide').removeClass('loading');
                       // $('#today-task-table').DataTable().ajax.reload();
                       // run action after confirm button clicked
                    mapTracker(id);

                });
                $('#confirm-tracking').on('show.bs.modal', function(e) {
                    var data = $(e.relatedTarget).data();
                    $('.title', this).text(data.recordTitle);
                    $('.btn-ok', this).data('recordId', data.recordId);
                });

                $('#confirm-status').on('click', '.btn-ok', function(e) {
                    e.preventDefault();
                    var $modalDiv = $(e.delegateTarget);
                    var id = $(this).data('recordId');
                    var nostatus= $("#status").val();
                   // alert(nostatus);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    //$.ajax({url: '/deletekios/' + id, type: 'POST'})
                    $.post('/tugas/changestatus/' + id+'/'+nostatus).then()
                
                    $modalDiv.addClass('loading');
                    setTimeout(function() {
                        $modalDiv.modal('hide').removeClass('loading');
                        $('#today-task-table').DataTable().ajax.reload();
                    })
                });
                $('#confirm-status').on('show.bs.modal', function(e) {
                    var data = $(e.relatedTarget).data();
                    $('.title', this).text(data.recordTitle);
                    $('.btn-ok', this).data('recordId', data.recordId);
                });

            }
            return {
                init:function(){
                    OthersFunction();
                    DatatableToday();
                   // dbFire();
                   //mapTracker();
                   initDB();
                }
            }
        }();
       
        $(document).ready(function() {
            ListTugas.init();
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#map').hide();
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

        })
    </script>
@endsection