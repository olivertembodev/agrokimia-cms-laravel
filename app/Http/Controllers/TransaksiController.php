<?php

namespace App\Http\Controllers;

use App\Status_transaksi;
use App\Traits\admin_logs;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }
    public function indexTransaksi()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['data'] = Status_transaksi::all();
        $data['trans'] = Transaksi::all();
        return view('transaksi.listtransaksi', $data);
    }
    public function getIndexTransaksi()
    {
        $dataku= DB::table('detail_transaction')
        ->select('detail_transaction.*','transactions.*',
        'kios.nama_Kios as id_kios',
        'tipe_pembayarans.nama_metode as id_tipe_pembayaran','tipe_pengirimans.nama_metode as id_tipe_pengiriman',
        'administrators.name as verified_by','status_transaksis.nama_status as id_status_transaksi'
        )
        ->distinct('transactions.no_invoice')
        ->leftJoin('transactions', 'transactions.id', '=', 'detail_transaction.id_transaction')
        ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
        ->leftJoin('tipe_pembayarans', 'tipe_pembayarans.id', '=', 'transactions.id_tipe_pembayaran')
        ->leftJoin('tipe_pengirimans', 'tipe_pengirimans.id', '=', 'transactions.id_tipe_pengiriman')
        ->leftJoin('administrators', 'administrators.id', '=', 'transactions.verified_by')
        ->leftJoin('status_transaksis', 'status_transaksis.id', '=', 'transactions.id_status_transaksi')
        ->where(function($query) {
            $check_principle=Auth::user()->id_principle;
            if ($check_principle != null) {
                $query->where('products.id_principle',$check_principle);
            }
        })
        ->get();

        return datatables()->of($dataku)
            ->addColumn('action',function ($data) { 
                if (isset($data->id)) {
                    $button='<a href="'.route("transaksi-details",$data->id).'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
                    return $button;
                }
            })->addColumn('c_total', function ($data) {
                if (isset($data->total)) {
                    $c_total = 'Rp. '. number_format($data->total, 0, ",", ".");
                    return $c_total;
                }
            })->addColumn('status',function($data){
                if (isset($data->id) && isset($data->id_status_transaksi)) {
                    $button1='&nbsp'.'<button class="btn btn-xs btn-success" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#status-modal">'.$data->id_status_transaksi.'</button>';
                    return $button1;
                }
            })
            ->rawColumns(['status','action'])->make(true);
    }
    public function updatestatustransaksi(Request $request)
    {
        $id= $request->id;
        $stat=$request->status;
        $transaksi=new Transaksi();
        $transaksi=Transaksi::find($id);
        if($transaksi){
            $transaksi->id_status_transaksi=$stat;
            $transaksi->save();
            
            admin_logs::addLogs("UPD-002","Transaksi");
            return response()->json('success');
        }else{
            return response()->json('gagal');
        }

    }

    public function details($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['transaksis'] = DB::table('detail_transaction')
                                ->select('detail_transaction.*','transactions.*',
                                        'kios.nama_Kios', 'products.nama_product', 'products.harga_jual',
                                        'tipe_pembayarans.nama_metode as id_tipe_pembayaran','tipe_pengirimans.nama_metode as id_tipe_pengiriman',
                                        'administrators.name as verified_by','status_transaksis.nama_status as id_status_transaksi'
                                    )
                                ->leftJoin('transactions', 'transactions.id', '=', 'detail_transaction.id_transaction')
                                ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
                                ->leftJoin('products', 'products.id', '=', 'detail_transaction.id_product')
                                ->leftJoin('tipe_pembayarans', 'tipe_pembayarans.id', '=', 'transactions.id_tipe_pembayaran')
                                ->leftJoin('tipe_pengirimans', 'tipe_pengirimans.id', '=', 'transactions.id_tipe_pengiriman')
                                ->leftJoin('administrators', 'administrators.id', '=', 'transactions.verified_by')
                                ->leftJoin('status_transaksis', 'status_transaksis.id', '=', 'transactions.id_status_transaksi')
                                ->where('transactions.id', $id)
                                ->get();

        return view('transaksi.details', $data);
    }
}
