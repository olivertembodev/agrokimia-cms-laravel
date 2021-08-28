@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Sales</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('list-sales') }}">Sales</a></li>
                    <li class="breadcrumb-item active">Tambah Sales</li>
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
                    <form action="{{route('insertSales')}}" method="post" enctype="multipart/form-data">@csrf
                        <div class="form-body">
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Nama Sales</label>
                                        <input type="text" name="nama_sales" id="nama_sales" class="form-control" value="{{ old('nama_sales') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Alamat Sales</label>
                                        <input type="text" name="alamat_sales" id="alamat_sales" class="form-control" value="{{ old('alamat_sales') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Pilih Kota</label>
                                        <select name="id_kota" id="id_kota" class="form-control select2" required>
                                            <option value="">Pilih Kota</option>
                                            @foreach ($cities as $item)
                                                @if (old('id_kota') == $item->city_code)
                                                    <option value="{{ $item->city_code }}" selected>{{ $item->name }}</option>
                                                @else
                                                    <option value="{{ $item->city_code }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Pilih Area</label>
                                        <select class="form-control select2" name="area_code" id="area" required>
                                            <option value=''>Pilih Area</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">NIK</label>
                                        <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" placeholder="" required>
                                    </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">NIP</label>
                                        <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">ReType Password</label>
                                        <input type="password" name="password_confirmation" id="password" class="form-control" value="{{ old('password') }}" placeholder="" required>
                                    </div>
                                </div>

                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="">Pilih Status</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Images</label><br>
                                        <input id="files" class="form-control col-md-8 mb-2" type="file" name="foto">
                                        <button class="col-md-2 float-right" type="button" id="clear">Clear</button>
                                        <output class="w-100" id="result">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{ route('list-sales')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>

    <script>
        $(document).ready(function() {
            $("#id_kota").change(function() {
                var provid = $("#id_kota").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if(provid){

                $.ajax({
                    type: 'GET',
                    url: '/area/' + provid,
                    dataType: 'json',
                    success: function(data) {
                        $("#area").empty();
                        $("#area").append("<option value=''>Pilih Area</option>");
                        for (let i = 0; i < data.length; i++) {

                            $("#area").append("<option value=" + data[i].area_code + ">" + data[i].name + "</option>");
                        }
                        console.log(data);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
                }
            });
        });

        window.onload = function() {
            //Check File API support
            if (window.File && window.FileList && window.FileReader) {
                $('#files').on("change", function(event) {
                    var files = event.target.files; //FileList object
                    var output = document.getElementById("result");

                        var file = files[0];
                        //Only pics
                        // if(!file.type.match('image'))
                        if (file.type.match('image.*')) {
                            if (this.files[0].size < 2097152) {
                                // continue;
                                var picReader = new FileReader();
                                picReader.addEventListener("load", function(event) {
                                    var picFile = event.target;
                                    var div = document.createElement("div");
                                    div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                                        "title='preview image' style='width:50%;'>";
                                    output.insertBefore(div, null);
                                });
                                //Read the image
                                $('#clear, #result').show();
                                picReader.readAsDataURL(file);
                            } else {
                                alert("Foto tidak boleh lebih dari 2MB.");
                                $(this).val("");
                            }
                        } else {
                            alert("Hanya Bisa Upload File Foto.");
                            $(this).val("");
                        }


                });
            } else {
                console.log("Your browser does not support File API");
            }
        }

        $('#files').on("click", function() {
            $('.thumbnail').parent().remove();
            $('result').hide();
            $(this).val("");
        });

        $('#clear').on("click", function() {
            $('.thumbnail').parent().remove();
            $('#result').hide();
            $('#files').val("");
            $(this).hide();
        });
    </script>
    <script>
        $(document).ready(function(){
            $('.select2').select2();
        })
    </script>
@endsection
