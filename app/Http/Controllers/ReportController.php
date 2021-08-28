<?php

namespace App\Http\Controllers;

use App\Dashboard;
use App\Sales;
use App\TipeTask;
use Illuminate\Http\Request;
use DB;
use App\Transaction;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index()
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();
        $data['data'] = DB::table('kios')
                        ->whereNull('deleted_at')
                        ->get();
        $data['datatrans'] = DB::table('transactions')
                                ->whereNull('deleted_at')
                                ->get();


        return view('report.report', $data);
    }

    public function listReport(Request $request){
        $usersQuery = Transaction::query();

        $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
        $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');

        if($start_date && $end_date){

         $start_date = date('Y-m-d', strtotime($start_date));
         $end_date = date('Y-m-d', strtotime($end_date));

         $usersQuery->whereRaw("date(transactions.tanggal) >= '" . $start_date . "' AND date(transactions.tanggal) <= '" . $end_date . "'");
        }
           $data = $usersQuery
            ->select(DB::raw("SUM(products.harga_jual - products.harga_beli) as profit"), 'kios.nama_Kios as nama_Kios', 'products.nama_product as nama_product', 'products.harga_jual as harga_jual', 'products.harga_beli as harga_beli', 'transactions.nominal as nominal', 'transactions.tanggal as tanggal' )
            ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
            ->leftJoin('detail_transaction', 'detail_transaction.id_transaction', '=', 'transactions.id')
            ->leftJoin('products', 'products.id', '=', 'detail_transaction.id_product')
            ->groupBy("kios.nama_Kios")
            ->groupBy("products.nama_product")
            ->groupBy("products.harga_jual")
            ->groupBy("products.harga_beli")
            ->groupBy("transactions.nominal")
            ->groupBy("transactions.tanggal")
            ->whereNull('kios.deleted_at')
            ->whereNull('detail_transaction.deleted_at')
            ->whereNull('products.deleted_at')
            ->get();
            return datatables()->of($data)->make(true);
    }

    public function listReportByNamaKios($query)
    {
        $data = DB::table('transactions')
        ->select(DB::raw("SUM(products.harga_jual - products.harga_beli) as profit"), 'kios.nama_Kios as nama_Kios', 'products.nama_product as nama_product','products.harga_jual as harga_jual', 'products.harga_beli as harga_beli', 'transactions.nominal as nominal', 'transactions.tanggal as tanggal')
        ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
        ->leftJoin('detail_transaction', 'detail_transaction.id_transaction', '=', 'transactions.id')
        ->leftJoin('products', 'products.id', '=', 'detail_transaction.id_product')
        ->groupBy("kios.nama_Kios")
        ->groupBy("products.nama_product")
        ->groupBy("products.harga_jual")
        ->groupBy("products.harga_beli")
        ->groupBy("transactions.nominal")
        ->groupBy("transactions.tanggal")
        ->where('transactions.id_kios', $query)
        ->whereNull('kios.deleted_at')
        ->whereNull('detail_transaction.deleted_at')
        ->whereNull('products.deleted_at')
        ->get();
        return datatables()->of($data)
            ->make(true);

    }
    public function indexsales()
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();
        $data['data'] = DB::table('sales')
                        ->whereNull('deleted_at')
                        ->get();
        $data['datatrans'] = DB::table('transactions')
                                ->whereNull('deleted_at')
                                ->get();


        return view('report.reportsales', $data);
    }
    public function listindexsales()
    {

        $date = Sales::query();

        $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
        $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');

        if($start_date && $end_date){

         $start_date = date('Y-m-d', strtotime($start_date));
         $end_date = date('Y-m-d', strtotime($end_date));

         $date->whereRaw("date(transactions.tanggal) >= '" . $start_date . "' AND date(transactions.tanggal) <= '" . $end_date . "'");
        }
        $data = $date
        ->select(DB::raw("SUM(transactions.total) as total_tran"), 'sales.nama_sales as nama_sales','sales.id')
        ->leftJoin('tasks', 'tasks.id_sales', '=', 'sales.id')
        ->leftJoin('transactions', 'transactions.id', '=', 'tasks.id_transaksi')
        ->groupBy("sales.id")
        ->orderBy('total_tran', 'DESC')
        ->whereNull('sales.deleted_at')
        ->whereNull('transactions.deleted_at')
        ->whereNull('tasks.deleted_at')
        ->get();
        return datatables()->of($data)->addIndexColumn()
            ->addColumn('detail',function ($data) { 
                $button='<a href="'.route("listreport-sales", $data->id).'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';

                return $button;
            })
            ->rawColumns(['detail'])->make(true);
    }
    public function listReportByNamaSales($id)
    {
        $data = DB::table('sales')
        ->select('sales.id', DB::raw("SUM(transactions.total) as total_tran"), 'sales.nama_sales as nama_sales')
        ->leftJoin('tasks', 'tasks.id_sales', '=', 'sales.id')
        ->leftJoin('transactions', 'transactions.id', '=', 'tasks.id_transaksi')
        ->groupBy("sales.nama_sales", "sales.id")
        ->where('sales.id',$id)
        ->orderBy('total_tran', 'DESC')
        ->whereNull('sales.deleted_at')
        ->whereNull('transactions.deleted_at')
        ->whereNull('tasks.deleted_at')
        ->get();

        return datatables()->of($data)->addIndexColumn()
        ->addColumn('detail',function ($data) {
            $button='<a href="'.route("listreport-sales", $data->id).'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';

            return $button;
        })
        ->rawColumns(['detail'])->make(true);
    }
    public function salesdetail($id)
    {
        $tipe_task=TipeTask::all();
        $controller = new Controller;
        $data['menus'] =  $controller->menus();
        $data['nama']=Sales::find($id);
        $i=0;
        foreach($tipe_task as $tipe){
            $detail[]=DB::select(
                "select( SELECT COUNT(tasks.id_sales ) as jumlah_tugas FROM tasks where id_sales = '".$id."' AND  id_tipe_tasks='".$tipe->id."'),
                (SELECT COUNT(tasks.id_sales ) as jumlah_selesai FROM tasks WHERE is_finish=3 AND  id_sales = '".$id."' AND  id_tipe_tasks='".$tipe->id."'),
                (SELECT COUNT(tasks.id_sales ) as jumlah_belum FROM tasks WHERE is_finish=0 AND  id_sales = '".$id."' AND  id_tipe_tasks='".$tipe->id."'),
                (SELECT COUNT(tasks.id_sales ) as batal_admin FROM tasks WHERE is_finish=4 AND  id_sales = '".$id."' AND  id_tipe_tasks='".$tipe->id."'),
                (SELECT COUNT(tasks.id_sales ) as batal_sales FROM tasks WHERE is_finish>4 AND  id_sales = '".$id."' AND  id_tipe_tasks='".$tipe->id."')
                "
            );
        }
        return view('report.detailreport',['detail'=>$detail,'menus'=>$data['menus'],'nama'=>$data['nama']]);
    }
}
