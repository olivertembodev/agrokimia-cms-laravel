@extends('layouts._layout')

@section('asset')

@endsection

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Informasi</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Informasi</a></li>
                    <li class="breadcrumb-item active">List Informasi</li>
                </ol>
                <button type="button" onclick="location.href='{{ url('/informasi/add-notification') }}'" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Tambah Informasi</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <form id="frm-example" action="{{route('delete-notifications')}}" method="POST">@csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" id="clickdel" class="btn btn-danger d-none d-lg-block m-l-15 delya"><i
                                        class="fa fa-trash">&nbsp;</i>Delete Selected Row</button>
                                </div>
                            </div>
                            
                        
                            <table id="pemberitahuan_table" class="table display table-bordered table-striped no-wrap">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>User</th>
                                        <th>Area</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modalnulti delete monggo disesuaikan --}}
<div class="modal fade" id="multideletemodaconfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Hapus Multiple Informasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data-data yang tercheck ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-ok">Delete</button>
            </div>
        </div>
    </div>
</div>

{{-- akhir modal delete --}}
{{-- modal delete monggo disesuaikan --}}
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Hapus Informasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-ok">Delete</button>
            </div>
        </div>
    </div>
</div>
{{-- akhir modal delete --}}


@endsection

@section('script')
<!-- This is data table -->
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>


<script>
    $(document).ready(function () {

        $(".delete-button").click(function(){
            var id = $(this).attr('deletevalue');
            $("#delete-form").attr('action', '../informasi/delete-notification/deleteNotification/'+id);
            $('#delete-modal').modal();
        });

        $('#confirm-delete').on('click', '.btn-ok', function(e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //$.ajax({url: '/deletekios/' + id, type: 'POST'})
            $.post('/informasi/delete-notification/deleteNotification/' + id).then()
            $modalDiv.addClass('loading');
            setTimeout(function() {
                $modalDiv.modal('hide').removeClass('loading');
                $('#pemberitahuan_table').DataTable().ajax.reload();
            })
        });

        $('#confirm-delete').on('show.bs.modal', function(e) {
            var data = $(e.relatedTarget).data();
            $('.title', this).text(data.recordTitle);
            $('.btn-ok', this).data('recordId', data.recordId);
        });

        var table= $('#pemberitahuan_table').DataTable({
            processing: true,
            serverSide: false,
            searchable: true,
            orderable:false,
            "ajax": "{{ route('list-notification-data') }}",
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            
            columns: [
                {data: 'checkbox', name: 'checkbox',
                render: function (data, type, full, meta){
             return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
         }
         },
                {
                    "data": null,"sortable": false,
                    render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }
                },
                {data: 'judul', name: 'judul'},
                {data: 'user', name: 'user'},
                {data: 'area_name', name: 'area_name'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'waktu', name: 'waktu'},
                {data: 'admin_name', name: 'admin_name'},
                {data: 'action', name: 'action'},
                ],
        });
      
        // Handle click on "Select all" control
            $('#example-select-all').on('click', function(){
                // Check/uncheck all checkboxes in the table
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            // Handle click on checkbox to set state of "Select all" control
            $('#pemberitahuan_table tbody').on('change', 'input[type="checkbox"]', function(){
                // If checkbox is not checked
                if(!this.checked){
                    var el = $('#example-select-all').get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if(el && el.checked && ('indeterminate' in el)){
                        // Set visual state of "Select all" control 
                        // as 'indeterminate'
                        el.indeterminate = true;
                    }
                }
            });
                
        
            $('#clickdel').on('click', function(e){
                // e.preventDefault();
                var form = this;
                // Iterate over all checkboxes in the table
                table.$('input[type="checkbox"]').each(function(){
                    // If checkbox doesn't exist in DOM
                    if(!$.contains(document, this)){
                        // If checkbox is checked
                        if(this.checked){
                            // Create a hidden element 
                            $(form).append(
                                $('<input>')
                                    .attr('type', 'hidden')
                                    .attr('name', this.name)
                                    .val(this.value)
                            );
                        }
                    } 
                });
               
               // sent submit ajax
                // $("#frm-example").ajaxSubmit({url: '/notifikasi/delete-multiple', type: 'post'})
                $.ajax({
                    type: "POST",
                    url: '/notifikasi/delete-multiple',
                    data: form.serialize(), // serializes the form's elements.
                    beforeSend: function (e) {
                    },
                    success: function(data)
                    {
                        $('#pemberitahuan_table').DataTable().ajax.reload();
                    }
                });
                

            });
            // buat referensi
             /*    $('#frm-example').on('submit', function(e){
                e.preventDefault();

                    var form = this;
                    table.$('input[type="checkbox"]').each(function(){
                        // If checkbox doesn't exist in DOM
                        if(!$.contains(document, this)){
                            // If checkbox is checked
                            if(this.checked){
                                // Create a hidden element 
                                $(form).append(
                                    $('<input>')
                                        .attr('type', 'hidden')
                                        .attr('name', this.name)
                                        .val(this.value)
                                );
                            }
                        } 
                    });
                // Iterate over all checkboxes in the table
               
                // $('#multideletemodaconfirm').modal('show');
                // FOR TESTING ONLY
                console.log($(form));
                
                // Output form data to a console
                $('#example-console').text($(form).serialize()); 
                console.log("Form submission", $(form).serialize()); 
                $('#pemberitahuan_table').DataTable().ajax.reload();
                // Prevent actual form submission
            }); */
    });

</script>
@endsection
