
@extends('layouts._layout')

@section('asset')
<link rel="stylesheet" href="{{URL::asset('assets')}}/timeselector.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Notifikasi</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Informasi</a></li>
                    <li class="breadcrumb-item"><a href="{{route('list-notification')}}">Notifikasi</a></li>
                    <li class="breadcrumb-item active">Tambah Notifikasi</li>
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
                    <form action="{{route('store-notification')}}" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check" id="sem">
                                            <input type="checkbox" class="form-check-input" id="semuaarea" name="checksemuaarea" value="1" checked>
                                            <label class="form-check-label" for="exampleCheck1">Semua Area</label>
                                          </div>
                                    </div>


                                    <div class="form-group" id="cit">
                                        <select class="form-control select2 col-sm-12 col-md-7" name="city_code" style="width:100%;" id="select_city">
                                            <option value=''>Pilih Kota</option>
                                            @foreach ($cities as $city)
                                            <option value="{{$city->city_code}}">{{$city->name}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check" id="tipus">
                                            <input type="checkbox" class="form-check-input" id="checktipeuser" name="checktipeuser" value="1" checked>
                                            <label class="form-check-label" for="exampleCheck1">Semua Tipe User</label>
                                          </div>
                                    </div>

                                    <div class="form-group" id="tipu">
                                        <select class="form-control  col-sm-12 col-md-7" style="width:100%;" name="user_type" id="selecttipeuser">
                                            <option value=''>Pilih Tipe User</option>
                                            <option value='1'>Sales</option>
                                            <option value='2'>Kios</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="us">
                                        <select class="form-control select2 col-sm-12 col-md-7" name="users[]" style="width:100%;" id="selectuser" multiple>
                                            <option value=''>Pilih User</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label">Judul</label>
                                        <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" placeholder="" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control rounded-0 editor" id="deskripsi" rows="5" ></textarea>
                                    </div>

                                    <div class="form-group">
                                        <!-- <div class='input-group date' id='datetimepicker1'> -->
                                            <label class="control-label">Tanggal</label>
                                            <input type='text' name="tanggal" class="form-control" id="datetimepicker1" value="{{ old('tanggal') }}" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                          <!-- </div> -->
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Waktu</label>
                                        <div class='input-group date' id=''>
                                            <input type='text' name="waktu" class="form-control" value="{{ old('waktu') }}" required />
                                            <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
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
<script type="text/javascript" src="{{ asset('assets/ckeditornotif/build/ckeditor.js') }}"></script>
<script src="{{URL::asset('assets')}}/timeselector.js"></script>

<script>ClassicEditor
            .create( document.querySelector( '.editor' ), {
                minHeight: '300px',
                
                toolbar: {
                    items: [
                        '|',
                        'bold',
                        'italic',
                        '|',
                        '|',
                        'undo',
                        'redo',
                        'fontFamily',
                        'fontSize',
                        'underline',
                        'fontColor',
                        'fontBackgroundColor'
                    ]
                },
                language: 'id',
                licenseKey: '',
                
            } )
            .then( editor => {
                window.editor = editor;
        
                
                
                
            } )
            .catch( error => {
                console.error( 'Oops, something gone wrong!' );
                console.error( 'Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:' );
                console.warn( 'Build id: 5ujerc8eyrnw-t8cwpsoypgd1' );
                console.error( error );
            } );
</script>
<script src="{{URL::asset('assets')}}/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/moment/moment.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>
    <script>
        $(document).ready(function() {
            $("#select_city").change(function() {

            });
            $("#selecttipeuser").change(function() {
                var usertipe = $("#selecttipeuser").val();
                var select_city = $("#select_city").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if(select_city!=null){
                    $("#us").show();

                    $("#selectuser").empty();
                    $("#selectuser").append("<option value=''>Pilih User</option>");


                    $.ajax({
                        type: 'GET',
                        url: '/informasi/add-notification/getuserwithtype/' + usertipe +'/'+select_city,
                        dataType: 'json',
                        success: function(data) {
                            // alert('usertype with city')
                            console.log(data);

                            for (let i = 0; i < data.length; i++) {

                                $("#selectuser").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }else{
                    if(usertipe!=null){
                    //alert(usertipe)
                        $("#us").show();

                        $("#selectuser").empty();
                        $("#selectuser").append("<option value=''>Pilih User</option>");


                        $.ajax({
                            type: 'GET',
                            url: '/informasi/add-notification/getuserwithtype/' + usertipe,
                            dataType: 'json',
                            success: function(data) {
                                for (let i = 0; i < data.length; i++) {

                                    $("#selectuser").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                                }
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    }
                }


            });

            $(function() {
                $('#datetimepicker1').datepicker();
            });

            // Select dan ll
            $("#us").hide();
            $("#cit").hide();
            $("#tipu").hide();



            $('#sem :checkbox').change(function() {
                if (this.checked) {
                     $("#cit").hide();
                } else {
                    $("#cit").show();
                    $.ajax({
                        type: 'GET',
                        url: '/informasi/add-notification/allcity',
                        dataType: 'json',
                        success: function(data) {
                            // alert('usertype with city')

                            for (let i = 0; i < data.length; i++) {
                                console.log(data.length)

                                $("#select_city").append("<option value=" + data[i].city_code + ">" + data[i].name + "</option>");
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
            $('#tipus :checkbox').change(function() {
                if (this.checked) {
                    $("#tipu").hide();
                    $("#us").hide();
                } else {
                    $("#tipu").show();
                }
            });



        });
    </script>
    <script>
        $(document).ready(function(){
            $('.select2').select2();
            $(function() {
            $('[name="waktu"]').timeselector({
                hours12:false,
            })
        });
        })
    </script>

@endsection
