<?php

namespace App\Http\Controllers;

use App\Area;
use App\City;
use App\Classes\upload;
use App\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use GuzzleHttp\Client;

class LaporanSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Jika token firebase tidak null maka kirim ke fcm
    public function crojobs_notifications(){
        $pemberitahuan = DB::table('pemberitahuan')->join('sales','sales.id','=','pemberitahuan.id_user')->whereNull('pemberitahuan.deleted_at')->select('judul','deskripsi','firebase_token')->get();
        //$sales = DB::table('sales')->whereNull('deleted_at')->where('status',1)->get();
        if ($pemberitahuan->isEmpty()) {
            dd("tidak ada pemberi tahuan"); 
        } else {
            foreach ($pemberitahuan as $k => $v) {
                if(!is_null($v->firebase_token)){
                    $messageToFcm = array(
                        "tipe"=>"Notifikasi",
                        "catatan"=>"ada notifikasi baru",
                        "deskripsi"=> "tolong di cek ya !!"
                    );
            
                    try {
                        $push = $this->sendToFcm_notif($v->firebase_token, $messageToFcm);
                        dd($push);
                    } catch (Exception $e) {
                        echo 'Caught exception: '. $e->getMessage() ."\n";
                    }
                }else{
                   dd("mengapa terjadi"); 
                }
            }
        }
        
    }

    public function sendToFcm_notif($reg_id, $payload)
    {
        $URL    = "https://fcm.googleapis.com/fcm/send";
        $KEY    = env("FIREBASE_CREDENTIALS", null);
        $client = new Client;
        $data   = $client->request('POST', $URL, [
            'headers' => array(
                'Authorization' => 'key=' . $KEY,
                'Content-Type'  => 'application/json',
            ),
            'json'    => array(
                'registration_ids' => array($reg_id),
                'data'             => is_object($payload) ? $payload : $payload,
            ),
        ]);
        $result = $data->getBody();
        $res    = json_decode($result);

        return $res;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function laporan($id_sales,$token_sales)
    {
        $id = base64_decode($id_sales);
        $token = base64_decode($token_sales);
        //dd($token);
        
        $cek = Sales::where('id',$id)->where('token',$token)->where('status',1)->whereNull('deleted_at')->get();
        if ($cek->isEmpty()) {
            $data['code'] = 404;
        } else {
            $data['code'] = 200;
            $data['id'] = $id;
            $data['token'] = $token;
            $year = date('Y');
            $bulan_ini = date('m');
            $bulantahun = date('Y-m');
            $data['task_finish'] = DB::table('tasks')->join('sales','sales.id','=','tasks.id_sales')->where('tasks.id_sales',$id)->where('is_finish',3)->where('tasks.date','like', '%'.$bulantahun.'%')->count('tasks.id');
            $data['task_not_finish'] = DB::table('tasks')->join('sales','sales.id','=','tasks.id_sales')->where('tasks.id_sales',$id)->where('is_finish','!=',3)->where('tasks.date','like', '%'.$bulantahun.'%')->count('tasks.id');
            $tagihan_lunas = DB::table('tasks')->leftjoin('tenors','tenors.id','=','tasks.id_tagihan')->where('tenors.date','like', '%'.$bulantahun.'%')->where('tasks.id_sales',$id)->whereIn('tenors.status_lunas',[1, 2])->sum('tenors.nominal');
            $tunggakan_lunas = DB::table('tasks')->leftjoin('loan_arreas','loan_arreas.id','=','tasks.id_tunggakan_tagihan')->where('loan_arreas.date','like', '%'.$bulantahun.'%')->where('tasks.id_sales',$id)->where('loan_arreas.status_lunas',1)->sum('loan_arreas.nominal');
            $data['tagihan_lunas'] = (float)$tagihan_lunas + (float)$tunggakan_lunas;

            $tagihan_belum_lunas = DB::table('tasks')->leftjoin('tenors','tenors.id','=','tasks.id_tagihan')->where('tenors.date','like', '%'.$bulantahun.'%')->where('tasks.id_sales',$id)->where('tenors.status_lunas',0)->sum('tenors.nominal');
            $tunggakan_belum_lunas = DB::table('tasks')->leftjoin('loan_arreas','loan_arreas.id','=','tasks.id_tunggakan_tagihan')->where('loan_arreas.date','like', '%'.$bulantahun.'%')->where('tasks.id_sales',$id)->where('loan_arreas.status_lunas',0)->sum('loan_arreas.nominal');
            $data['tagihan_belum_lunas'] = (float)$tagihan_belum_lunas + (float)$tunggakan_belum_lunas;
            
            $data['grafik_tipe_task'] = DB::table('tasks')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->selectRaw('nama_kode, count(nama_kode)')->where('tasks.date','like', '%'.$bulantahun.'%')->where('tasks.id_sales',$id)->groupBy('nama_kode')->get();
            $data['grafik_tanggal_task'] = DB::table('tasks')->selectRaw('date, count(date)')->groupBy('date')->get();
            // $data['grafik_tipe_task'] = DB::table('tasks')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->groupBy('id_tipe_tasks')->count('tasks.id');
            //dd($data);
            $data_belum_selesai =  DB::table('tasks')->join('sales','sales.id','=','tasks.id_sales')->join('transactions','transactions.id','tasks.id_transaksi')->join('detail_transaction','transactions.id','=','detail_transaction.id_transaction')->join('products','products.id','=','detail_transaction.id_product')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->select('detail_transaction.jumlah as jumlah','nama_product','harga_jual')->where('kode_task',3)->where('tasks.id_sales',$id)->where('is_finish','!=',3)->where('tasks.date','like', '%'.$bulantahun.'%')->get();

            $total = 0;
            if ($data_belum_selesai->isNotEmpty()) {
                foreach ($data_belum_selesai as $k => $v) {
                    $data['barang_dibawa'][] = ["barang"=>$v->nama_product.' - '.$v->jumlah.' Pcs',"nominal"=>$v->harga_jual];
                    $total = ($total + ((int)$v->jumlah * (int)$v->harga_jual));
                }
                $data['total'] = $total;
            } else {
                $data['total'] = 0;
                $data['barang_dibawa'] = 0;
            }
            //dd($data['total']);
        }
        //dd($data);
        return view('sales.laporan', $data);
    }
    // filter laporan
    public function filter_laporan(Request $request)
    {
        $id = $request->id;
        $token = $request->token;
        //dd($token);
        
        $cek = Sales::where('id',$id)->where('token',$token)->where('status',1)->whereNull('deleted_at')->get();
        if ($cek->isEmpty()) {
            $data['code'] = 404;
        } else {
            $data['code'] = 200;
            $data['id'] = $id;
            $data['token'] = $token;
            $from = date($request->start);
            $to = date($request->end);
            $year = date('Y');
            $bulan_ini = date('m');
            $bulantahun = date('Y-m');
            $data['task_finish'] = DB::table('tasks')->join('sales','sales.id','=','tasks.id_sales')->where('tasks.id_sales',$id)->where('is_finish',3)->whereBetween('tasks.date', [$from, $to])->count('tasks.id');
            $data['task_not_finish'] = DB::table('tasks')->join('sales','sales.id','=','tasks.id_sales')->where('tasks.id_sales',$id)->where('is_finish','!=',3)->whereBetween('tasks.date', [$from, $to])->count('tasks.id');
            $tagihan_lunas = DB::table('tasks')->leftjoin('tenors','tenors.id','=','tasks.id_tagihan')->whereBetween('tenors.date', [$from, $to])->where('tasks.id_sales',$id)->whereIn('tenors.status_lunas',[1, 2])->sum('tenors.nominal');
            $tunggakan_lunas = DB::table('tasks')->leftjoin('loan_arreas','loan_arreas.id','=','tasks.id_tunggakan_tagihan')->whereBetween('loan_arreas.date', [$from, $to])->where('tasks.id_sales',$id)->where('loan_arreas.status_lunas',1)->sum('loan_arreas.nominal');
            $data['tagihan_lunas'] = (float)$tagihan_lunas + (float)$tunggakan_lunas;

            $tagihan_belum_lunas = DB::table('tasks')->leftjoin('tenors','tenors.id','=','tasks.id_tagihan')->whereBetween('tenors.date', [$from, $to])->where('tasks.id_sales',$id)->where('tenors.status_lunas',0)->sum('tenors.nominal');
            $tunggakan_belum_lunas = DB::table('tasks')->leftjoin('loan_arreas','loan_arreas.id','=','tasks.id_tunggakan_tagihan')->whereBetween('loan_arreas.date', [$from, $to])->where('tasks.id_sales',$id)->where('loan_arreas.status_lunas',0)->sum('loan_arreas.nominal');
            $data['tagihan_belum_lunas'] = (float)$tagihan_belum_lunas + (float)$tunggakan_belum_lunas;
            
            $data['grafik_tipe_task'] = DB::table('tasks')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->selectRaw('nama_kode, count(nama_kode)')->whereBetween('tasks.date', [$from, $to])->where('tasks.id_sales',$id)->groupBy('nama_kode')->get();
            $data['grafik_tanggal_task'] = DB::table('tasks')->selectRaw('date, count(date)')->groupBy('date')->get();
            // $data['grafik_tipe_task'] = DB::table('tasks')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->groupBy('id_tipe_tasks')->count('tasks.id');
            //dd($data);
            $data_belum_selesai =  DB::table('tasks')->join('sales','sales.id','=','tasks.id_sales')->join('transactions','transactions.id','tasks.id_transaksi')->join('detail_transaction','transactions.id','=','detail_transaction.id_transaction')->join('products','products.id','=','detail_transaction.id_product')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->select('detail_transaction.jumlah as jumlah','nama_product','harga_jual')->where('kode_task',3)->where('tasks.id_sales',$id)->where('is_finish','!=',3)->whereBetween('tasks.date', [$from, $to])->get();

            $total = 0;
            $data['barang_dibawa'] = 0;
            if ($cek->isNotEmpty()) {
                foreach ($data_belum_selesai as $k => $v) {
                     $data['barang_dibawa'][] = ["barang"=>$v->nama_product.' - '.$v->jumlah.' Pcs',"nominal"=>$v->harga_jual];
                    $total = ($total + ((int)$v->jumlah * (int)$v->harga_jual));
                }
                $data['total'] = $total;
            } else {
                $data['total'] = 0;
                $data['barang_dibawa'] = 0;
            }
            //dd($data['total']);
        }
        //dd($data);
        return view('sales.filter_laporan', $data);
    }

     public function tagihanSales($id_sales,$token_sales)
    {
        $id = base64_decode($id_sales);
        $token = base64_decode($token_sales);
        //dd($token);
        
        $cek = Sales::where('id',$id)->where('token',$token)->where('status',1)->whereNull('deleted_at')->get();
        if ($cek->isEmpty()) {
            $data['code'] = 404;
        } else {
            $data['id'] = $id;
            $data['token'] = $token;
            $year = date('Y');
            $bulan_ini = date('m');
            $bulantahun = date('Y-m');
            $data_kios = DB::table('kios')->join('tasks','kios.id','tasks.id_kios')->select('nama_Kios as nama_kios','kios.id as id','image_kios_depan as image','tasks.id_sales as id_sales','nomor_hp_pic as phone','nama_pic as pic','alamat_kios as alamat')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->whereIn('kode_task',[2,4])->whereNull('kios.deleted_at')->where('tasks.id_sales',$id)->distinct('id_kios')->get();
            if ($data_kios->isNotEmpty()) {
                $data['code'] = 200;
                $data['message'] = 'Success';
                $data['data_kios'] = $data_kios;
                foreach ($data['data_kios'] as $k => $v) {
                    if ($v->image == null) {
                        $foto = env('DEFAULT_IMAGE');
                    } else {
                        $foto = $v->image;
                    }
                    $data['data_kios'][$k]->image = $foto;                    
                }
                //return response()->json($data);
            } else {
                $data['code'] = 404;
                $data['message'] = 'data not found';
                //return response()->json($data);
            }
        }
        //dd($data);
        return view('sales.cektagihan', $data);
    }
    public function filterLaporan(Request $request)
    {
        $id = base64_decode($id_sales);
        $token = base64_decode($token_sales);
        //dd($token);
        
        $cek = Sales::where('id',$id)->where('token',$token)->where('status',1)->whereNull('deleted_at')->get();
        if ($cek->isEmpty()) {
            $data['code'] = 404;
        } else {
            $data['code'] = 200;
            $data['id'] = $id;
            $data['token'] = $token;
            $year = date('Y');
            $bulan_ini = date('m');
            $bulantahun = date('Y-m');
            $data['task_finish'] = DB::table('tasks')->join('sales','sales.id','=','tasks.id_sales')->where('tasks.id_sales',$id)->where('is_finish',3)->whereYear('tasks.created_at', '=', $year)->whereMonth('tasks.created_at',$bulan_ini)->count('tasks.id');
            $data['task_not_finish'] = DB::table('tasks')->join('sales','sales.id','=','tasks.id_sales')->where('tasks.id_sales',$id)->where('is_finish','!=',3)->whereYear('tasks.created_at', '=', $year)->whereMonth('tasks.created_at',$bulan_ini)->count('tasks.id');
            $tagihan_lunas = DB::table('tasks')->leftjoin('tenors','tenors.id','=','tasks.id_tagihan')->where('tenors.date','like', '%'.$bulantahun.'%')->where('tasks.id_sales',$id)->whereIn('tenors.status_lunas',[1, 2])->sum('tenors.nominal');
            $tunggakan_lunas = DB::table('tasks')->leftjoin('loan_arreas','loan_arreas.id','=','tasks.id_tunggakan_tagihan')->where('loan_arreas.date','like', '%'.$bulantahun.'%')->where('tasks.id_sales',$id)->where('loan_arreas.status_lunas',1)->sum('loan_arreas.nominal');
            $data['tagihan_lunas'] = (float)$tagihan_lunas + (float)$tunggakan_lunas;

            $tagihan_belum_lunas = DB::table('tasks')->leftjoin('tenors','tenors.id','=','tasks.id_tagihan')->where('tenors.date','like', '%'.$bulantahun.'%')->where('tasks.id_sales',$id)->where('tenors.status_lunas',0)->sum('tenors.nominal');
            $tunggakan_belum_lunas = DB::table('tasks')->leftjoin('loan_arreas','loan_arreas.id','=','tasks.id_tunggakan_tagihan')->where('loan_arreas.date','like', '%'.$bulantahun.'%')->where('tasks.id_sales',$id)->where('loan_arreas.status_lunas',0)->sum('loan_arreas.nominal');
            $data['tagihan_belum_lunas'] = (float)$tagihan_belum_lunas + (float)$tunggakan_belum_lunas;
            
            $data['grafik_tipe_task'] = DB::table('tasks')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->selectRaw('nama_kode, count(nama_kode)')->where('tasks.date','like', '%'.$bulantahun.'%')->groupBy('nama_kode')->get();
            $data['grafik_tanggal_task'] = DB::table('tasks')->selectRaw('date, count(date)')->groupBy('date')->get();
            // $data['grafik_tipe_task'] = DB::table('tasks')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->groupBy('id_tipe_tasks')->count('tasks.id');
            $data_belum_selesai =  DB::table('tasks')->join('sales','sales.id','=','tasks.id_sales')->join('transactions','transactions.id','tasks.id_transaksi')->join('detail_transaction','transactions.id','=','detail_transaction.id_transaction')->join('products','products.id','=','detail_transaction.id_product')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->select('detail_transaction.jumlah as jumlah','nama_product','harga_jual')->where('kode_task',3)->where('tasks.id_sales',$id)->where('is_finish','!=',3)->where('tasks.date','like', '%'.$bulantahun.'%')->get();
            $total = 0;
            foreach ($data_belum_selesai as $k => $v) {
                 $data['barang_dibawa'][] = ["barang"=>$v->nama_product.' - '.$v->jumlah.' Pcs',"nominal"=>$v->harga_jual];
                $total = ($total + ((int)$v->jumlah * (int)$v->harga_jual));
            }
            $data['total'] = $total;
        }
        dd($data);
        return view('sales.laporan', $data);
    }
    // cari kios
    public function cariKios(Request $request)
    {
        //dd(date('Y-m-d',strtotime('-1 day')));
        try {
            $data_kios = DB::table('kios')->join('tasks','kios.id','tasks.id_kios')->select('nama_Kios as nama_kios','kios.id as id_kios','image_kios_depan as image','tasks.id_sales as id_sales')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->where('nama_Kios','ilike', '%' .$request->nama. '%')->where('kode_task',2)->whereNull('kios.deleted_at')->where('tasks.id_sales',$request->id_sales)->distinct('id_kios')->get();
            // dd($articles);
            if ($data_kios->isNotEmpty()) {
                $data['code'] = 200;
                $data['message'] = 'Success';
                $data['data'] = $data_kios;
                foreach ($data['data'] as $k => $v) {
                    if ($v->image == null) {
                        $foto = env('DEFAULT_IMAGE');
                    } else {
                        $foto = $v->image;
                    }
                    $data['data'][$k]->image = $foto;                    
                }
                return response()->json($data);
            } else {
                $data['code'] = 404;
                $data['message'] = 'data not found';
                return response()->json($data);
            }
        } catch (Exception $e) {
            $data['code'] = 500;
            $data['message'] = 'Caught exception: '. $e->getMessage() ."\n";
            return response()->json($data);
        }
    }
    // pilih kios
    public function pilihKios(Request $request)
    {
        //dd(date('Y-m-d',strtotime('-1 day')));
        try {
            $data_kios = DB::table('kios')->join('tasks','kios.id','tasks.id_kios')->join('tipe_tasks','tipe_tasks.id','=','tasks.id_tipe_tasks')->join('tenors','tenors.id','=','tasks.id_tagihan')->join('loans','loans.id','=','tenors.id_loans')->join('transactions','transactions.id','=','loans.id_transaksi')->select('transactions.no_invoice as no_invoice','tenors.id_loans as id_cicilan')->where('tasks.id_kios',$request->id)->where('kode_task',2)->whereNull('kios.deleted_at')->where('tasks.id_sales',$request->id_sales)->distinct('transactions.no_invoice')->get();
            // dd($articles);
            if ($data_kios->isNotEmpty()) {
                $data['code'] = 200;
                $data['message'] = 'Success';
                $data['data'] = $data_kios;
                return response()->json($data);
            } else {
                $data['code'] = 404;
                $data['message'] = 'data not found';
                return response()->json($data);
            }
        } catch (Exception $e) {
            $data['code'] = 500;
            $data['message'] = 'Caught exception: '. $e->getMessage() ."\n";
            return response()->json($data);
        }
    }
    // pilih cicilan
    public function pilihCicilan(Request $request)
    {
        //dd(date('Y-m-d',strtotime('-1 day')));
        try {
            $data['code'] = 200;
            $data['message'] = 'Success';
            $data_tenor = DB::table('tenors')->join('loans','loans.id','=','tenors.id_loans')->select('tenors.status_lunas as status','tenors.nominal as nominal','tenors.no_cicilan as no_cicilan','tenors.date as tanggal','loans.id_transaksi as id_transaksi')->where('tenors.id_loans',$request->id)->orderBy('tenors.no_cicilan','asc')->get()->toArray();
            $data_tunggakan = DB::table('loan_arreas')->join('loans','loans.id','=','loan_arreas.id_loans')->select('loan_arreas.status_lunas as status','loan_arreas.nominal as nominal','loan_arreas.no_cicilan as no_cicilan','loan_arreas.date as tanggal','loans.id_transaksi as id_transaksi')->where('loan_arreas.id_loans',$request->id)->orderBy('loan_arreas.no_cicilan','asc')->get()->toArray();
            //$result = array_merge( $data_tenor, $data_tunggakan);
            $data_kios = DB::table('kios')->join('transactions','kios.id','=','transactions.id_kios')->where('transactions.id',$data_tenor[0]->id_transaksi)->get();
            $tipe_tenor = DB::table('loans')->join('tipe_cicilan','tipe_cicilan.id','=','loans.id_tipe_cicilan')->where('loans.id',$request->id)->select('tipe_cicilan.tipe as tipe','tenor','loans.total as total')->get();
            $total_tenor = DB::table('tenors')->join('loans','loans.id','=','tenors.id_loans')->where('tenors.id_loans',$request->id)->whereIn('tenors.status_lunas',[1,2])->sum('tenors.nominal');
            $total_tunggakan = DB::table('loan_arreas')->join('loans','loans.id','=','loan_arreas.id_loans')->where('loan_arreas.id_loans',$request->id)->where('loan_arreas.status_lunas',1)->sum('loan_arreas.nominal');
            $total_pembayaran = (int)$total_tenor + (int)$total_tunggakan;
            if ($tipe_tenor[0]->tipe == 1) {
                $nama_tenor = 'Hari';
            } elseif ($tipe_tenor[0]->tipe == 2) {
                $nama_tenor = 'Minggu';
            } elseif ($tipe_tenor[0]->tipe == 3) {
                $nama_tenor = 'Bulan';
            } else {
                $nama_tenor = 'Tahun';
            }
            if ($data_kios[0]->image_kios_depan == null) {
                $foto = env('DEFAULT_IMAGE');
            } else {
                $foto = $data_kios[0]->image_kios_depan;
            }
            $data['nama_kios'] = $data_kios[0]->nama_Kios;
            $data['alamat_kios'] = $data_kios[0]->alamat_kios;
            $data['pic'] = $data_kios[0]->nama_pic;
            $data['phone'] = $data_kios[0]->nomor_hp_pic;
            $data['image'] = $foto;
            $data['tempo'] = $tipe_tenor[0]->tenor.' '.$nama_tenor;
            $data['total_pinjaman'] = number_format($tipe_tenor[0]->total);
            $data['total_pembayaran'] = number_format($total_pembayaran);
            foreach ($data_tenor as $k => $v) {
                if ($v->status == 1 || $v->status == 2) {
                    $status = "Lunas";
                } else {
                    $status = "Belum Lunas";
                }
                $bulan = date('d F Y', strtotime($v->tanggal));

                $data['cicilan'][] = ["cicilan_ke"=>'Cicilan ke -'.$v->no_cicilan.' '.$bulan,"nominal"=>number_format($v->nominal),"status"=>$status,"tanggal"=>date('d F Y', strtotime($v->tanggal))];
            }
            foreach ($data_tunggakan as $k => $v) {
                if ($v->status == 1) {
                    $status = "Lunas";
                } else {
                    $status = "Belum Lunas";
                }
                $bulan = date('F', strtotime($v->tanggal));

                $data['cicilan'][] = ["cicilan_ke"=>'Tunggakan ke -'.$v->no_cicilan.' '.$bulan,"nominal"=>number_format($v->nominal),"status"=>$status,"tanggal"=>date('d F Y', strtotime($v->tanggal))];
            }
           
            return response()->json($data);
        } catch (Exception $e) {
            $data['code'] = 500;
            $data['message'] = 'Caught exception: '. $e->getMessage() ."\n";
            return response()->json($data);
        }
    }
    
}
