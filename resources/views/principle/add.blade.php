@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Principles</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Principles</a></li>
                    <li class="breadcrumb-item active">Tambah Principles</li>
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
                    <form action="{{route('store-principle')}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama</label>
                                        <input type="text" name="nama_principle" id="nama" class="form-control" value="{{ old('nama_principle') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="text" name="email_principle" id="nik" class="form-control form-control-danger" value="{{ old('email_principle') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control custom-select" name="id_kategori" required>
                                            <option value="">Piliih Kategori</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <input type="text" name="phone_principle" id="phone" class="form-control form-control-danger" value="{{ old('phone_principle') }}" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" placeholder="dd/mm/yyyy" required>
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Logo</label><br>
                                        <input id="icon" class="form-control col-md-8 mb-2" type="file" name="logo">
                                        <button class="col-md-2 float-right" type="button" id="clear_logo">Clear</button>
                                        <output class="w-100" id="result_logo">
                                        </output>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama Pic</label>
                                        <input type="text" name="nama_pic" value="{{ old('nama_pic') }}" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nomor HP PIC</label>
                                        <input type="text" name="nomor_pic" value="{{ old('nomor_pic') }}" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Email Pic</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control" value="" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password" value="{{ old('password_confirmation') }}" class="form-control" value="" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control custom-select" name="status_principle" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Alamat</label>
                                        <textarea type="text" name="alamat_principle" class="form-control" value="{{ old('alamat_principle') }}" id="" rows="3" required></textarea>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <!--/span-->
                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('list-principle')}}" class="btn btn-inverse">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
     //image validation
     window.onload = function() {
            //Check File API support
            if (window.File && window.FileList && window.FileReader) {
                $('#icon').on("change", function(event) {
                    var files = event.target.files; //FileList object
                    var output = document.getElementById("result_logo");

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
                                    div.innerHTML = "<img class='thumbnail_logo' src='" + picFile.result + "'" +
                                        "title='preview image' style='width:50%;'>";
                                    output.insertBefore(div, null);
                                });
                                //Read the image
                                $('#clear_logo, #result_logo').show();
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

        $('#icon').on("click", function() {
            console.log("apa")
            $('.thumbnail_logo').parent().remove();
            $('#result_logo').hide();
            $(this).val("");
        });

        $('#clear_logo').on("click", function() {
            $('.thumbnail_logo').parent().remove();
            $('#result_logo').hide();
            $('#logo').val("");
            $(this).hide();
        });
</script>
@endsection
