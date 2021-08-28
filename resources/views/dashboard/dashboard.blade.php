@extends('layouts._layout')
@section('content')
{{-- <script>
    var mapku,map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
        mapku = new google.maps.Map(document.getElementById('mapku'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
  </script> --}}
@section('asset')
@endsection
{{-- @php
print_r($running_text);
die();
@endphp --}}
<div class="demo-1">
  @if(empty($running_text->text))
    <h3>{!!$running_text['text']!!}</h3>
  @else
    <h3>{!!$running_text->text!!}</h3>
@endif

  </div>

<div class="row" style="margin:1%;">
    <div class="col-sm-6">
      <div class="card-counter " style="background-color: #23afb5;">
        <i class="fa fa-shopping-cart"></i>
        <span class="count-numbers text-light" >{{ $total_kios}}</span>
        <span class="count-name text-light">Total Kios</span>
      </div>
    </div>

    <div class="col-sm-6">
      <div class="card-counter" style="background-color: #23afb5;">
        <i class="fa fa-user-friends"></i>
        <span class="count-numbers text-light">{{ $total_sales}}</span>
        <span class="count-name text-light">Total Sales</span>
      </div>
    </div>
</div>
<div class="row" style="margin:1%;">
    <div class="col-sm-4">
      <div class="card-counter " style="height: 130px; background-color: #23afb5;">
        <i class="fa fa-money-bill-alt"></i>
        <span class="count-numbers text-light" >{{ $total_tagihan }}</span>
        <span class="count-name text-light text-right">Total Tagihan</span>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card-counter " style="height: 130px; background-color: #23afb5;">
        <i class="fa fa-money-bill-alt"></i>
        <span class="count-numbers text-light" >{{ $tagihan_dibayar }}</span>
        <span class="count-name text-light text-right">Total Tagihan <br>  Sudah Dibayar</span>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card-counter" style="height: 130px; background-color: #23afb5;">
        <i class="fa fa-money-bill-alt"></i>
        <span class="count-numbers text-light">{{ $tagihan_belum_dibayar }}</span>
        <span class="count-name text-light text-right">Total Tagihan <br> Belum Dibayar</span>
      </div>
    </div>
</div>
<div style="margin: 2%">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="card-header">
                        <h4>Map Lokasi Kios</h4>
                      </div>
                        <div id="map" style="width: 100%; height: 375px;"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="card-header">
                        <h4>Map Tracking Sales</h4>
                      </div>
                        <div id="map2" style="width: 100%; height: 375px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-body">
              <div class="card-header">
                <h4>Pendapatan Dari Transaksi Kios</h4>
              </div>
                <div class="total_pembayaran">
                    <div style="background-color: #2eb8b8;">
                        <i class="fa fa-money-bill-alt"></i>
                        <p>Uang Tunai</p>
                        <p>Rp. {{ number_format($tunai, 0, ',', '.') }}</p>
                    </div>
                    <div style="background-color: #2eb8b8;">
                        <i class="fa fa-money-check-alt"></i>
                        <p>Bank Transfer</p>
                        <p>Rp. {{ number_format($transfer, 0, ',', '.') }}</p>
                    </div>
                    <div style="background-color: #2eb8b8;">
                        <i class="fa fa-money-bill-wave-alt"></i>
                        <p>Cicilan Terbayar</p>
                        <p>Rp. {{ number_format($cicilan_dibayar, 0, ',', '.') }}</p>
                    </div>
                    <div style="background-color: #2eb8b8;">
                      <i class="fas fa-hand-holding-usd"></i>
                      <p>Cicilan Belum Terbayar</p>
                      <p>Rp. {{ number_format($cicilan_belum_dibayar, 0, ',', '.') }}</p>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin: 2%">
      <div class="row">
        <div class="card" style="width: 100%">
          <div class="card-body">
            <div class="row">
            <div class="col-sm-6">
              <div class="card-header">
                <h4>Table Profit Penjualan <a href="{{ url('report') }}"><button class="btn btn-info d-none d-lg-block m-l-15 mb-3 float-right"><i class="fas fa-link"></i> Detail</button></a></h4>
              </div>
                <table id="config-table" class="table display table-bordered table-striped no-wrap">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Kios</th>
                        <th scope="col">Jumlah Profit</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>

                <div class="col-sm-6">
                  <div class="card-header">
                    <h4>Grafik Profit Penjualan</h4>
                  </div>
                  <br>
                  <canvas id="kios_profit" height="182"></canvas>
                </div>
             </div>
          </div>
        </div>
      </div>
    </div>

    <div style="margin: 2%">
      <div class="row">
        <div class="card" style="width: 100%">
          <div class="card-body">
            <div class="row">
            <div class="col-sm-6">
              <div class="card-header">
                <h4>Table Urutan Pembelian Kios Terbesar <a href="{{ url('report') }}"><button class="btn btn-info d-none d-lg-block m-l-15 mb-3 float-right"><i class="fas fa-link"></i> Detail</button></a></h4>
              </div>
                <table id="config-table2" class="table display table-bordered table-striped no-wrap">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Kios</th>
                        <th scope="col">Jumlah Pembelian</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
            </div>

            <div class="col-sm-6">
              <div class="card-header">
                <h4>Grafik Urutan Pembelian Kios Terbesar</h4>
              </div>
                <br>
                  <canvas id="pembelian_kios" height="182"></canvas>
                </div>
               </div>
             </div>

        </div>
      </div>
    </div>

    <div style="margin: 2%">
      <div class="row">
        <div class="card" style="width: 100%">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="card-header">
                  <h4>Table Urutan penjualan sales <a href="{{ url('reportsales') }}"><button class="btn btn-info d-none d-lg-block m-l-15 mb-3 float-right"><i class="fas fa-link"></i> Detail</button></a></h4>
                </div>
                <table id="config-table4" class="table display table-bordered table-striped no-wrap">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Sales</th>
                        <th scope="col">Jumlah Penjualan</th>
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
</div>
@endsection

@section('script')
<script src="{{URL::asset('js')}}/chart-ds.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvTkPKa1jErT_Kh9ZPTIP2az48f8y0WGo&callback=initMap"></script>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
    https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-database.js"></script>
<script>
$(document).ready(function() {
  var i=0;
  var table=$('#config-table').DataTable({
      processing: true,
      serverSide: true,
      "ajax": "{{ route('getindexDS') }}",
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
      {data: 'total', name: 'total', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
      ],
  });
});

$(document).ready(function() {
  var i=0;
  var table=$('#config-table2').DataTable({
      processing: true,
      serverSide: true,
      "ajax": "{{ route('getindexDS2') }}",
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
      {data: 'nama_kioss', name: 'nama_kioss'},
      {data: 'totals', name: 'totals', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
      ],
  });
});

$(document).ready(function() {
  var i=0;
  var table=$('#config-table4').DataTable({
      processing: true,
      serverSide: true,
      "ajax": "{{ route('getindexDS4') }}",
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
      {data: 'nama_sales', name: 'nama_sales'},
      {data: 'total_tran', name: 'total_tran', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
      ],
  });
});

$(document).ready(function() {
  var i=0;
  var table=$('#config-table3').DataTable({
      processing: true,
      serverSide: true,
      "ajax": "{{ route('getindexDS3') }}",
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
      {data: 'nama_kios2', name: 'nama_kios2'},
      {data: 'total_profit', name: 'total_profit', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
      ],
  });
});







  var SalesTracking = function(){
      var LatLong = [];
      var AjaxKios= function(){
        var xdata;
        $.ajax({
            type: 'GET',
            url: '/getMapKios',
            contentType: 'application/json;charset=utf-8',
            data: [],
            async: false,
            success: function (data) {
              xdata = data;
            }
        });

        return xdata;
      }
      var AjaxSalesToken= function(){
        var xdata;
        $.ajax({
            type: 'GET',
            url: '/getMapSales',
            contentType: 'application/json;charset=utf-8',
            data: [],
            async: false,
            success: function (data) {

                xdata = data;
            }
        });
        return xdata;
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
      var dbFire = function(token, salesname ){

          // Initialize Firebase
          var database = firebase.database();
          //var leadsRef = database.ref('tracking/');
          var ref= database.ref('tracking/'+token);
          ref.on("value", function(snapshot) {
              //console.log(snapshot.val());
              // LatLong.push({latitude:snapshot.val().latitude,longitude:snapshot.val().longitude});
              // $.extend( LatLong[0], {latitude:snapshot.val().latitude,longitude:snapshot.val().longitude});
            var objll = {
              name:salesname,
              latitude:snapshot.val().latitude,
              longitude:snapshot.val().longitude,
            }
            if(token !=null){
              LatLong.push(objll)
            }
          }, function (error) {
              console.log("Error: " + error.code);
          });

      }

      var transferQueryresultfromFirebase = function(){
        var dataSalesOri = AjaxSalesToken();
          dataSalesOri.forEach(function (arrayItem) {
              var name = arrayItem.nama_sales;
              var tokenfirebase = arrayItem.firebase_token;
              dbFire(tokenfirebase, name);
          });
      }

      var MapSales=function(data){
        var locations = [];
        var i=0

        $.each(data, function(i, val){
          locations[i] = [val.name, val.latitude, val.longitude]
          i++
        })

        var map = new google.maps.Map(document.getElementById('map2'), {
          zoom: 6,
          center: new google.maps.LatLng(-7.50166466, 111.257832302),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infowindow = new google.maps.InfoWindow();

        setTimeout(function() {
            var marker, i;

            for (i = 0; i < locations.length; i++) {
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: "/assets/images/sales2.png"
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(locations[i][0]);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }

        }, 2000);
      }

      var MapKios = function(data){
        var locations = [];
        var i=0

        $.each(data, function(i, val){
          locations[i] = [val.name, val.latitude, val.longitude]
          i++
        })

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: new google.maps.LatLng(-7.50166466, 111.257832302),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();
        var marker, i;

        for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: "/assets/images/kios2.png"
          });

          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map, marker);
            }
          })(marker, i));
        }
    }

    return {
      init:function(){
        initDB();
        transferQueryresultfromFirebase();
        console.log(LatLong)
        setTimeout(() => {
          MapSales(LatLong);
          MapKios(AjaxKios());
        }, 3000);
      }
    }
  }();


  $(document).ready(function(){
    SalesTracking.init();
  })

</script>
@endsection

