@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Product Reward</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Reward</a></li>
                    <li class="breadcrumb-item active">Edit Product Reward</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row ">
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
                    <form action="{{route('updateproduct-reward', $reward_products->id)}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-body ">
                            <div class="row p-t-20 p-l-30">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Kode Product</label>
                                        <input type="text" name="kode_product" id="kode_product" class="form-control" value="{{ $reward_products->kode_product }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="control-label">Nama Product</label>
                                            <input type="text" name="nama_product" id="nama_product" class="form-control" value="{{ $reward_products->nama_product }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="control-label">Stock</label>
                                            <input type="number" name="stock" id="stock" class="form-control" value="{{ $reward_products->stock }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="control-label">Deskripsi</label>
                                            <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="" required>{{ $reward_products->deskripsi }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Image</label><br>
                                        <input id="icon" class="form-control col-md-8 mb-2" type="file" name="icon">
                                        <button class="col-md-2 float-right" type="button" id="clear_logo">Clear</button>
                                        <output class="w-100" id="result_logo">
                                            <div>
                                                <img class="thumbnail_logo" src="{{ $reward_products['image'] }}" title="preview image" style="width: 50%">
                                            </div>
                                        </output>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="control-label">Nominal Reward</label>
                                            <input type="number" name="nominal_reward" id="nominal_reward" class="form-control" value="{{ $reward_products->nominal_reward }}" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label class="control-label">Expired</label>
                                            <input type="date" name="expired" id="expired" class="form-control" value="{{ $reward_products->expired }}" placeholder="" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions p-t-20 p-l-30">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('list-product-reward')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
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
