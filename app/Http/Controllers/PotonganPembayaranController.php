<?php

namespace App\Http\Controllers;

use App\PotongantipePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PotonganPembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();
        return view('master.potongan_pembayaran.index',$data);
    }
    public function nominal($id)
    {
        $data=PotongantipePembayaran::find($id);
        return response()->json($data);
    }
    public function getIndex()
    {

        $kios= DB::table('potongan_tipe_pembayaran')
                    ->select('potongan_tipe_pembayaran.*','tipe_pembayarans.nama_metode as id_tipe_pembayaran')
                    ->leftJoin('tipe_pembayarans', 'tipe_pembayarans.id', '=', 'potongan_tipe_pembayaran.id_tipe_pembayaran')
                    ->where('potongan_tipe_pembayaran.deleted_at',null)
                    ->get();
        foreach($kios as $item){
            $item->nominal="Rp. ". number_format($item->nominal,0,",",".");
        }
        return datatables()->of($kios)
            ->addColumn('action',function ($data){ //m
             $button='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
             $button.="&nbsp";
             $button.='<button class="btn btn-xs btn-success" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#nominal-modal"><span class="btn-label"><i class="fa fa-undo"></i></span></button>';
             $button.="&nbsp";
            return $button;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function add()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['tipe']= DB::table('tipe_pembayarans')
        // ->distinct('areas.name')
        ->select('tipe_pembayarans.*')
        ->whereNotIn('id',DB::table('potongan_tipe_pembayaran')->where('deleted_at',null)->pluck('id_tipe_pembayaran'))
        ->get();
        return view('master.potongan_pembayaran.add',$data);

    }
    public function store(Request $request)
    {
        $request->validate([
            'tipe_pembayaran'=>'required',
            'nominal'=>'required',
        ]);
        $nominal = intval(preg_replace('/\D/', '', $request->nominal));
        $tipe=new PotongantipePembayaran();
        $tipe->id_tipe_pembayaran=$request->tipe_pembayaran;
        $tipe->nominal=$nominal;
        $tipe->is_fill=1;
        $tipe->save();
        return redirect()->route('potongan-tipe-pembayaran');
    }
    public function updatenominal(Request $request)
    {
        $id= $request->id;
        $nominal = intval(preg_replace('/\D/', '', $request->nominal));
        $tipe= new PotongantipePembayaran();
        $tipe=PotongantipePembayaran::find($id);
        $tipe->nominal=$nominal;
        $tipe->save();
    }
    public function deletepotongan($id)
    {
        $tipe= new PotongantipePembayaran();
        $tipe=PotongantipePembayaran::find($id);
        $tipe->delete();
        return redirect()->route('deletepotongantipe');
    }
}
