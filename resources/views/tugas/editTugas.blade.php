@extends('layouts._layout')
{{-- @section('asset')
<link rel="stylesheet" href="{{URL::asset('assets')}}/timeselector.css">
@endsection --}}


@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Tugas</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-tugas')}}">Tugas</a></li>
                    <li class="breadcrumb-item active">Edit Tugas</li>
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
                    <form action="{{route('update-tugas')}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <input type="hidden" name="id_task" class="form-control" value="{{$task['id']}}" />
                                <input type="hidden" id="tipetaskhidden" name="tipe_tasks" class="form-control"  />
                                <div class="col-md-6">
                                    <div class="form-group" id="tip">
                                    <label class="control-label">Pilih Tipe Tugas</label>
                                    <select class="form-control select2 col-sm-12 col-md-7" name="tipe_task" style="width:100%;" id="select_tipe_tugas" value="{{old('tipe_task')}}" disabled>
                                            <option value=''>Pilih Tipe </option>
                                            @foreach ($tipe_tasks  as $item)
                                                @if ($item->id == $task->id_tipe_tasks) 
                                                    <option value="{{$item->kode_task}}" selected>{{$item->nama_kode}}</option>
                                                @else
                                                    <option value="{{$item->kode_task}}">{{$item->nama_kode}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                  
                                    <div class="form-group" id="cit">
                                        <label class="control-label">Pilih Kota</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="city_code" style="width:100%;" id="select_city" value="{{old('city_code')}}" required>
                                            @foreach ($cities as $city)
                                                @if ($city->id == $task->id_kota) 
                                                    <option value="{{$city->city_code}}" selected>{{$city->name}}</option>
                                                @else
                                                    <option value="{{$city->city_code}}">{{$city->name}}</option>
                                                @endif
                                            @endforeach
                                           
                                        </select>
                                    </div>
                                    <div class="form-group" id="ar">
                                        <label class="control-label">Plih Area</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="area_code" style="width:100%;" id="select_area" required>
                                            @foreach ($areas as $area)
                                                @if ($area->id == $task->id_area) 
                                                    <option value="{{$area->area_code}}" selected>{{$area->name}}</option>
                                                @else
                                                    <option value="{{$area->area_code}}">{{$area->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                   
                                    <div class="form-group" id="us">
                                        <label class="control-label">Pilih Sales</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="sales" style="width:100%;" id="selectsales" required>
                                            <option value='{{$sales->id}}'>{{$sales->nama_sales}}</option>

                                        </select>
                                    </div>

                                    <div class="form-group" id="ki">
                                        <label class="control-label">Pilih Kios</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="kios" style="width:100%;" id="select_kios" required>
                                            @foreach ($kioses as $kios)
                                                @if ($kios->id == $task->id_kios) 
                                                    <option value="{{$kios->id}}" selected>{{$kios->nama_Kios}}</option>
                                                @else
                                                    <option value="{{$kios->id}}">{{$kios->nama_Kios}}</option>
                                                @endif    
                                            @endforeach
                                            
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Catatan</label>
                                        <textarea name="catatan" class="form-control rounded-0" id="catatan" rows="5" required>{{ $task['catatan'] }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control rounded-0" id="deskripsi" rows="5" required>{{$task['deskripsi']}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                        <label class="control-label mr-2">Tanggal</label>

                                            <input type='text' name="tanggal" class="form-control" value="{{date("m-d-Y", strtotime($task['date']))}}" required/>
                                            <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                          </div>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label class="control-label">Waktu</label>
                                        <div class='input-group date' id=''>
                                            <input type='text' name="waktu" class="form-control" value="{{date('G:i  ', strtotime($task['time']))}}" required />
                                            <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div> --}}

                                    <div class="form-group" id="tran" style="display:block">
                                        <label class="control-label">Pilih Transaksi</label>
                                        <select class="form-control select2 col-sm-12 col-md-7" name="transaksi" style="width:100%;" id="selecttransaksi">
                                            @isset($transactions)
                                            <option value=''>Pilih Transaksi</option>
                                            @foreach ($transactions as $tran)
                                                @if ($tran->id == $task->id_transaksi) 
                                                    <option value="{{$tran->id}}" selected>{{$tran->invoice}}</option>
                                                @else
                                                    <option value="{{$tran->id}}">{{$tran->invoice}}</option>
                                                @endif    
                                            @endforeach
                                            @endisset
                                            @isset($transact)
                                            <option value=''>Pilih Transaksi</option>
                                            @foreach ($transact as $tran)
                                                @if ($tran->idLoan == $task->id_transaksi) 
                                                    <option value="{{$tran->idLoan}}" selected>{{$tran->invoice}}</option>
                                                @else
                                                    <option value="{{$tran->idLoan}}">{{$tran->invoice}}</option>
                                                @endif    
                                            @endforeach
                                            @endisset
                                        </select>
                                    </div> 

                                    <div class="form-group" id="tag">
                                        <select class="form-control select2 col-sm-12 col-md-7" name="tagihan" style="width:100%;" id="selecttagihan">
                                            <option value=''>Pilih Invoice Tagihan</option>
                                            @isset($tagihan)
                                            @foreach ($tagihan as $tag)
                                                @if ($tag->idTenor == $task->id_tagihan) 
                                                    <option value="{{$tag->idTenor}}" selected>{{$tag->no_invoice}} - Cicilan ke: {{$tag->no_cicilan}}</option>
                                                @else
                                                    <option value="{{$tag->idTenor}}">{{$tag->no_invoice}} - Cicilan ke: {{$tag->no_cicilan}}</option>
                                                @endif    
                                            @endforeach
                                            @endisset
                                        </select>
                                    </div>


                                    {{-- <div class="form-group" id="tagtung">
                                        <select class="form-control select2 col-sm-12 col-md-7" name="tagtung" style="width:100%;" id="selecttagihantunggakan">
                                            <option value=''>Pilih Tagihan Tunggakan</option>
                                            @isset($tagihantunggakan)
                                                @foreach ($tagihantunggakan as $tagtung)
                                                    @if ($tagtung->id_tugg == $task->id_tunggakan_tagihan) 
                                                        <option value="{{$tagtung->id_tugg}}" selected>{{$tagtung->invoice}}</option>
                                                    @else
                                                        <option value="{{$tagtung->id_tugg}}">{{$tagtung->invoice}}</option>
                                                    @endif    
                                                @endforeach
                                            @endisset
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
                                                @isset($detailtagihan)
                                                <tbody>
                                                    @php
                                                    $no= 1;
                                                    $jumlah=0;
                                                    @endphp
                                                    @foreach($detailtagihan as $dettag)
                                                    @php
                                                    $no++;
                                                    $jumlah +=$dettag->nominal;
                                                    $statuslunas = ($dettag->status_lunas>0) ? "Lunas" : "Belum Lunas"
                                                    @endphp
                                                          <tr>
                                                                <td>{{$no}}</td>
                                                                <td>{{$dettag->no_invoice}}</td>
                                                                <td>{{$dettag->nominal}}</td>
                                                                <td>{{$dettag->date}}</td>
                                                                <td>{{$dettag->no_cicilan}}</td>
                                                                <td>{{$statuslunas}}</td>
                                                                   

                                                     @endforeach 
                                                        <tr bgcolor="#03fce8"><td><strong>Total Nominal</strong></td><td colspan="5"><center>{{$jumlah}}</center></td></tr>
                                                </tbody>
                                                @endisset
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
                                                @isset($detailtransaksi)

                                                <tbody>
                                                    @php
                                                    $no= 1;
                                                    $jumlah=0;
                                                    @endphp
                                                    @foreach($detailtransaksi as $dettran)
                                                    @php
                                                    $no++;
                                                    $totTran=0;
                                                    $a = $dettran->jumlah;
                                                    $totTran += ( $a* (int)$dettran->harga_jual);
                                                    $jumlah += $totTran;
                                                    @endphp
                                                          <tr>
                                                                <td>{{$no}}
                                                                </td>
                                                                <td>{{$dettran->nama_product}}</td>
                                                                <td>{{$dettran->jumlah}}</td>
                                                                <td>{{$dettran->harga_jual}}</td>
                                                                   
                                                        
                                                    @endforeach 
                                                     <tr bgcolor="#03fce8"><td><strong>Jumlah</strong></td><td colspan="3"><center>{{$jumlah}}</center></td></tr>

                                                </tbody>
                                                @endisset

                                            </table>
                                        </div>
                                        
                            </div>
                        </div>
                    {{--     <div class="row p-t-20">
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
                                                @isset($detailtagihantunggakan)
                                                <tbody>
                                                    @php
                                                    $no= 1;
                                                    $jumlah=0;
                                                    @endphp
                                                    @foreach($detailtagihantunggakan as $dettag)
                                                    @php
                                                    $no++;
                                                    $jumlah +=$dettag->nominal;
                                                    $statuslunas = ($dettag->status_lunas>0) ? "Lunas" : "Belum Lunas"
                                                    @endphp
                                                          <tr>
                                                                <td>{{$no}}</td>
                                                                <td>{{$dettag->no_invoice}}</td>
                                                                <td>{{$dettag->nominal}}</td>
                                                                <td>{{$dettag->date}}</td>
                                                                <td>{{$dettag->no_cicilan}}</td>
                                                                <td>{{$statuslunas}}</td>
                                                                   

                                                    
                                                     @endforeach 
                                                     <tr bgcolor="#03fce8"><td><strong>Total Nominal</strong></td><td colspan="5"><center>{{$jumlah}}</center></td></tr>
                                                </tbody>
                                                @endisset
                                            </table>
                                        </div>
                                        
                            </div>
                        </div> --}}
                            
                        <div class="form-actions m-t-30">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            {{-- <a href="{{route('area')}}" type="button" class="btn btn-inverse">Cancel</a>--}}
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
<script src="{{URL::asset('assets')}}/timeselector.js"></script>


    <script>
        $(document).ready(function() {
            if( $("#select_tipe_tugas").val()==2){
                console.log('tagihan');
                $("#tag").show();
                $("#tran").show();
                $("#invoicetable").show();
                $("#transaksitable").hide();
                // $("#tagihantunggakantable").hide();
                // $("#tagtung").hide();
                $('#selecttransaksi').change(function(){
                    let idLoan = $('#selecttransaksi').val();
                    $.ajax({
                        type: 'GET',
                        url: '/tugas/add-tugas/list-tenorsid/' + idLoan,
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $("#tag").show();
                            $("#tran").show();
                            $("#tagtung").hide();
                            $("#transaksitable").hide();
                            // $("#tagihantunggakantable").hide();

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
                    console.log({tagIdTenor});
                
                    $.ajax({
                        type: 'GET',
                        url: '/tugas/add-tugas/list-table-tagihan/' + tagIdTenor,
                        dataType: 'json',
                        success: function(data) {
                            console.log('tagihantable')
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
            }else if($("#select_tipe_tugas").val() == 3){
                // 3. pengiriman.
                $("#tran").show();
                $("#transaksitable").show();
                $("#tag").hide();
                $("#invoicetable").hide();
                // $("#tagtung").hide();
                // $("#tagihantunggakantable").hide();

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
                    console.log({tran})
                    // ajax for transaction table
                    $.ajax({
                        type: 'GET',
                        url: '/tugas/add-tugas/list-table-transaksi/'+ tran,
                        dataType: 'json',
                        success: function(data) {
                            console.table(data);
                            var no = 1
                            var jumlah = 0;
                            $("#transaksi-table tbody").empty();
                            $.each(data, function(key, val) {
                                console.log(key, val);
                                $('#transaksi-table > tbody').append(`<tr><td>${no}</td><td>${val.nama_product}</td><td>${val.jumlah}</td><td>${val.harga_jual}</td></tr>`);
                                no++;
                                jumlah+= parseInt(val.harga_jual);
                            });
                            $('#transaksi-table > tbody').append(` <tr bgcolor="#03fce8"><td><strong>Jumlah</strong></td><td colspan="3"><center>${jumlah}</center></td></tr>`);
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });

                });


            }
            // else if($('#select_tipe_tugas').val() == 4){
            //     $("#tagtung").show();
            //     $("#tagihantunggakantable").show();
            //     $("#tran").hide();
            //     $("#transaksitable").hide();
            //     $("#tag").hide();
            //     $("#invoicetable").hide();
            // }
            else{
                $("#tag").hide();
                $("#tran").hide();
                $("#transaksitable").hide();
                $("#invoicetable").hide();
                // $("#tagtung").hide();
                // $("#tagihantunggakantable").hide();
            }


              // TIPE tugas onChange()
              $("#select_tipe_tugas").change(function(){
                    var tipe_tugas = $("#select_tipe_tugas").val();
                    
                    if(tipe_tugas!=null){
                        // 1. verivikasi
                        // 2. tagihan
                        // 3. pengiriman
                        // 4.  lain-lain
                        // 4.  Tagihan Tungakan
                        if(tipe_tugas==2){
                            console.log('tagihan');
                            $("#tag").show();
                            $("#tran").hide();
                            $("#tagtung").hide();
                            $("#transaksitable").hide();
                            $("#tagihantunggakantable").hide();
                        }else if(tipe_tugas==3){
                            $("#tran").show();
                            $("#tag").hide();
                            $("#tagtung").hide();
                            $("#transaksitable").hide();
                            $("#invoicetable").hide();
                            $("#tagihantunggakantable").hide();
                        // }else if(tipe_tugas==4){
                        //     $("#tagtung").show();
                        //     $("#tag").hide();
                        //     $("#tran").hide();
                        //     $("#invoicetable").hide();
                        //     $("#transaksitable").hide();
                        //     $("#tagihantunggakantable").hide();

                        }
                        else{
                            console.log('selain tagihan dan pengiriman');
                            $("#tagtung").hide();
                            $("#tagihantunggakantable").hide();
                            $("#tag").hide();
                            $("#tran").hide();
                            $("#transaksitable").hide();
                            $("#invoicetable").hide();
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
                        // 4.  lain-lain
                    if(tipe_tugas==2){
                        //console.log({kios});
                        $.ajax({
                            type: 'GET', 
                            url: '/tugas/add-tugas/list-tagihan/' + kios,
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                $("#tran").show();
                                $("#tag").show();
                                $("#tagtung").hide();
                                $("#transaksitable").hide();
                                $("#tagihantunggakantable").hide();
                                $("#tagihan-table tbody").empty();

                                $("#selecttagihan").empty();
                                $("#selecttagihan").append("<option value=''>Pilih Invoice Tagihan</option>");
                                for (let i = 0; i < data.length; i++) {
                                    $("#selecttagihan").append("<option value=" + data[i].idtran + ">" + data[i].invoice + "</option>");
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
                                    console.log(data);
                                    $("#tag").show();
                                    $("#tran").show();
                                    $("#tagtung").hide();
                                    $("#transaksitable").hide();
                                    // $("#tagihantunggakantable").hide();
    
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
                            console.log({tagIdTenor});
                        
                            $.ajax({
                                type: 'GET',
                                url: '/tugas/add-tugas/list-table-tagihan/' + tagIdTenor,
                                dataType: 'json',
                                success: function(data) {
                                    console.log('tagihantable')
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
                                console.log({tran})
                                // ajax for transaction table
                                $.ajax({
                                    type: 'GET',
                                    url: '/tugas/add-tugas/list-table-transaksi/'+ tran,
                                    dataType: 'json',
                                    success: function(data) {
                                        console.table(data);
                                        var no = 1
                                        var jumlah = 0;
                                        $("#transaksi-table tbody").empty();
                                        $.each(data, function(key, val) {
                                            var totaTransact = 0;
                                            console.log(key, val);
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
                    // else if(tipe_tugas==4){
                    //     //console.log({kios});
                    //     $.ajax({
                    //         type: 'GET', 
                    //         url: '/tugas/add-tugas/list-tagihan-tunggakan/' + kios,
                    //         dataType: 'json',
                    //         success: function(data) {
                    //             $("#tagtung").show();
                    //             $("#tran").hide();
                    //             $("#tag").hide();
                    //             $("#invoicetable").hide();
                    //             $("#transaksitable").hide();
                    //             console.log(data);
                    //         $("#selecttagihantunggakan").empty();
                    //         $("#invoicetable").hide();
                    //         $("#selecttagihantunggakan").append("<option value=''>Pilih Tagihan Tunggakan</option>");
                    //         for (let i = 0; i < data.length; i++) {
                    //             $("#selecttagihantunggakan").append("<option value=" + data[i].id_tugg + ">" + data[i].invoice + "</option>");
                    //         }
                    //         },
                    //         error: function(data) {
                    //             console.log(data);
                    //         }
                    //     });
                    // }
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
                            console.log(data);
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
                            console.log(data);
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
                    autoclose: true,
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '2020:'+(new Date).getFullYear()   
                });
            });
        

            let valtipetask =  $('#select_tipe_tugas').val();
            console.log({valtipetask});
            
            $('#tipetaskhidden').val(valtipetask); 

            // $(function() {
            //     $('[name="waktu"]').timeselector({
            //         hours12:false,
            //     })
            // });
                   
        });
    </script>
    <script>
        $(document).ready(function(){
            $('.select2').select2();
        })
    </script>

@endsection
