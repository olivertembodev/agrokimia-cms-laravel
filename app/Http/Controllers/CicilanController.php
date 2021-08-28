<?php

namespace App\Http\Controllers;

use App\Cicilan;
use App\Traits\admin_logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CicilanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index()
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        return view('cicilan.cicilan', $data);
    }

    public function getindexCicilan()
    {
        $data = DB::table('transactions')
        ->where('kode_pembayaran', 'CC')
        ->select('transactions.*', 'loans.id as loans_id', 'kios.nama_Kios as id_kios','loans.total as total', 'transactions.created_at as tanggal', 'transactions.no_invoice as no_invoice','loans.status_lunas as status_lunas','loans.status as status', 'loans.aproved_at as aproved_at')
        ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
        ->leftJoin('loans', 'loans.id_transaksi', '=', 'transactions.id')
        ->leftJoin('tenors', 'tenors.id_loans', '=', 'loans.id')
        ->leftJoin('detail_transaction', 'detail_transaction.id_transaction', '=', 'transactions.id')
        ->leftJoin('products', 'products.id', '=', 'detail_transaction.id_product')
        ->leftJoin('tipe_pembayarans', 'tipe_pembayarans.id', '=', 'transactions.id_tipe_pembayaran')
        ->whereNull('loans.deleted_at')
        ->whereNull('tenors.deleted_at')
        ->whereNull('kios.deleted_at')
        ->whereNull('detail_transaction.deleted_at')
        ->whereNull('products.deleted_at')
        ->distinct('loans.id')
        ->get();

        // $data = DB::table('tenors')
        //             ->leftJoin('loans', 'loans.id', 'tenors.id_loans')
        //             ->get();

        // dd($data);

        return datatables()->of($data)
            ->addColumn('action',function ($data){ 
            $button ="&nbsp";
            $button.="&nbsp";
            $button.="&nbsp";
            $button.="&nbsp";
            $button.='<a href="lihat-cicilan/'.$data->id.'" class="btn btn-xs btn-info " type="button"><span class="btn-label"><i class="fa fa-eye"> Lihat</i></span></a> ';
            $button.='<a href="show-cicilan/'.$data->id.'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"> Detail</i></span></a>';
            return $button;
            })
            ->addColumn('status_lunas', function ($data){
                $lunas='<p class="text-danger"'.$data->id.'" ></span>Belum Lunas</p>';
                if($data->status_lunas==1){
                $lunas='<p class="text-success"'.$data->id.'" >Lunas</p>';
                    }
                return $lunas;
                })
            
            ->addColumn('approval', function ($data){
                // $list='<button class="btn btn-xs btn-danger" data-record-id="'.$data->loans_id.'" data-record-title="The first one" data-toggle="modal" data-target="#status-modal"><span class="btn-label"></span>Not Approved</button>';
                if($data->aproved_at==null){
                $list='<button class="btn btn-xs btn-success" data-record-id="'.$data->loans_id.'" data-record-title="The first one" data-toggle="modal" data-target="#status-modal"><span class="btn-label"></span>Approved</button>';
                    } else{
                $list='<p'.$data->loans_id.'" >Approved at </p>'.$data->aproved_at= date('d-m-Y');
                        
                    }
                return $list;
                })
            ->rawColumns(['action','approval','status_lunas'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function show(Cicilan $cicilan, $id)
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['data'] = DB::table('transactions')
            ->where('transactions.id', $id)
            ->select('transactions.*', 'kios.nama_Kios as id_kios', 'tenors.date as date', 'products.nama_product as id_product','tenors.no_invoice as no_invoice','detail_transaction.jumlah as jumlah', 'products.harga_jual as harga', DB::raw("SUM(detail_transaction.jumlah * products.harga_jual) as total"))
            ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
            ->leftJoin('loans', 'loans.id_transaksi', '=', 'transactions.id')
            ->leftJoin('tenors', 'tenors.id_loans', '=', 'loans.id')
            ->leftJoin('detail_transaction', 'detail_transaction.id_transaction', '=', 'transactions.id')
            ->leftJoin('products', 'products.id', '=', 'detail_transaction.id_product')
            ->groupBy("transactions.id","kios.nama_Kios","tenors.date","loans.total","products.nama_product","tenors.no_invoice","detail_transaction.jumlah","products.harga_jual")
            ->whereNull('loans.deleted_at')
            ->whereNull('tenors.deleted_at')
            ->whereNull('kios.deleted_at')
            ->whereNull('detail_transaction.deleted_at')
            ->whereNull('products.deleted_at')
            ->distinct('id_product')->get();

        // dd($data);
        admin_logs::addLogs("DTL-004","Detail Cicilan");
        return view('cicilan.detail', $data);
    }

    public function statusCicilan(Cicilan $cicilan, $id)
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['data'] = DB::table('transactions')
        ->where('transactions.id', $id)
        ->select('transactions.*','loans.status_lunas as status_lunas')
        ->leftJoin('loans', 'loans.id_transaksi', '=', 'transactions.id')
        ->whereNull('loans.deleted_at')
        ->get();

        // dd($data);
        return view('cicilan.statusCicilan', $data);
    }

    public function getlihatCicilan($id)
    {
        $data = DB::table('transactions')
        ->where('transactions.id', $id)
        ->select('transactions.*','loans.*','kios.*','sales.nama_sales as nama_sales','loans.nominal as uang', 'tenors.date as tanggal','loans.status_lunas as status','tenors.status_uang as dibawa')
        ->leftJoin('tasks', 'tasks.id_transaksi', '=', 'transactions.id')
        ->leftJoin('sales', 'sales.id', '=', 'tasks.id_sales')
        ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
        ->leftJoin('loans', 'loans.id_transaksi', '=', 'transactions.id')
        ->leftJoin('tenors', 'tenors.id_loans', '=', 'loans.id')
        ->leftJoin('tipe_cicilan', 'tipe_cicilan.id', '=', 'loans.id_tipe_cicilan')
        ->leftJoin('status_transaksis','status_transaksis.id','loans.id_status_transaksi')
        ->whereNull('loans.deleted_at')
        ->whereNull('tenors.deleted_at')
        ->whereNull('tipe_cicilan.deleted_at')
        ->whereNull('status_transaksis.deleted_at')
        ->whereNull('tasks.deleted_at')
        ->whereNull('sales.deleted_at')
        ->whereNull('kios.deleted_at')
        ->get();

        return datatables()->of($data)->make(true);
    }

    public function lihatCicilan(Cicilan $cicilan, $id)
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['lihat'] = DB::table('transactions')
        ->where('transactions.id', $id)
        ->select('transactions.*','loans.*','kios.*','sales.nama_sales as nama_sales','loans.nominal as uang', 'tenors.date as tanggal','loans.status_lunas as status','tenors.status_uang as dibawa')
        ->leftJoin('tasks', 'tasks.id_transaksi', '=', 'transactions.id')
        ->leftJoin('sales', 'sales.id', '=', 'tasks.id_sales')
        ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
        ->leftJoin('loans', 'loans.id_transaksi', '=', 'transactions.id')
        ->leftJoin('tenors', 'tenors.id_loans', '=', 'loans.id')
        ->leftJoin('tipe_cicilan', 'tipe_cicilan.id', '=', 'loans.id_tipe_cicilan')
        ->leftJoin('status_transaksis','status_transaksis.id','loans.id_status_transaksi')
        ->leftJoin('loan_arreas', 'loan_arreas.id_loans', '=', 'loans.id')
        ->whereNull('loans.deleted_at')
        ->whereNull('tenors.deleted_at')
        ->whereNull('tipe_cicilan.deleted_at')
        ->whereNull('status_transaksis.deleted_at')
        ->whereNull('tasks.deleted_at')
        ->whereNull('sales.deleted_at')
        ->whereNull('kios.deleted_at')
        ->distinct('loans.id')->get();

        // if (!$data['lihat'] || count($data['lihat'])==0){
         
        //     $data['lihat'] = [
        //         'nama_Kios' => '',
        //     ];
        // }

        if ( !$data['lihat'] ) {
            $data['lihat'] = [
                'nama_Kios' => '',
            ];
        }
        // dd($data['lihat']);

        $data['dibayar'] = DB::table('transactions')
        ->select('loan_arreas.nominal as lunas')
        ->where('transactions.id', $id)
        ->Where('loan_arreas.status_lunas', 1)
        ->leftJoin('loans', 'loans.id_transaksi', '=', 'transactions.id')
        ->leftJoin('loan_arreas', 'loan_arreas.id_loans', '=', 'loans.id')
        ->whereNull('transactions.deleted_at')
        ->whereNull('loans.deleted_at')
        ->whereNull('loan_arreas.deleted_at')
        ->get();
        // dd($data['dibayar']);

        $data['belum'] = DB::table('transactions')
        ->select('loan_arreas.nominal as unlunas')
        ->where('transactions.id', '=', $id)
        ->Where('loan_arreas.status_lunas', 0)
        ->leftJoin('loans', 'loans.id_transaksi', '=', 'transactions.id')
        ->leftJoin('loan_arreas', 'loan_arreas.id_loans', '=', 'loans.id')
        ->whereNull('transactions.deleted_at')
        ->whereNull('loans.deleted_at')
        ->whereNull('loan_arreas.deleted_at')
        ->get();

        // dd($data['belum']);
        admin_logs::addLogs("DTL-004","Lihat Cicilan");
        return view('cicilan.lihatCicilan', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();
        
        $data['loans'] = DB::table('loans')
        ->select('loans.*','loans.status_lunas as status_lunas')
        ->leftJoin('transactions', 'transactions.id', '=', 'loans.id_transaksi')->where('transactions.id', $id)
        ->first();
        $data["cicilan"] = Cicilan::all();
        return view('cicilan.editstatus', $data);
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $data = $request->validate([
            'status_lunas' => 'required',
        ]);

        DB::table('loans')
        ->select('loans.*','loans.status as status')
        ->leftJoin('transactions', 'transactions.id', '=', 'loans.id_transaksi')->where('loans.id', $id)->update($data);
        
        admin_logs::addLogs("UPD-002","Cicilan");
        return redirect()->route('list-cicilan');
    }

    public function updatestatusCicilan(Request $request)
    {
        $request->validate([
            'aproved_at' => 'required',
        ]);

        $aproved_at = Cicilan::find($request->id);
        $aproved_at->aproved_at = $request->aproved_at;
        $aproved_at->save();

        // $id= $request->id;
        // $approved_at=$request->approved_at;
        // $approved_at=new Cicilan();
        // $approved_at=Cicilan::find($id);
        // if($approved_at){
        //     $approved_at->approved_at=$approved_at;
        //     $approved_at->save();
        
        //     admin_logs::addLogs("UPD-002","Status Cicilan");
        //     return response()->json('success');
        // }else{
        //     return response()->json('failed');
        // }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cicilan  $cicilan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cicilan $cicilan)
    {
        //
    }
}
