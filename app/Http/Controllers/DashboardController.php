<?php

namespace App\Http\Controllers;

use App\Kios;
use App\LoanArrea;
use App\Sales;
use App\Tenor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['running_text'] = DB::table('running_texts')->select('text as text')->first();

        if (!$data['running_text']) {
            $data['running_text'] = [
                'text' => 'Selamat Datang di Aplikasi CMS Agrokimia',
            ];
        }

        $data['total_kios'] = Kios::select('id')->count();

        $data['total_sales'] = Sales::select('id')->count();

        $tenors        = Tenor::pluck('nominal')->count();
        $loan_arreas   = LoanArrea::pluck('nominal')->count();
        $total_tagihan = $tenors + $loan_arreas;

        $loan_dibayar    = LoanArrea::where('status_lunas', 1)->get();
        $tenor_dibayar   = Tenor::whereIn('status_lunas', [1, 2])->get();
        $tagihan_dibayar = $loan_dibayar->count() + $tenor_dibayar->count();
        $cicilan_dibayar = $loan_dibayar->pluck('nominal')->sum() + $tenor_dibayar->pluck('nominal')->sum();

        $loan_belum_dibayar    = LoanArrea::where('status_lunas', 0)->get();
        $tenor_belum_dibayar   = Tenor::where('status_lunas', 0)->get();
        $tagihan_belum_dibayar = $loan_belum_dibayar->count() + $tenor_belum_dibayar->count();
        $cicilan_belum_dibayar = $loan_belum_dibayar->pluck('nominal')->sum() + $tenor_belum_dibayar->pluck('nominal')->sum();

        $data['total_tagihan']         = $total_tagihan;
        $data['tagihan_dibayar']       = $tagihan_dibayar;
        $data['tagihan_belum_dibayar'] = $tagihan_belum_dibayar;

        $data['cicilan_dibayar']       = $cicilan_dibayar;
        $data['cicilan_belum_dibayar'] = $cicilan_belum_dibayar;

        $data['tunai'] = DB::table('transactions')
            ->leftJoin('tipe_pembayarans', 'transactions.id_tipe_pembayaran', 'tipe_pembayarans.id')
            ->where('tipe_pembayarans.kode_pembayaran', 'CA')
            ->whereNull('transactions.deleted_at')
            ->pluck('transactions.nominal')->sum();

        $data['transfer'] = DB::table('transactions')
            ->leftJoin('tipe_pembayarans', 'transactions.id_tipe_pembayaran', 'tipe_pembayarans.id')
            ->where('tipe_pembayarans.kode_pembayaran', 'TF')
            ->whereNull('transactions.deleted_at')
            ->pluck('transactions.nominal')->sum();

        return view('dashboard.dashboard', $data);
    }

    public function getgrafik()
    {
        $data['count'] = DB::table('transactions')
            ->select(DB::raw("SUM(products.harga_jual - products.harga_beli) as jumlahprofit"), 'kios.nama_Kios as namaKios')
            ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
            ->leftJoin('detail_transaction', 'detail_transaction.id_transaction', '=', 'transactions.id')
            ->leftJoin('products', 'products.id', '=', 'detail_transaction.id_product')
            ->groupBy("kios.nama_Kios")
            ->orderBy('jumlahprofit', 'DESC')
            ->whereNull('kios.deleted_at')
            ->whereNull('detail_transaction.deleted_at')
            ->whereNull('products.deleted_at')
            ->get();

        if (count($data['count']) <= 0) {
            $ct[] = [
                'namaKios'     => 'Saat ini tidak ada pendaftaran baru',
                'jumlahprofit' => 0,
            ];
            return response()
                ->json($ct);
        }

        return response()
            ->json($data['count']);
    }

    public function getgrafik2()
    {
        $data['counts'] = DB::table('transactions')
            ->select(DB::raw("SUM(transactions.total) as jumlahpembelian"), 'kios.nama_Kios as kios_name')
            ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
            ->groupBy('kios.nama_Kios')
            ->orderBy('jumlahpembelian', 'DESC')
            ->whereNull('kios.deleted_at')
            ->whereNull('transactions.deleted_at')
            ->get();

        if (count($data['counts']) <= 0) {
            $ct[] = [
                'kios_name'       => 'Saat ini tidak ada pendaftaran baru',
                'jumlahpembelian' => 0,
            ];
            return response()
                ->json($ct);
        }

        return response()
            ->json($data['counts']);
    }

    public function getindexDS()
    {
        $data = DB::table('transactions')
            ->select(DB::raw("SUM(products.harga_jual - products.harga_beli) as total"), 'kios.nama_Kios as nama_Kios')
            ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
            ->leftJoin('detail_transaction', 'detail_transaction.id_transaction', '=', 'transactions.id')
            ->leftJoin('products', 'products.id', '=', 'detail_transaction.id_product')
            ->groupBy("kios.nama_Kios")
            ->orderBy('total', 'DESC')
            ->whereNull('kios.deleted_at')
            ->whereNull('transactions.deleted_at')
            ->whereNull('detail_transaction.deleted_at')
            ->whereNull('products.deleted_at')
            ->get();

        if (empty($data)) {
            $data[] = [
                'nama_Kios' => 'No Data',
                'total'     => 0,
            ];
        }
        return datatables()->of($data)->make(true);
    }

    public function getindexDS2()
    {
        $data = DB::table('transactions')
            ->select(DB::raw("SUM(transactions.total) as totals"), 'kios.nama_Kios as nama_kioss')
            ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
            ->groupBy('kios.nama_Kios')
            ->orderBy('totals', 'DESC')
            ->whereNull('kios.deleted_at')
            ->whereNull('transactions.deleted_at')
            ->get();

        if (empty($data)) {
            $data[] = [
                'nama_kioss' => 'No Data',
                'totals'     => 0,
            ];
        }

        return datatables()->of($data)->make(true);
    }

    public function getindexDS3()
    {
        $data = DB::table('transactions')
            ->select(DB::raw("SUM(products.harga_jual - products.harga_beli) as total_profit"), 'kios.nama_Kios as nama_kios2')
            ->leftJoin('kios', 'kios.id', '=', 'transactions.id_kios')
            ->leftJoin('detail_transaction', 'detail_transaction.id_transaction', '=', 'transactions.id')
            ->leftJoin('products', 'products.id', '=', 'detail_transaction.id_product')
            ->groupBy("kios.nama_Kios")
            ->orderBy('total_profit', 'DESC')
            ->whereNull('kios.deleted_at')
            ->whereNull('transactions.deleted_at')
            ->whereNull('detail_transaction.deleted_at')
            ->whereNull('products.deleted_at')
            ->get();

        if (empty($data)) {
            $data[] = [
                'nama_kios2'   => 'No Data',
                'total_profit' => 0,
            ];
        }

        return datatables()->of($data)->make(true);
    }

    public function getindexDS4()
    {
        $data = DB::table('sales')
            ->select(DB::raw("SUM(transactions.total) as total_tran"), 'sales.nama_sales as nama_sales')
            ->leftJoin('tasks', 'tasks.id_sales', '=', 'sales.id')
            ->leftJoin('transactions', 'transactions.id', '=', 'tasks.id_transaksi')
            ->groupBy("sales.nama_sales")
            ->whereNull('sales.deleted_at')
            ->whereNull('transactions.deleted_at')
            ->whereNull('tasks.deleted_at')
            ->get();

        if (empty($data)) {
            $data[] = [
                'nama_sales' => 'No Data',
                'total_tran' => 0,
            ];
        }

        return datatables()->of($data)->make(true);
    }

    public function getMapKios()
    {
        $data = DB::table('kios')
            ->select('latitude', 'longitude', 'nama_Kios')
            ->whereNull('kios.deleted_at')
            ->get();
        // dd($data['maps']);

        $json = json_decode($data, true);
        if (empty($json)) {

            $locations[] = [
                'name'      => 'Kios ALFa BeTa Zeta',
                'latitude'  => -7.013685,
                'longitude' => 112.278593,
            ];
        }

        foreach ($data as $key => $value) {
            $locations[] = [
                'name'      => $value->nama_Kios,
                'latitude'  => $value->latitude,
                'longitude' => $value->longitude,
            ];
        }
        return response()
            ->json($locations);
    }

    public function getMapSales()
    {
        $data = DB::table('sales')
            ->select('nama_sales', 'firebase_token')
            ->whereNull('sales.deleted_at')
            ->get();

        return response()
            ->json($data);
    }
}
