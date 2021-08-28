@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Principles Category</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Principles</a></li>
                    <li class="breadcrumb-item active">Edit Principles Category</li>
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
                    <form action="{{route('update-principle-category', $category['id'])}}" method="post" enctype="multipart/form-data" >@csrf
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama</label>
                                        <input type="text" name="name" id="nama" class="form-control" value="{{ $category['name'] }}" placeholder="">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Icon</label><br>
                                        <input id="icon" class="form-control col-md-8 mb-2" type="file" name="icon">
                                        <button class="col-md-2 float-right" type="button" id="clear_logo">Clear</button>
                                        <output class="w-100" id="result_logo">
                                            <div>
                                                <img class="thumbnail_logo" src="{{ $category['icon'] }}" title="preview image" style="width: 50%">
                                            </div>
                                        </output>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control custom-select" name="status">
                                            <option value="">Pilih Status</option>
                                            @if($category['status'] == 1)
                                            <option value="1" selected>Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                            @else
                                            <option value="1" >Aktif</option>
                                            <option value="0" selected>Tidak Aktif</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('principle-category')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
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
