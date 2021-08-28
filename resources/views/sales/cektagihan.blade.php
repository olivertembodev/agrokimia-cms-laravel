<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('assets')}}/images/favicon.png">
    <title>Agro Kimia</title>
    <!-- Custom CSS -->
    <link href="{{URL::asset('css')}}/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<style type="text/css">
    * {
box-sizing: border-box;
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
    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
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
    <section id="wrapper" class="login-register login-sidebar" style="background-color: white;">
        <div class="">
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-12 col-xs-12">
                        
                          <input type="text" placeholder="Cari Kios.." name="search" style="width: 100%;" id="cari_kios" class="example1">
                        
                    </div>
                </div>
            </div>
            @if ($code == 200)
            <div id="tampilan">
                @foreach($data_kios as $kios)
                <div class="row card-body" class="tampil_kios">
                    <input type="hidden" id="id_sales" value="{{$id}}">
                    <a class="kios" nomor="{{$kios->id}}">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-12 col-xs-12">
                            <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);text-align: left;">
                                <img src="{{$kios->image}}" style="max-width: 50%;min-width: 50%;padding: 10px;"><br>
                                <label style="font-weight: bold;margin-top: 10px;">{{$kios->nama_kios}}</label><br>
                                <span>{{$kios->alamat}}</span><br>
                                <span>{{$kios->pic}}</span><br>
                                <span>{{$kios->phone}}</span><br>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div id="tampilan_kosong" style="display: none;">
                <div class="row" class="tampil_kios">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-12 col-xs-12">
                            <img src="https://akn.s3-id-jkt-1.kilatstorage.id/W9hfUXUJHp0FWuDOFvxxhi9CQDmWhJcRolZwCcAq.png" width="350px" height="50px" class="imgh">
                            <br>
                        </div>
                    </div>
                </div>
                <div class="row" class="tampil_kios" style="margin-top: 30px;">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-2 col-xs-2">
                        </div>
                        <div class="col-md-8 col-xs-8">
                           <label style="text-align: center;" id="label_kosong"></label>
                        </div>
                        <div class="col-md-2 col-xs-2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-3 col-xs-3"></div>
                        <div class="col-md-6 col-xs-6"><button class="btn btn-danger btn-block" id="kembali_ke_task" type="button" style="border-radius:125px;">Kembali Ke Task</button>
                        </div>
                        <div class="col-md-3 col-xs-3"></div>
                    </div>
                </div>
            </div>
            @else
            <div id="tampilan_kosong">
                <div class="row" class="tampil_kios">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-12 col-xs-12">
                            <img src="https://akn.s3-id-jkt-1.kilatstorage.id/W9hfUXUJHp0FWuDOFvxxhi9CQDmWhJcRolZwCcAq.png" width="350px" height="50px" class="imgh">
                            <br>
                        </div>
                    </div>
                </div>
                <div class="row" class="tampil_kios" style="margin-top: 30px;">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-2 col-xs-2">
                        </div>
                        <div class="col-md-8 col-xs-8">
                           <label style="text-align: center;">Anda Belum Memiliki Tugas Tagihan</label>
                        </div>
                        <div class="col-md-2 col-xs-2">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row" id="detail_tagihan" style="display: none;">
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-6 col-xs-6" style="float: left;">
                       <label style="font-weight: bold">Pilih Cicilan</label>
                    </div>
                    <div class="col-md-6 col-xs-6" style="float: right;">
                       <a id="back1">
                       <label style="font-weight: bold;float: right;font-size: 11px;color: #00CED1;">Back</label></a>
                    </div>
                </div>
            </div>
            <div id="isi_tagihan" style="display: none;">
            </div>
        </div>
    </section>
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
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
        // pilih kios
        $('.kios').on("click", function() {
            var id_sales = $("#id_sales").val();
            var id = $(this).attr('nomor');
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({ //line 28
                    url : '/tugas/pilih_kios_tampil_cicilan',
                    type: 'POST',
                    data: { id:id,id_sales:id_sales},
                    dataType: 'json',
                    success: function(data)
                    {   
                       // console.log(data);
                       $("#tampilan").css('display','none');
                       $("#detail_tagihan").css('display','');
                       $(".tagihan_kios").remove();
                        for (var i = 0;i < data.data.length;i++) {
                            $("#detail_tagihan").append('<a class="tagihan_kios" nomor="'+data.data[i].id_cicilan+'"><div class="col-md-12 col-xs-12"><div class="col-md-12 col-xs-12">'+
                                '<div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);text-align: center;">'+
                                '<label style="font-weight: bold;color: #00CED1;">'+data.data[i].no_invoice+'</label></div></div></a>');
                        } 
                        //pilih tagihan
                        $(document).off('click','.tagihan_kios').on('click','.tagihan_kios', function(){                           
                            var id_sales = $("#id_sales").val();
                            var id = $(this).attr('nomor');
                            //alert(id);
                            $.ajaxSetup({
                              headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                            });
                            $.ajax({ //line 28
                                    url : '/tugas/pilih_cicilan',
                                    type: 'POST',
                                    data: { id:id,id_sales:id_sales},
                                    dataType: 'json',
                                    success: function(data)
                                    {   
                                        $(".tagihan_kios").remove();
                                        $(".tampilan_kios").remove();
                                        $("#detail_tagihan").css('display','none');
                                        $("#isi_tagihan").css('display','');
                                        //console.log(data.cicilan.length);
                                        // data toko
                                        $("#isi_tagihan").append('<div class="row tampilan_kios card-body"><div class="col-md-12 col-xs-12"><div class="col-md-12 col-xs-12"><div class="card-body" style="text-align: left;"><img src="'+data.image+'" style="min-width: 50%;max-width: 50%;"><br><label style="font-weight: bold;margin-top: 10px;">'+data.nama_kios+'</label><br><span>'+data.alamat_kios+'</span><br><span>'+data.pic+'</span><br><span>'+data.phone+'</span><br></div></div></div></div>');
                                        //data detail pinjaman
                                        $("#isi_tagihan").append('<div class="row tampilan_kios"><div class="col-md-12 col-xs-12"><div class="col-md-12 col-xs-12"><div class="card-body" style="text-align: left;"><label style="font-weight: bold;margin-top: 10px;">Detail Pinjaman</label><br><span>Total Pinjaman : Rp '+data.total_pinjaman+'</span><br><span>Tempo : '+data.tempo+'</span><br><label style="font-weight: bold;margin-top: 25px;">Tagihan</label></div></div></div></div>');
                                        //detail
                                        for (var i = 0;i < data.cicilan.length;i++) {
                                            if (data.cicilan[i].status == 'Belum Lunas') {
                                            $("#isi_tagihan").append('<div class="col-md-12 col-xs-12 tampilan_kios" style="font-size:10px;"><div class="col-md-5 col-xs-5"><span>'+data.cicilan[i].cicilan_ke+
                                                '</span></div><div class="col-md-3 col-xs-3"><span>Rp '+data.cicilan[i].nominal+
                                                '</span></div><div class="col-md-4 col-xs-4"><span style="color: #FF0000">'+data.cicilan[i].status+
                                                '</span></div></div>');
                                            }else {
                                            $("#isi_tagihan").append('<div class="col-md-12 col-xs-12 tampilan_kios" style="font-size:10px;"><div class="col-md-5 col-xs-5"><span>'+data.cicilan[i].cicilan_ke+
                                                '</span></div><div class="col-md-3 col-xs-3"><span>Rp '+data.cicilan[i].nominal+
                                                '</span></div><div class="col-md-4 col-xs-4"><span style="color: #90EE90"> Lunas'+
                                                '</span></div></div>');
                                            }
                                        } 
                                        $("#isi_tagihan").append('<div class="row tampilan_kios"><div class="col-md-12 col-xs-12"><div class="col-md-12 col-xs-12"><div class="card-body" style="text-align: left;"><label style="font-weight: bold;margin-top: 10px;">Total Pembayaran : Rp '+data.total_pembayaran+'</label></div></div></div></div>');
                                        $("#isi_tagihan").append('<div class="row tampilan_kios"><div class="col-md-12 col-xs-12"><div class="col-md-3 col-xs-3"></div><div class="col-md-6 col-xs-6"><button class="btn btn-danger btn-block" id="tutup" type="button" style="border-radius:125px;">Tutup</button></div><div class="col-md-3 col-xs-3"></div></div></div>');

                                        $('#tutup').on("click", function() {
                                            //alert("hore");
                                            $(".tampilan_kios").remove();
                                            $("#tampilan").css('display','');
                                        });   
                                    }
                            });
                        });   
                    }
            });
        });
        // cari kios
        $("#cari_kios").on("keydown", function(e) {
            if (e.keyCode === 13 || e.keyCode === 9) {
                //alert("okey")
                $("#span_kosong").remove();
                var nama = $("#cari_kios").val();
                $(".tampilan_kios").remove();
                if (nama != '') {
                    var id_sales = $("#id_sales").val();
                    var id = $(this).attr('nomor');
                    $.ajaxSetup({
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                    });
                    $.ajax({ //line 28
                            url : '/tugas/cari_kios',
                            type: 'POST',
                            data: { nama:nama,id_sales:id_sales},
                            dataType: 'json',
                            success: function(data)
                            {   
                                if (data.code != 200) {
                                    //alert("kosong");
                                    $("#label_kosong").append('<span id="span_kosong">Anda Belum Memiliki Tugas Tagihan Pada Kios Tersebut</span>')
                                    $("#tampilan_kosong").css('display','');
                                    $("#tampilan").css('display','none');
                                } else {
                                    console.log(data);
                                }
                                console.log(data.code);    
                            }
                    });
                } else {
                    location.reload();
                }
            }
        });
        // end pilih transaksi
        $(document).off('click','#kembali_ke_task').on('click','#kembali_ke_task', function(){
            $("#tampilan_kosong").css('display','none');
            $("#tampilan").css('display','');
        });

    </script>
    
</body>

</html>