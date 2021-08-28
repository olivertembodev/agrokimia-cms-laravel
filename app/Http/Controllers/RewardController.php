<?php

namespace App\Http\Controllers;

use App\RewardProduct;
use App\RewardKios;
use App\Kios;
use App\RewardTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Classes\upload;
use App\Traits\admin_logs;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\Transaksi_Reward;
use DB;

class RewardController extends Controller
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

    public function getindexListProductReward()
    {
        $reward_product = RewardProduct::all();
        return datatables()->of(RewardProduct::latest()->get())
            ->addColumn('action',function ($data){ //m
             $button ='<a href="editproduct-reward/'.$data->id.'">
             <button class="btn btn-xs btn-primary " type="button">
             <span class="btn-label"><i class="fa fa-file"></i></span>
             </button>
             </a>';
             $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
             $button.="&nbsp";
            return $button;
            })
            ->rawColumns(['action'])->make(true);

    }

    public function indexListProductReward()

    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();
        return view('reward.list-product-reward', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function createProductReward()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        return view('reward.addreward-product', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProductReward(Request $request)
    {
        $data = $request->validate([
            'kode_product' => 'required',
            'nama_product' => 'required',
            'stock'        => 'required',
            'deskripsi'    => 'required',
            'image'        => 'max:2048',
            'nominal_reward'      => 'required',
            'expired'      => 'required',
        ]);

        if ($request->file('image')) {
            $upload        = new upload();
            $data['image'] = $upload->img($request->file('image'));
        } else {
            $data['image'] = env('DEFAULT_IMAGE');
        }
        $data['tanggal']    = date('Y-m-d H:i:s');
        $data['created_by'] = Auth::user()->id;

        RewardProduct::create($data);
        admin_logs::addLogs("ADD-001", "Reward Product");
        return redirect()->route('list-product-reward');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reward  $reward
     * @return \Illuminate\Http\Response
     */
    public function show(Reward $reward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reward  $reward
     * @return \Illuminate\Http\Response
     */
    public function editProductReward($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $reward_products = RewardProduct::where('id', $id)->first();
        $data['reward_products'] = $reward_products;

        return view('reward.editreward-product', $data);
    }

    public function updateProductReward(Request $request, RewardProduct $reward_products, $id)
    {
        $data = $request->validate([
            'kode_product' => 'required',
            'nama_product' => 'required',
            'stock'        => 'required',
            'deskripsi'    => 'required',
            'image'        => 'max:2048',
            'nominal_reward'      => 'required',
            'expired'      => 'required',
        ]);

        if ($request->file('image')) {
            $upload        = new upload();
            $data['image'] = $upload->img($request->file('image'));
        }

        RewardProduct::where('id', $id)->update($data);
        admin_logs::addLogs("UPD-002", "Reward Product");
        return redirect()->route('list-product-reward');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reward  $reward
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reward $reward)
    {
        //
    }

    public function deleteProductReward($id)
    {
        RewardProduct::where('id', $id)->delete();
        admin_logs::addLogs("DEL-003", "Reward Product");
        return redirect()->route('list-product-reward');
    }
    //kios
    public function indexListKiosReward()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();
        return view('reward.list-kios-reward', $data);

    }
    //buat fungsi untuk server side nya
    public function getindexKiosReward()
    {

        $data = DB::table('kios')
                    ->select('kios.*', 'reward_products.nominal_reward as reward_poin')
                    ->leftJoin('reward_products', 'reward_products.id', 'kios.id')
                    ->whereNull('kios.deleted_at')
                    ->get();
        $i=0;

        foreach ($data as $row) {
            $data_transaksi = DB::table('transaksi_reward')
                                ->leftJoin('detail_transaksi_reward', 'detail_transaksi_reward.id_transaction_reward', 'transaksi_reward.id')
                                ->leftJoin('reward_products', 'reward_products.id', 'detail_transaksi_reward.id_product_reward')
                                ->where('id_kios', $row->id)
                                ->get();

            if (!empty($data_transaksi)) {
                $penjumlahan = 0;
                 $total_reward = 0;
                foreach ($data_transaksi as $transaksi) {
                    $penjumlahan = $transaksi->jumlah*$transaksi->nominal_reward;
                    $total_reward = $total_reward+$penjumlahan;
                }

                $data[$i]->total_reward = $total_reward;
            }


        $i++;
        }

        return datatables()->of($data)
            ->addColumn('action',function ($data){ //m

            $button ='<a href="detailrewardkios/'.$data->id.'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
            return $button;
            })
            ->rawColumns(['action'])->make(true);

    }

    public function detailrewardkios($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();
        $data['total'] = DB::table('transaksi_reward')
                            ->select(DB::raw("SUM(reward_products.nominal_reward * detail_transaksi_reward.jumlah) as total_reward"), 'transaksi_reward.*', 'status_reward.*')
                            ->leftJoin('detail_transaksi_reward', 'detail_transaksi_reward.id_transaction_reward', 'transaksi_reward.id')
                            ->leftJoin('reward_products', 'reward_products.id', 'detail_transaksi_reward.id_product_reward')
                            ->leftJoin('status_reward', 'status_reward.id', 'transaksi_reward.id_status_transaksi')
                            ->where('id_kios', $id)
                            ->whereNull('transaksi_reward.deleted_at')
                            ->groupBy("transaksi_reward.id")
                            ->groupBy("status_reward.id")
                            ->get();

        $data['data']= DB::table('kios')
        ->where('kios.deleted_at',null)->where('kios.id',$id)
        ->get();

        return view('reward.detail-reward-kios', $data);
    }

    public function FilterStatus($query)
    {
        $data = DB::table('transaksi_reward')
                            ->select(DB::raw("SUM(reward_products.nominal_reward * detail_transaksi_reward.jumlah) as total_reward"), 'transaksi_reward.*', 'status_reward.*')
                            ->leftJoin('detail_transaksi_reward', 'detail_transaksi_reward.id_transaction_reward', 'transaksi_reward.id')
                            ->leftJoin('reward_products', 'reward_products.id', 'detail_transaksi_reward.id_product_reward')
                            ->leftJoin('status_reward', 'status_reward.id', 'transaksi_reward.id_status_transaksi')
                            ->where('status_reward.id', $query)
                            ->whereNull('transaksi_reward.deleted_at')
                            ->groupBy("transaksi_reward.id")
                            ->groupBy("status_reward.id")
                            ->get();
      

        return datatables()->of($data)
            ->make(true);

    }

    public function getindexKiosTransaksiReward(Request $request, $id_kios)
    {
        $usersQuery = Transaksi_Reward::query();
 
        $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
        $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
 
        if($start_date && $end_date){
     
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));
          
        $usersQuery->whereRaw("date(transaksi_reward.tanggal) >= '" . $start_date . "' AND date(transaksi_reward.tanggal) <= '" . $end_date . "'");
        }
         
        $data = $usersQuery
                            ->select(DB::raw("SUM(reward_products.nominal_reward * detail_transaksi_reward.jumlah) as total_reward"), 'transaksi_reward.*', 'status_reward.*')
                            ->leftJoin('detail_transaksi_reward', 'detail_transaksi_reward.id_transaction_reward', 'transaksi_reward.id')
                            ->leftJoin('reward_products', 'reward_products.id', 'detail_transaksi_reward.id_product_reward')
                            ->leftJoin('status_reward', 'status_reward.id', 'transaksi_reward.id_status_transaksi')
                            ->whereNull('transaksi_reward.deleted_at')
                            ->where('id_kios', $id_kios)
                            ->groupBy("transaksi_reward.id")
                            ->groupBy("status_reward.id")
                            ->get();

        return datatables()->of($data)
            ->make(true);

    }

    public function indexListTransaksiReward()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['str'] = DB::table('status_reward')
                            ->whereNull('status_reward.deleted_at')
                            ->get();
                            // dd($data['str']);

        return view('reward.list-transaksi-reward', $data);
    }

    public function FilterStatusTransaksiReward($query)
    {
        $data = DB::table('transaksi_reward')
        ->select(DB::raw("SUM(detail_transaksi_reward.jumlah * reward_products.nominal_reward) as total_reward"), 'transaksi_reward.*', 'status_reward.*', 'reward_products.*', 'kios.*', 'detail_transaksi_reward.*')
        ->leftJoin('status_reward', 'status_reward.id', '=', 'transaksi_reward.id_status_transaksi')
        ->leftJoin('kios', 'kios.id', '=', 'transaksi_reward.id_kios')
        ->leftJoin('detail_transaksi_reward', 'detail_transaksi_reward.id_transaction_reward', '=', 'transaksi_reward.id')
        ->leftJoin('reward_products', 'reward_products.id', '=', 'detail_transaksi_reward.id_product_reward')
        ->whereNull('kios.deleted_at')
        ->where('status_reward.id', $query)
        ->groupBy("status_reward.id")
        ->groupBy("transaksi_reward.id")
        ->groupBy("reward_products.id")
        ->groupBy("kios.id")
        ->groupBy("detail_transaksi_reward.id")
        ->get();

        return datatables()->of($data)
            ->addColumn('action',function ($data){ //m
           
            $button ='<a href="detailrewardtransaksi/'.$data->id.'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
            return $button;
            })
            ->rawColumns(['action'])->make(true);

    }

    public function getindexTransaksiReward(Request $request)
    {
        $usersQuery = Transaksi_Reward::query();
 
        $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
        $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
 
        if($start_date && $end_date){
     
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));
          
        $usersQuery->whereRaw("date(transaksi_reward.tanggal) >= '" . $start_date . "' AND date(transaksi_reward.tanggal) <= '" . $end_date . "'");
        }
         
        $data = $usersQuery
        ->select('detail_transaksi_reward.*','transaksi_reward.*' , 'status_reward.*', 'reward_products.*', 'kios.*')
        ->leftJoin('status_reward', 'status_reward.id', '=', 'transaksi_reward.id_status_transaksi')
        ->leftJoin('kios', 'kios.id', '=', 'transaksi_reward.id_kios')
        ->leftJoin('detail_transaksi_reward', 'detail_transaksi_reward.id_transaction_reward', '=', 'transaksi_reward.id')
        ->leftJoin('reward_products', 'reward_products.id', '=', 'detail_transaksi_reward.id_product_reward')
        ->whereNull('kios.deleted_at')
        ->get();

        $i=0;

        foreach ($data as $row) {
            $data_transaksi = DB::table('transaksi_reward')
                                ->leftJoin('detail_transaksi_reward', 'detail_transaksi_reward.id_transaction_reward', 'transaksi_reward.id')
                                ->leftJoin('reward_products', 'reward_products.id', 'detail_transaksi_reward.id_product_reward')
                                ->where('id_kios', $row->id)
                                ->get();

            if (!empty($data_transaksi)) {
                $penjumlahan = 0;
                $total_reward = 0;
                foreach ($data_transaksi as $transaksi) {
                    $penjumlahan = $transaksi->jumlah*$transaksi->nominal_reward;
                    $total_reward = $total_reward+$penjumlahan;
                }

                $data[$i]->total_reward = $total_reward;
            }


        $i++;
        }

        return datatables()->of($data)
            ->addColumn('action',function ($data){ //m

            $button ='<a href="detailrewardtransaksi/'.$data->id.'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
            return $button;
            })
            ->rawColumns(['action'])->make(true);


    }

    public function detailrewardtransaksi($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();
        $data['data']= DB::table('kios')
        ->select('kios.*', 'transaksi_reward.*', 'status_reward.*', 'detail_transaksi_reward.*')
        ->leftJoin('transaksi_reward', 'transaksi_reward.id_kios', '=', 'kios.id')
        ->leftJoin('status_reward', 'status_reward.id', '=', 'transaksi_reward.id_status_transaksi')
        ->leftJoin('detail_transaksi_reward', 'detail_transaksi_reward.id_transaction_reward', '=', 'transaksi_reward.id')
        ->where('kios.deleted_at',null)->where('kios.id',$id)
        ->get();

        return view('reward.detail-reward-transaksi', $data);
    }

    public function getindexProdukTransaksiReward($id_kios)
    {

        $data = DB::table('reward_products')
                            ->select(DB::raw("SUM(reward_products.nominal_reward * detail_transaksi_reward.jumlah) as total_reward"), 'reward_products.*', 'transaksi_reward.*')
                            ->leftJoin('detail_transaksi_reward', 'detail_transaksi_reward.id_product_reward', 'reward_products.id')
                            ->leftJoin('transaksi_reward', 'transaksi_reward.id', 'detail_transaksi_reward.id_transaction_reward')
                            ->whereNull('reward_products.deleted_at')
                            ->where('transaksi_reward.id_kios', $id_kios)
                            ->groupBy("reward_products.id", "transaksi_reward.id")
                            ->get();

        return datatables()->of($data)
            ->make(true);
    }



}
