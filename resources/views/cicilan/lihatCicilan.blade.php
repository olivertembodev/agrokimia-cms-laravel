@extends('layouts._layout')

@section('content')
{{-- @php
print_r($lihat);
die();
@endphp --}}
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Lihat Cicilan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('list-cicilan')}}">Cicilan</a></li>
                    <li class="breadcrumb-item active">Lihat Cicilan</li>
                </ol>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>Cicilan ke-</th>
                                    <th>Nama Sales</th>
                                    <th>Jumlah Uang</th>
                                    <th>Tanggal Penarikan</th>
                                    <th>Status</th>
                                    <th>Uang Dibawa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lihat as $data)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{$data->nama_sales }}</td>
                                        <td>
                                            @php
                                                echo"Rp. ". number_format($data->uang,0,",",".");
                                            @endphp
                                        </td>
                                        <td>{{$data->tanggal}}</td>
                                        <td>
                                            @if($data->status === 1)
                                              <p class="text-success"><b>Lunas</b></p>
                                            @elseif($data->status === 0)
                                              <p class="text-danger"><b>Belum Lunas</b></p>
                                            @endif
                                        </td>
                                        <td>
                                            @if($data->dibawa === 0)
                                              <p class="text-warning"><b>Belum Dibayar</b></p>
                                            @elseif($data->dibawa === 1)
                                              <p class="text-success"><b>Dibawa Sales</b></p>
                                            @elseif($data->dibawa === 2)
                                            <p class="text-primary"><b>Dibawa Admin</b></p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card" id="tipe" name="tipe">
        <div class="card-header">
            <label class="control-label" style="font-weight: bold;">Lihat Cicilan</label>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="control-label">Nama Kios</label>
                <div class="control-label" style="font-weight: bold;">
                    @if(empty($lihat[0]->nama_Kios))
                    {{-- <p>{{$lihat[0]['nama_Kios']}}</p> --}}
                  @else
                    <p>{{$lihat[0]->nama_Kios}}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="control-label">Total Cicilan</label>
                <div class="control-label" style="font-weight: bold;">
                    @php
                        echo"Rp. ". number_format($lihat->sum('uang'),0,",",".");
                    @endphp
                </div>
            </div>
        </div>
        <div class="card-body" id="tunggakan" >
            <div class="form-group">
                <label class="control-label">Total Cicilan Lunas</label>
                <div class="control-label" style="font-weight: bold;">
                    @php
                        echo"Rp. ". number_format($dibayar->sum('lunas'),0,",",".");
                    @endphp
                </div>
            </div>
        </div>
        <div class="card-body" >
            <div class="form-group">
                <label class="control-label">Total Cicilan Belum Lunas</label>
                <div class="control-label" style="font-weight: bold;">
                    @php
                        echo"Rp. ". number_format($belum->sum('unlunas'),0,",",".");
                    @endphp
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
{{-- <script>
var jumlah = document.getElementById('jumlah');
jumlah.addEventListener('keyup', function(e) {
    jumlah.value = formatRupiah(this.value, '');
});

$('#tipe').on('change', function (e) {
    $('.hide').hide();
    $('#option-' + e.target.value).show();
    alert(e.target.value)
    if (e.target.value == null) {
    	$('#notunggakan').val(0)
    } else {
    	$('#tunggakan').val(0)
    }
});
</script> --}}
@endsection
