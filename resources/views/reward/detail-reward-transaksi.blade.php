@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Detail Transaksi Kios</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-kios-reward')}}">Reward Kios</a></li>
                    <li class="breadcrumb-item active">Detail Transaksi Kios</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <label class="control-label" style="font-weight: bold;">Detail Transaksi</label>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Nama Kios</label>
                        <div>{{$data[0]->nama_Kios}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Alamat</label>
                        <div>{{$data[0]->alamat_kios}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Nama PIC</label>
                        <div>{{$data[0]->nama_pic}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Nomor HP PIC</label>
                        <div>{{$data[0]->nomor_hp_pic}}</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Tanggal Transaksi</label>
                        <div>{{$data[0]->tanggal}}</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <label class="control-label" style="font-weight: bold;">Produk Reward</label>
                </div>
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <input type="hidden" value="{{$data[0]->id_kios}}" id="id_kios">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap mdl-data-table dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Produk</th>
                                    <th>Foto Produk</th>
                                    <th>Nominal Reward</th>
                                    <th>Nama Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <label class="control-label" style="font-weight: bold;">Status Transaksi</label>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">Catatan</label>
                        <div class="control-label" style="font-weight: bold;">{{$data[0]->nama_status}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- This is data table -->
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

<script>
    $('#confirm-delete').on('click', '.btn-ok', function(e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //$.ajax({url: '/deletekios/' + id, type: 'POST'})
            $.post('/deletekios/' + id).then()
            $modalDiv.addClass('loading');
            setTimeout(function() {
                $modalDiv.modal('hide').removeClass('loading');
                $('#config-table').DataTable().ajax.reload();
            })
        });
    $('#confirm-delete').on('show.bs.modal', function(e) {
        var data = $(e.relatedTarget).data();
        $('.title', this).text(data.recordTitle);
        $('.btn-ok', this).data('recordId', data.recordId);
    });

    $(document).ready(function() {
        $('#exp_date').hide();
        $('#labelexp').hide();
        $("#cb_expdate").change(function(){
            if($(this).is(':checked')){
                $('#exp_date').show();
                $('#labelexp').show();
            }else{
                $('#exp_date').hide();
                $('#labelexp').hide();
            }
        });
    });

     $(document).ready(function() {
        id_kios = $("#id_kios").val()
        var i=0;
        var table=$('#config-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "/getproduktransaksireward/"+id_kios,
            columnDefs: [{ 
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
           columns: [
            { 
                "data": null,"sortable": false,
                render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                    }
            },

            {data: 'kode_product', name: 'kode_product'},
            {
                "data": 'image', name: 'image',
                "render": function (data) {
                           return '<img src="' +data+ '" width="100px" height="100px" />';
                       }
            },
            {data: 'total_reward', name: 'total_reward'},
            {data: 'nama_product', name: 'nama_product'},
            ],
        });
    });
     

</script>
@endsection
