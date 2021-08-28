<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('assets')}}/images/favicon.png">
    <title>Agro Kimia</title>
    <!-- Custom CSS -->
    <link href="{{URL::asset('css')}}/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{URL::asset('css')}}/anypicker-all.min.css" rel="stylesheet" />

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
    
<style type="text/css">
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

@keyframes bake-pie {
  from {
    transform: rotate(0deg) translate3d(0,0,0);
  }
}

body {
  font-family: "Open Sans", Arial;
  background: #EEE;
}
main {
  width: 400px;
  margin: 30px auto;
}
section {
  margin-top: 30px;
}
.pieID {
  display: inline-block;
  vertical-align: top;
}
.pie {
  height: 200px;
  width: 200px;
  position: relative;
  margin: 0 30px 30px 0;
}
.pie::before {
  content: "";
  display: block;
  position: absolute;
  z-index: 1;
  width: 100px;
  height: 100px;
  background: #EEE;
  border-radius: 50%;
  top: 50px;
  left: 50px;
}
.pie::after {
  content: "";
  display: block;
  width: 120px;
  height: 2px;
  background: rgba(0,0,0,0.1);
  border-radius: 50%;
  box-shadow: 0 0 3px 4px rgba(0,0,0,0.1);
  margin: 220px auto;
  
}
.slice {
  position: absolute;
  width: 200px;
  height: 200px;
  clip: rect(0px, 200px, 200px, 100px);
  animation: bake-pie 1s;
}
.slice span {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  background-color: black;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  clip: rect(0px, 200px, 200px, 100px);
}
.legend {
  list-style-type: none;
  padding: 0;
  margin: 0;
  background: #FFF;
  padding: 15px;
  font-size: 13px;
}
.legend li {
  width: 110px;
  height: 1.25em;
  margin-bottom: 0.7em;
  padding-left: 0.5em;
  border-left: 1.25em solid black;
}
.legend em {
  font-style: normal;
}
.legend span {
  float: right;
}
footer {
  position: fixed;
  bottom: 0;
  right: 0;
  font-size: 13px;
  background: #DDD;
  padding: 5px 10px;
  margin: 5px;
}
form.example input[type=text] {
  padding: 10px;
  font-size: 12px;
  border: 1px solid grey;
  float: left;
  width: 80%;
  background: #f1f1f1;
  border-radius :125px;
}

.example1 {
  float: left;
  width: 20%;
  padding: 10px;
  background: #f0f3f5;
  color: black;
  font-size: 12px;
  border: 1px solid grey;
  cursor: pointer;
  border-radius: 125px;
}

.example1 {
  background: #f0f3f5;
}
</style>
</head>

