@extends('layouts._layout')

{{-- @section('asset')
<link rel="stylesheet" href="{{URL::asset('assets')}}/timeselector.css">
@endsection --}}

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Tugas</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-tugas')}}">Tugas</a></li>
                    <li class="breadcrumb-item active">Tambah Tugas</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('store-tugas')}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">

                                <div class="col-md-6">
                                    <div class="form-group" id="tip">
                                        <label class="control-label">Pilih Tipe Tugas</label>
                                    <select class="form-control select2 col-sm-12 col-md-7" name="tipe_task" style="width:100%;" id="select_tipe_tugas" required>
                                            <option value=''>Pilih Tipe </option>
                                            @foreach ($tipe_tasks as $tipe)
                                            <option value="{{$tipe->kode_task}}">{{$tipe->nama_kode}}</option>

                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group" id="cit">
                                        <label class="control-label">Pilih Kota</label>
                                        <select class="form-control select2 col-sm-4" name="city_code" style="width:100%;" id="select_city"required>
                                            <option value=''>Pilih Kota</option>
                                            @foreach ($cities as $city)
                                            <option value="{{$city->city_code}}">{{$city->name}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="ar">
                                        <label class="control-label">Plih Area</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="area_code" style="width:100%;" id="select_area" required>
                                            <option value=''>Pilih Area</option>
                                            {{-- <option value=''>Pilih Area</option>

                                            @foreach ($areas as $area)
                                            <option value="{{$area->area_code}}">{{$area->name}}</option>

                                            @endforeach --}}
                                        </select>
                                    </div>


                                    <div class="form-group" id="us">
                                        <label class="control-label">Pilih Sales</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="sales" style="width:100%;" id="selectsales" required>
                                            <option value=''>Pilih Sales</option>
                                        </select>
                                    </div>


                                    {{-- <div class="form-group">
                                        <label class="control-label">Nama Tugas</label>
                                        <input type="text" name="task_name" id="taskname" class="form-control" value="{{ old('task_name') }}" placeholder="">
                                    </div> --}}


                                    <div class="form-group" id="ki">
                                        <label class="control-label">Pilih Kios</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="kios" style="width:100%;" id="select_kios" required>
                                            <option value=''>Pilih Kios</option>
                                            {{-- @foreach ($kioses as $kios)
                                            <option value="{{$kios->id}}">{{$kios->nama_Kios}}</option>

                                            @endforeach --}}
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label">Catatan</label>
                                        <textarea name="catatan" class="form-control rounded-0" id="catatan" rows="5" value="{{ old('catatan') }}" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control rounded-0" id="deskripsi" rows="5" value="{{ old('deskripsi') }}" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Tanggal</label>
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' name="tanggal" class="form-control" value="{{ old('tanggal') }}" required />
                                            <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label class="control-label">Waktu</label>
                                        <div class='input-group date' id=''>
                                            <input type='text' name="waktu" class="form-control" value="{{ old('waktu') }}" required />
                                            <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div> --}}

                                    <div class="form-group" id="tran">
                                        <label class="control-label">Pilih Transaksi</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="transaksi" style="width:100%;" id="selecttransaksi" >
                                            <option value=''>Pilih Transaksi</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="tag">
                                        <label class="control-label">Pilih Invoice Tagihan</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="tagihan" style="width:100%;" id="selecttagihan" >
                                            <option value=''>Pilih Invoice Tagihan</option>
                                        </select>
                                    </div>


                                    {{-- <div class="form-group" id="tagtung">
                                        <select class="form-control select2 col-sm-12 col-md-7" name="tagtung" style="width:100%;" id="selecttagihantunggakan">
                                            <option value=''>Pilih Tagihan Tunggakan</option>
                                        </select>
                                    </div> --}}

                                </div>
                            </div>
                        </div>

                        <div class="row p-t-20">
                            <div class="col-md-12" id="invoicetable">
                                        <div class="table-responsive ">
                                            <table id="tagihan-table" class="table display table-bordered table-striped no-wrap">
                                                <thead>
                                                    <tr>

                                                        <th>NO</th>
                                                        <th>Invoice </th>
                                                        <th>Nominal</th>
                                                        <th>Tanggal</th>
                                                        <th>No Cicilan</th>
                                                        <th>Status Lunas</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>

                                            </table>
                                        </div>

                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-12" id="transaksitable">
                                        <div class="table-responsive ">
                                            <table id="transaksi-table" class="table display table-bordered table-striped no-wrap">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Nama Produk</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>

                                            </table>
                                        </div>

                            </div>
                        </div>
                        {{-- <div class="row p-t-20">
                            <div class="col-md-12" id="tagihantunggakantable">
                                        <div class="table-responsive ">
                                            <table id="tagtung-table" class="table display table-bordered table-striped no-wrap">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Invoice </th>
                                                        <th>Nominal</th>
                                                        <th>Tanggal</th>
                                                        <th>No Cicilan</th>
                                                        <th>Status Lunas</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>

                                            </table>
                                        </div>

                            </div>
                        </div> --}}
                        <div class="form-actions m-t-30">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            {{-- <a href="{{route('area')}}" type="button" class="btn btn-inverse">Cancel</a> --}}
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/moment/moment.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>
{{-- <script src="{{URL::asset('assets')}}/timeselector.js"></script> --}}

    <script>
        $(document).ready(function() {
            $("#tag").hide();
            $("#tran").hide();
            $("#tagtung").hide();
            $("#invoicetable").hide();
            $("#transaksitable").hide();
            $("#tagihantunggakantable").hide();


            // TIPE tugas onChange()
            $("#select_tipe_tugas").change(function(){
                    var tipe_tugas = $("#select_tipe_tugas").val();
                    // console.log(tipe_tugas);
                    if(tipe_tugas!=null){
                        // 1. verivikasi
                        // 2. tagihan
                        // 3. pengiriman
                        // 4.  lain-lain
                        // 5.  Tagihan Tungakan
                        if(tipe_tugas==2){
                            // console.log('tagihan');
                            $("#tran").show();
                            $("#tag").show();
                            $("#tagihantunggakantable").hide();
                            $("#transaksitable").hide();
                        }else if(tipe_tugas==3){
                            $("#tag").hide();
                            $("#invoicetable").hide();
                            $("#tran").show();
                            $("#tagihantunggakantable").hide();
                        // }else if(tipe_tugas==4){
                        //     $("#tagtung").show();
                        //     $("#tagihantunggakantable").hide();
                        //     $("#tag").hide();
                        //     $("#invoicetable").hide();
                        //     $("#tran").hide();
                        }else{
                            // console.log('selain tagihan dan pengiriman');
                            $("#tagihantunggakantable").hide();
                            $("#tag").hide();
                            $("#tran").hide();
                            $("#transaksitable").hide();
                            $("#invoicetable").hide();
                            $("#tagtung").hide();
                        }
                    // $("#selectuser").empty();
                    // $("#selectuser").append("<option value=''>Pilih User</option>");

                }

            });
            // KIOS OnChnage
            $('#select_kios').change(function(){
                let kios = $("#select_kios").val();
                let tipe_tugas = $("#select_tipe_tugas").val();

                if(tipe_tugas!=null){
                        // 1. verivikasi
                        // 2. tagihan
                        // 3. pengiriman
                        // 4.  tagihan tunggakan 
                        //5. lain-lain.
                    if(tipe_tugas==2){
                        //console.log({kios});
                        $.ajax({
                            type: 'GET',
                            url: '/tugas/add-tugas/list-tagihan/' + kios,
                            dataType: 'json',
                            success: function(data) {
                                $("#tran").show();
                                $("#tag").show();
                                $("#tagtung").hide();
                                $("#invoicetable").hide();
                                $("#tagihantunggakantable").hide();

                                $("#selecttransaksi").empty();
                                $("#selecttransaksi").append("<option value=''>Pilih Transaksi</option>");
                                for (let i = 0; i < data.length; i++) {
                                    $("#selecttransaksi").append("<option value=" + data[i].idLoan + ">" + data[i].invoice + "</option>");
                                }
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });

                        $('#selecttransaksi').change(function(){
                           let idLoan = $('#selecttransaksi').val();
                            $.ajax({
                                type: 'GET',
                                url: '/tugas/add-tugas/list-tenorsid/' + idLoan,
                                dataType: 'json',
                                success: function(data) {
                                    // console.log(data);
                                    $("#tag").show();
                                    $("#tran").show();
                                    $("#tagtung").hide();
                                    $("#transaksitable").hide();
                                    $("#tagihantunggakantable").hide();
    
                                    $("#selecttagihan").empty();
                                    $("#selecttagihan").append("<option value=''>Pilih Invoice Tagihan</option>");
                                    for (let i = 0; i < data.length; i++) {
                                        $("#selecttagihan").append("<option value=" + data[i].idTenor + ">" + data[i].no_invoice +" - Cicilan ke: "+ data[i].no_cicilan+ "</option>");
                                    }
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            });

                        });

                        $('#selecttagihan').change(function(){
                            $("#invoicetable").show();
                            $("#tag").show();
                            $("#tran").show();
                            $("#tagtung").hide();
                            $("#transaksitable").hide();
                            $("#tagihantunggakantable").hide();

                            let tagIdTenor =  $('#selecttagihan').val();
                            // console.log({tagIdTenor});
                        
                            $.ajax({
                                type: 'GET',
                                url: '/tugas/add-tugas/list-table-tagihan/' + tagIdTenor,
                                dataType: 'json',
                                success: function(data) {
                                    // console.log('tagihantable')
                                    var no = 1;
                                    var jumlah = 0;
                                    $("#tagihan-table tbody").empty();
                                    $.each(data, function(key, val) {
                                        let statLunas = (val.statLunas>0) ? "Lunas" : "Belum Lunas";
                                        $('#tagihan-table > tbody').append(`<tr><td>${no}</td><td>${val.no_invoice}</td><td>${val.nominal}</td><td>${val.date}</td><td>${val.no_cicilan}</td><td>${statLunas}</td></tr>`);
                                        no++;
                                        jumlah+= parseInt(val.nominal);
                                    });
                                    $('#tagihan-table > tbody').append(` <tr bgcolor="#03fce8"><td><strong>Total Nominal</strong></td><td colspan="5"><center>${jumlah}</center></td></tr>`);
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            });
                        });

                    }
                    else if(tipe_tugas==3){
                        //console.log({kios});
                        $.ajax({
                            type: 'GET',
                            url: '/tugas/add-tugas/list-transaksi/' + kios,
                            dataType: 'json',
                            success: function(data) {
                                $("#tran").show();
                                $("#tag").hide();
                                $("#tagtung").hide();
                                $("#invoicetable").hide();
                                $("#tagihantunggakantable").hide();

                                $("#selecttransaksi").empty();
                                $("#selecttransaksi").append("<option value=''>Pilih Transaksi</option>");
                                for (let i = 0; i < data.length; i++) {
                                    $("#selecttransaksi").append("<option value=" + data[i].id + ">" + data[i].invoice + "</option>");
                                }
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });

                        $('#selecttransaksi').change(function(){
                                $("#tran").show();
                                $("#transaksitable").show();
                                $("#invoicetable").hide();
                                $("#tagihantunggakantable").hide();
                                $("#tag").hide();
                                $("#tagtung").hide();
                                $("#tag").hide();
                                // $("#tagtung").hide();
                                let tran =  $('#selecttransaksi').val();
                                // console.log({tran})
                                // ajax for transaction table
                                $.ajax({
                                    type: 'GET',
                                    url: '/tugas/add-tugas/list-table-transaksi/'+ tran,
                                    dataType: 'json',
                                    success: function(data) {
                                        // console.table(data);
                                        var no = 1
                                        var jumlah = 0;
                                        $("#transaksi-table tbody").empty();
                                        $.each(data, function(key, val) {
                                            var totaTransact = 0;
                                            // console.log(key, val);
                                            $('#transaksi-table > tbody').append(`<tr><td>${no}</td><td>${val.nama_product}</td><td>${val.jumlah}</td><td>${val.harga_jual}</td></tr>`);
                                            no++;
                                            totaTransact += (val.jumlah * parseInt(val.harga_jual));
                                            jumlah+= totaTransact;
                                        });
                                        $('#transaksi-table > tbody').append(` <tr bgcolor="#03fce8"><td><strong>Jumlah</strong></td><td colspan="3"><center>${jumlah}</center></td></tr>`);
                                    },
                                    error: function(data) {
                                        console.log(data);
                                    }
                                });

                        });
                    }
                    else if(tipe_tugas==4){
                        //console.log({kios});
                        $.ajax({
                            type: 'GET',
                            url: '/tugas/add-tugas/list-tagihan-tunggakan/' + kios,
                            dataType: 'json',
                            success: function(data) {
                                $("#tagtung").show();
                                $("#tran").hide();
                                $("#tag").hide();
                                $("#invoicetable").hide();
                                $("#transaksitable").hide();
                                // console.log(data);
                            $("#selecttagihantunggakan").empty();
                            $("#invoicetable").hide();
                            $("#selecttagihantunggakan").append("<option value=''>Pilih Tagihan Tunggakan</option>");
                            for (let i = 0; i < data.length; i++) {
                                $("#selecttagihantunggakan").append("<option value=" + data[i].id_tugg + ">" + data[i].invoice + "</option>");
                            }
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    }
                    else{

                    }
                }
            });

            $("#select_city").change(function(){
                let city = $("#select_city").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if(city!=null){
                   // $("#us").show();
                   // $("#selectuser").empty();
                    $.ajax({
                        type: 'GET',
                        url: '/tugas/add-tugas/list-area/' + city,
                        dataType: 'json',
                        success: function(data) {
                            // alert('usertype with city')
                            // console.log(data);
                            $("#select_area").empty();
                            $("#select_area").append("<option value=''>Pilih Area</option>");
                            for (let i = 0; i < data.length; i++) {
                                $("#select_area").append("<option value=" + data[i].area_code + ">" + data[i].name + "</option>");
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
            // Sales OnChnage
            $("#select_area").change(function() {
                var select_area = $("#select_area").val();
                console.log(select_area);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if(select_area!=null){
                   // $("#us").show();
                   // $("#selectuser").empty();
                   // $("#selectuser").append("<option value=''>Pilih User</option>");
                    $.ajax({
                        type: 'GET',
                        url: '/tugas/add-tugas/list-sales/' + select_area,
                        dataType: 'json',
                        success: function(data) {
                            // alert('usertype with city')
                            // console.log(data);

                            $("#selectsales").empty();

                                $("#selectsales").append("<option value=''>Pilih Sales</option>");
                            for (let i = 0; i < data.length; i++) {
                                $("#selectsales").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                    $.ajax({
                        type: 'GET',
                        url: '/tugas/add-tugas/list-kios/' + select_area,
                        dataType: 'json',
                        success: function(data) {
                            // alert('usertype with city')
                            // console.log(data);

                            $("#select_kios").empty();

                                $("#select_kios").append("<option value=''>Pilih Kios</option>");
                            for (let i = 0; i < data.length; i++) {
                                $("#select_kios").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
            $(function() {
                $('#datetimepicker1').datepicker({
                    format: "mm/dd/yyyy",
                    autoclose: true
                });
            });

           


            // 

            // loans_arreas tungakan on change
           /*  // $('#selecttagihantunggakan').change(function(){
            //     $("#tagtung").show();
            //     $("#tagihantunggakantable").show();
            //     $("#invoicetable").hide();
            //     $("#transaksitable").hide();
            //     $("#tag").hide();
            //     $("#tran").hide();

            //     let tagtr =  $('#selecttagihantunggakan').val();
            //     // ajax for tagihan tunggakan table
            //     $.ajax({
            //         type: 'GET',
            //         url: '/tugas/add-tugas/list-table-tagihan-tunggakan/'+ tagtr,
            //         dataType: 'json',
            //         success: function(data) {
            //             console.table(data);
            //             var no = 0
            //             var jumlah = 0;
            //             $("#tagtung-table tbody").empty();
            //             $.each(data, function(key, val) {
            //                 let statLunas = (val.status_lunas>0) ? "Lunas" : "Belum Lunas";
            //                 no++;
            //                 jumlah+= parseInt(val.nominal);
            //                 $('#tagtung-table > tbody').append(`<tr><td>${no}</td><td>${val.no_invoice}</td><td>${val.nominal}</td><td>${val.date}</td><td>${val.no_cicilan}</td><td>${statLunas}</td></tr>`);

            //             });
            //             $('#tagtung-table > tbody').append(` <tr bgcolor="#03fce8"><td><strong>Jumlah</strong></td><td colspan="5"><center>${jumlah}</center></td></tr>`);
            //         },
            //         error: function(data) {
            //             console.log(data);
            //         }
            //     });

            // }); */
        });
    </script>
    <script>

         /* var tagrable = $('#tagihan-table').DataTable( {
                    "ajax": '/tugas/add-tugas/list-table-tagihan/'+ tag,
                    "columns": [
                            { "data": "no_invoice" },
                            { "data": "product" },
                            { "data": "kios" },
                            { "data": "jumlah" },
                            { "data": "nominal" },
                            { "data": "total" },
                            { "data": "id_xendit" },
                            { "data": "invoice_url" },
                            { "data": "status" },
                            { "data": "status_lunas" },
                            { "data": "tanggal" },
                            { "data": "deskripsi" },
                            { "data": "invoice_transaksi" },
                            { "data": "nama_status" },
                            { "data": "no_cicilan" },
                            { "data": "tenor" },
                    ],
                    "paging":   false,
                    "ordering": false,
                    "searching": false,
                    "info":     false
                } ); */
        $(document).ready(function(){
            $('.select2').select2();
        })
        // Time tidak jadi
        // $(function() {
        //     $('[name="waktu"]').timeselector({
        //         hours12:false,
        //     })
        // });


        // 15-4-2020 at 6:49 pm
    </script>

@endsection


