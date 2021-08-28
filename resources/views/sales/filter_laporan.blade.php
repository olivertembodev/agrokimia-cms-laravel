<!-- Laporan Tugas -->
<div id="laporan_sales">
<div class="row">
   <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6" style="float: left;">
           <label style="font-weight: bold">Laporan Tugas</label>
        </div>
        <div class="col-md-6 col-xs-6" style="float: right;">
           <a href="javascript:void(0)" class="filter_x">
           <label style="font-weight: bold;float: right;font-size: 11px;color: #00CED1;">filter</label></a>
        </div>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="col-md-6 col-xs-6" style="float: left;">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);text-align: center;">
                    <label style="font-size: 11px;">Sudah Terealisasi</label><br>
                    <label style="color: #90EE90">{{$task_finish}}</label>
                </div>
            </div>
            <div class="col-md-6 col-xs-6" style="float: right;">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);text-align: center;">
                    <label style="font-size: 11px;">Belum Terealisasi</label><br>
                    <label style="color: #FF0000">{{$task_not_finish}}</label>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Laporan Tagihan -->
<div class="row" style="margin-top: 25px;">
   <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6" style="float: left;">
           <label style="font-weight: bold">Laporan Tagihan</label>
        </div>
        <div class="col-md-6 col-xs-6" style="float: right;">
            <a href="javascript:void(0)" class="filter_x">
           <label style="font-weight: bold;float: right;font-size: 11px;color: #00CED1;">filter</label></a>
        </div>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="col-md-6 col-xs-6" style="float: left;">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);text-align: center;">
                    <label style="font-size: 11px;">Terbayarkan</label><br>
                    <label style="color: #90EE90">{{number_format($tagihan_lunas)}}</label>
                </div>
            </div>
            <div class="col-md-6 col-xs-6" style="float: right;">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);text-align: center;">
                    <label style="font-size: 11px;">Belum Terbayarkan</label><br>
                    <label style="color: #FF0000">{{number_format($tagihan_belum_lunas)}}</label>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- grafik tipe tugas -->
<div class="row" style="margin-top: 25px;">
   <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6" style="float: left;">
           <label style="font-weight: bold">Grafik Tipe Tugas</label>
        </div>
        <div class="col-md-6 col-xs-6" style="float: right;">
            <a href="javascript:void(0)" class="filter_x">
           <label style="font-weight: bold;float: right;font-size: 11px;color: #00CED1;">filter</label></a>
        </div>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="col-md-12 col-xs-12">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);text-align: center;">
                    <div class="pieID pie">

                    </div>
                    <br>
                    <ul class="pieID legend" style="width: 70%">
                    @foreach($grafik_tipe_task as $tipe)
                      <li style="width: 100%;text-align: left;">
                        <em>{{$tipe->nama_kode}}</em>
                        <span>{{$tipe->count}}</span>
                      </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Stok dibawa -->
<div class="row" style="margin-top: 25px;">
   <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6" style="float: left;">
           <label style="font-weight: bold">Stok Produk Dibawa</label>
        </div>
        <div class="col-md-6 col-xs-6" style="float: right;">
            <a href="javascript:void(0)" class="filter_x">
           <label style="font-weight: bold;float: right;font-size: 11px;color: #00CED1;">filter</label></a>
        </div>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-md-12 col-xs-12"> 
            <div class="col-md-12 col-xs-12">   
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2)">
                  @if ($barang_dibawa == 0)
                    <label style="font-weight: bold;">Tidak Ada Produk Yang dibawa</label><br>
                  @else
                    <label style="font-weight: bold;">Product</label><br>
                    @foreach($barang_dibawa as $produk)
                    <span>{{$produk['barang']}}</span>
                    <span>({{number_format($produk['nominal'])}})</span>
                    <br>
                    @endforeach
                    <label style="font-weight: bold;">Total : Rp {{number_format($total)}}</label>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>