<body style="overflow-y: scroll;overflow-x: scroll;">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Agro Kimia</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar" style="background-color: white; margin-top:-0px;">
        <!-- Laporan Tugas Sales bung-->
      <div id="laporan_sales">
        <div class="row">
           <div class="col-md-12 col-xs-12">
                <div class="col-md-6 col-xs-6" style="float: left;">
                   <label style="font-weight: bold">Laporan Tugas</label>
                </div>
                <div class="col-md-6 col-xs-6" style="float: right;">
                   <a href="javascript:void(0)" class="filter_x">
                   <label style="font-weight: bold;float: right;font-size: 11px;color: #00CED1;">filter</label></a>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-6 col-xs-6" style="float: left;">
                        <div class="card-body" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);text-align: center;border-radius: 10px;">
                            <label style="font-size: 11px;">Sudah Terealisasi</label><br>
                            <label style="color: #90EE90">{{$task_finish}}</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6" style="float: right;">
                        <div class="card-body" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);text-align: center;border-radius: 10px;">
                            <label style="font-size: 11px;">Belum Terealisasi</label><br>
                            <label style="color: #FF0000">{{$task_not_finish}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Laporan Tagihan -->
        <div class="row" style="margin-top: 25px;">
           <div class="col-md-12 col-xs-12">
                <div class="col-md-6 col-xs-6" style="float: left;">
                   <label style="font-weight: bold">Laporan Tagihan</label>
                </div>
                <div class="col-md-6 col-xs-6" style="float: right;">
                    <a href="javascript:void(0)" class="filter_x">
                   <label style="font-weight: bold;float: right;font-size: 11px;color: #00CED1;">filter</label></a>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-6 col-xs-6" style="float: left;">
                        <div class="card-body" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);text-align: center;border-radius: 10px;">
                            <label style="font-size: 11px;">Terbayarkan</label><br>
                            <label style="color: #90EE90">{{number_format($tagihan_lunas)}}</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6" style="float: right;">
                        <div class="card-body" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);text-align: center;border-radius: 10px;">
                            <label style="font-size: 11px;">Belum Terbayarkan</label><br>
                            <label style="color: #FF0000">{{number_format($tagihan_belum_lunas)}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- grafik tipe tugas -->
        <div class="row" style="margin-top: 25px;">
           <div class="col-md-12 col-xs-12">
                <div class="col-md-6 col-xs-6" style="float: left;">
                   <label style="font-weight: bold">Grafik Tipe Tugas</label>
                </div>
                <div class="col-md-6 col-xs-6" style="float: right;">
                    <a href="javascript:void(0)" class="filter_x">
                   <label style="font-weight: bold;float: right;font-size: 11px;color: #00CED1;">filter</label></a>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-12 col-xs-12">
                        <div class="card-body" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);text-align: center;border-radius: 10px;">
                            <div class="pieID pie">
      
                            </div>
                            <br>
                            <ul class="pieID legend" style="width: 70%">
                            @foreach($grafik_tipe_task as $tipe)
                              <li style="width: 100%;text-align: left;">
                                <em>{{$tipe->nama_kode}}</em>
                                <span>{{$tipe->count}}</span>
                              </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stok dibawa -->
        <div class="row" style="margin-top: 25px;">
           <div class="col-md-12 col-xs-12">
                <div class="col-md-6 col-xs-6" style="float: left;">
                   <label style="font-weight: bold">Stok Produk Dibawa</label>
                </div>
                <div class="col-md-6 col-xs-6" style="float: right;">
                    <a href="javascript:void(0)" class="filter_x">
                   <label style="font-weight: bold;float: right;font-size: 11px;color: #00CED1;">filter</label></a>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12 col-xs-12"> 
                    <div class="col-md-12 col-xs-12">   
                        <div class="card-body" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);border-radius: 10px;">
                          @if ($barang_dibawa == 0)
                            <label style="font-weight: bold;">Tidak Ada Produk Yang dibawa</label><br>
                          @else
                            <label style="font-weight: bold;">Product</label><br>
                            @foreach($barang_dibawa as $produk)
                            <span>{{$produk['barang']}}</span>
                            <span>({{number_format($produk['nominal'])}})</span>
                            <br>
                            @endforeach
                            <label style="font-weight: bold;">Total : Rp {{number_format($total)}}</label>
                          @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
    <div id="modal-filter" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <form id="filter_xy">@csrf
              <div class="modal-content modal-lg">
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-xs-12 col-md-12">
                        <div class="col-md-6 col-xs-6" style="float: left;">
                           <input type="text" name="start" style="width: 100%;" id="cari_kios" class="example1 input-date" placeholder="YYYY-MM-DD" readonly>
                           <input type="hidden" name="id" value="{{$id}}">
                           <input type="hidden" name="token" value="{{$token}}">
                          
                        </div>
                        <div class="col-md-6 col-xs-6" style="float: right;">
                             <input type="text" name="end" style="width: 100%;" id="cari_kios" class="example1 input-date" placeholder="YYYY-MM-DD" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="" style="margin-top: 20px;">
                        <div class="col-xs-12 col-md-12">
                          <button type="button" class="btn waves-effect btn-block" data-dismiss="modal" id="submit_filter_x" style="background: #00CED1;border-radius: 125px;color: white">FILTER</button>
                        </div>
                    </div>
                  </div>
              </div>
          </form>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{URL::asset('assets')}}/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{URL::asset('assets')}}/node_modules/popper/popper.min.js"></script>
    <script src="{{URL::asset('assets')}}/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{URL::asset('js')}}/anypicker.min.js"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(".input-date").AnyPicker(
                    {
                      mode: "datetime",
                      dateTimeFormat: "YYYY-MM-dd",
                      maxValue: new Date(),
                      minValue: new Date(2018, 01, 19)
        });
        $(document).off('click','.filter_x').on('click','.filter_x', function(){
           
           $("#modal-filter").modal('show');
        });
        $(document).off('click','#submit_filter_x').on('click','#submit_filter_x', function(){
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({
              url :'/filter_tugas_sales',
              type: "POST",
              data: $("#filter_xy").serialize(),
              success: function (response) {                
                  console.log(response);
                  if(response) {
                      $("#laporan_sales").remove();
                      $("#wrapper").html(response);
                  }
                  
              }
            });
        });
        function sliceSize(dataNum, dataTotal) {
          return (dataNum / dataTotal) * 360;
        }
        function addSlice(sliceSize, pieElement, offset, sliceID, color) {
          $(pieElement).append("<div class='slice "+sliceID+"'><span></span></div>");
          var offset = offset - 1;
          var sizeRotation = -179 + sliceSize;
          $("."+sliceID).css({
            "transform": "rotate("+offset+"deg) translate3d(0,0,0)"
          });
          $("."+sliceID+" span").css({
            "transform"       : "rotate("+sizeRotation+"deg) translate3d(0,0,0)",
            "background-color": color
          });
        }
        function iterateSlices(sliceSize, pieElement, offset, dataCount, sliceCount, color) {
          var sliceID = "s"+dataCount+"-"+sliceCount;
          var maxSize = 179;
          if(sliceSize<=maxSize) {
            addSlice(sliceSize, pieElement, offset, sliceID, color);
          } else {
            addSlice(maxSize, pieElement, offset, sliceID, color);
            iterateSlices(sliceSize-maxSize, pieElement, offset+maxSize, dataCount, sliceCount+1, color);
          }
        }
        function createPie(dataElement, pieElement) {
          var listData = [];
          $(dataElement+" span").each(function() {
            listData.push(Number($(this).html()));
          });
          var listTotal = 0;
          for(var i=0; i<listData.length; i++) {
            listTotal += listData[i];
          }
          var offset = 0;
          var color = [
            "cornflowerblue", 
            "olivedrab", 
            "orange", 
            "tomato", 
            "crimson", 
            "purple", 
            "turquoise", 
            "forestgreen", 
            "navy", 
            "gray"
          ];
          for(var i=0; i<listData.length; i++) {
            var size = sliceSize(listData[i], listTotal);
            iterateSlices(size, pieElement, offset, i, 0, color[i]);
            $(dataElement+" li:nth-child("+(i+1)+")").css("border-color", color[i]);
            offset += size;
          }
        }
        createPie(".pieID.legend", ".pieID.pie");

    </script>
    
</body>

</html>