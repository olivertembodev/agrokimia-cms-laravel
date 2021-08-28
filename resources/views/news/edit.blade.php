@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Berita</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Informasi</a></li>
                    <li class="breadcrumb-item active">Edit Berita</li>
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
                    <form action="{{route('update-news', $news['id'])}}" enctype="multipart/form-data" method="post">@csrf
                        <div class="form-body ">
                            <div class="row p-t-20 p-l-30">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Judul</label>
                                        <input type="text" name="judul" id="nama" class="form-control" value="{{ $news['judul'] }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <!--/row-->
                            <div class="row p-l-30">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kategori Berita</label>
                                        <select class="form-control custom-select" name="id_kategori_berita" required>
                                            @foreach($categories as $category)
                                                @if( $category['id'] == $news['id_kategori_berita'])
                                            <option value="{{ $category['id'] }}" selected>{{ $category['nama_kategori'] }}</option>
                                                @else
                                            <option value="{{ $category['id'] }}">{{ $category['nama_kategori'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row p-l-30">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pilih Tipe User</label>
                                        <select class="form-control custom-select" name="tipe_user" required>
                                            @if ($news['tipe_user'] == 1)
                                                <option value="">Pilih Tipe User</option>
                                                <option value="1" selected>Sales</option>
                                                <option value="2">Kios</option>
                                                <option value="3">Semua</option>
                                            @elseif ($news['tipe_user'] == 2)
                                                <option value="">Pilih Tipe User</option>
                                                <option value="1">Sales</option>
                                                <option value="2" selected>Kios</option>
                                                <option value="3">Semua</option>
                                            @elseif ($news['tipe_user'] == 3)
                                                <option value="">Pilih Tipe User</option>
                                                <option value="1">Sales</option>
                                                <option value="2">Kios</option>
                                                <option value="3" selected>Semua</option>
                                            @else
                                                <option value="" selected>Pilih Tipe User</option>
                                                <option value="1">Sales</option>
                                                <option value="2">Kios</option>
                                                <option value="3">Semua</option>
                                            @endif
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row p-l-30">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Image</label><br>
                                        <input id="icon" class="form-control col-md-8 mb-2" type="file" name="image">
                                        <button class="col-md-2 float-right" type="button" id="clear_logo">Clear</button>
                                        <output class="w-100" id="result_logo">
                                            <div>
                                                <img class="thumbnail_logo" src="{{ $news['image'] }}" title="preview image" style="width: 50%">
                                            </div>
                                        </output>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-l-30">

                                <div class="col-md-8">
                                    <div class="form-group p-1">
                                        <label class="control-label">Deskripsi</label>
                                        <textarea id="deskripsi" class="form-control editor" name="deskripsi" rows="10" cols="50">{{ $news['deskripsi'] }}</textarea>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                        </div>
                        <div class="form-actions p-t-20 p-l-30">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{route('list-news')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
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
@endsection


