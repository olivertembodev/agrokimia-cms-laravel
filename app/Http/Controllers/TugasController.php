<?php

namespace App\Http\Controllers;

use App\Area;
use App\City;
use App\Kios;
use App\Loan;
use App\LoanArrea;
use App\Sales;
use App\Task;
use App\Tenor;
use App\TipeTask;
use App\Traits\admin_logs;
use App\Transaction;
use Auth;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function sendToFcm($reg_id, $payload)
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

    public function listTugas()
    {
        $controller      = new Controller;
        $data['menus']   = $controller->menus();
        $data['cities']  = City::all();
        $data['areas']   = Area::distinct('area_code')->get();
        $data['saleses'] = Sales::all();

        return view('tugas.listTugas', $data);
    }

    public function unsigned_task_count()
    {

        $data['count'] = Task::where('is_verified', 0)->count();
        $data['list'] = Task::with('kioss','saless','tipe_tasks')->where('is_verified', 0)->orderBy('date', 'DESC')->take(5)->get();

        return response()->json($data);
    }

    public function getTaskLists(Request $request)
    {
        $city        = ($request->city) ? $request->city : null;
        $area        = $request->area;
        $sales       = ($request->sales) ? $request->sales : null;
        $datefrom    = ($request->datefrom) ? $request->datefrom : null;
        $dateto      = ($request->dateto) ? $request->dateto : null;
        $statustugas = ($request->statustugas) ? $request->statustugas : null;

        $taskall = DB::table('tasks AS t')
            ->select('t.id', 't.is_finish', 'ttask.nama_kode as nama_tugas', 'city.name AS nama_kota', 'ar.name AS nama_area',
                'k.nama_Kios as nama_kios', 's.nama_sales', 't.date as tanggal')
            ->leftJoin('tipe_tasks as ttask', 'ttask.id', '=', 't.id_tipe_tasks')
            ->leftJoin('cities as city', 'city.id', '=', 't.id_kota')
            ->leftJoin('areas as ar', 'ar.id', '=', 't.id_area')
            ->leftJoin('kios as k', 'k.id', '=', 't.id_kios')
            ->leftJoin('sales as s', 's.id', '=', 't.id_sales')
            ->whereNull('t.deleted_at')
            ->whereNull('ttask.deleted_at')
            ->whereNull('city.deleted_at')
            ->whereNull('ar.deleted_at')
            ->whereNull('k.deleted_at')
            ->whereNull('s.deleted_at')
            ->where('t.is_verified', '=', 1)
            ->orderBy('t.updated_at', 'DESC')
            ->where(function ($q) use ($city, $area, $sales, $datefrom, $dateto, $statustugas) {
                try {
                    if (($area != null) && ($city != null) && ($sales != null) && ($datefrom != null) && ($dateto != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                        $q->whereDate('date', '>=', $datefrom);
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    }
                    //Penta
                    elseif (($city != null) && ($area != null) && ($sales != null) && ($datefrom != null) && ($dateto != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                        $q->whereDate('date', '>=', $datefrom);
                        $q->whereDate('date', '<=', $dateto);
                    } elseif (($city != null) && ($sales != null) && ($datefrom != null) && ($dateto != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                        $q->whereDate('date', '>=', $datefrom);
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($city != null) && ($area != null) && ($datefrom != null) && ($dateto != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->whereDate('date', '>=', $datefrom);
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($city != null) && ($area != null) && ($sales != null) && ($dateto != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($city != null) && ($area != null) && ($sales != null) && ($datefrom != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->whereDate('date', '>=', $datefrom);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    }
                    // 4
                    elseif (($city != null) && ($area != null) && ($sales != null) && ($datefrom != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                        $q->whereDate('date', '>=', $datefrom);
                    } elseif (($area != null) && ($city != null) && ($sales != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($area != null) && ($city != null) && ($dateto != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($city != null) && ($datefrom != null) && ($dateto != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->whereDate('date', '>=', $datefrom);
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($sales != null) && ($datefrom != null) && ($dateto != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->whereDate('date', '>=', $datefrom);
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    }
                    // 3
                    elseif (($city != null) && ($area != null) && ($sales != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                    } elseif (($city != null) && ($area != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($city != null) && ($dateto != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($datefrom != null) && ($dateto != null) && ($statustugas != null)) {
                        $q->whereDate('date', '>=', $datefrom);
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($sales != null) && ($datefrom != null) && ($dateto != null)) {
                        $q->whereDate('date', '>=', $datefrom);
                        $q->whereDate('date', '<=', $dateto);
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                    } elseif (($area != null) && ($sales != null) && ($datefrom != null)) {
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->whereDate('date', '>=', $datefrom);
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                    } elseif (($area != null) && ($sales != null) && ($datefrom != null)) {
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->whereDate('date', '>=', $datefrom);
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                    }
                    // 2
                    elseif (($city != null) && ($datefrom != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->whereDate('date', '>=', $datefrom);
                    } elseif (($city != null) && ($dateto != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->whereDate('date', '<=', $dateto);
                    } elseif (($city != null) && ($statustugas != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($city != null) && ($sales != null)) {
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                    } elseif (($area != null) && ($city != null)) {
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->where('t.id_kota', 'like', '%' . $city . '%');
                    } elseif (($area != null) && ($sales != null)) {
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->where('t.id_sales', 'like', '%' . $sales . '%');
                    } elseif (($area != null) && ($datefrom != null)) {
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->whereDate('date', '>=', $datefrom);
                    } elseif (($area != null) && ($dateto != null)) {
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->whereDate('date', '<=', $dateto);
                    } elseif (($area != null) && ($dateto != null)) {
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->whereDate('date', '<=', $dateto);
                    } elseif (($area != null) && ($statustugas != null)) {
                        $q->where('t.id_area', 'like', '%' . $area . '%');
                        $q->where('is_finish', 'like', '%' . $statustugas . '%');
                    } elseif (($datefrom != null) && ($dateto != null)) {
                        $q->whereDate('date', '>=', $datefrom);
                        $q->whereDate('date', '<=', $dateto);
                    } else {
                        if ($sales != null) {
                            $q->where('t.id_sales', 'like', '%' . $sales . '%');
                        } elseif ($area != null) {
                            $q->where('t.id_area', 'like', '%' . $area . '%');
                        } elseif ($city != null) {
                            $q->where('t.id_kota', 'like', '%' . $city . '%');
                        } elseif ($datefrom != null) {
                            $q->whereDate('date', '>=', $datefrom);
                        } elseif ($dateto != null) {
                            $q->whereDate('date', '<=', $dateto);
                        } elseif ($statustugas != null) {
                            $q->where('is_finish', $statustugas);
                        }
                    }
                } catch (Exception $e) {
                    echo 'Caught exception: ', $e->getMessage(), "\n";
                }

            })->get();

        //dd($taskall);
        $data = datatables()->of($taskall)
            ->addColumn('status', function ($data) {
                //m

                $status = $data->is_finish;
                $str    = '';
                if ($status == 0) {
                    $str = 'Belum Terealisasi';
                } elseif ($status == 1) {
                    $str = "Sedang Dalam Perjalanan";
                } elseif ($status == 2) {
                    $str = "Perjalanan Selesai";
                } elseif ($status == 3) {
                    $str = "Tugas Selesai";
                } elseif ($status == 4) {
                    $str = "Dibatalkan Admin";
                } else {
                    $str = "Dibatalkan Sales";
                }
                return $str;
            })
            ->addColumn('statusbutton', function ($data) {
                //m
                $tombol = '<button class="btn btn-xs btn-warning" data-record-id="' . $data->id . '" data-record-title="Status" data-toggle="modal" data-target="#confirm-status"><span class="btn-label">Ubah status</span></button>';
                $tombol .= "&nbsp";
                return $tombol;
            })
            ->addColumn('action', function ($data) {
                //m
                $button = '<a href="/tugas/edit-tugas/' . $data->id . '">
                    <button class="btn btn-xs btn-primary " type="button">
                    <span class="btn-label"><i class="fa fa-file"></i></span>
                    </button>
                    </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button .= "&nbsp";
                $button .='<a href='.route("download-tugas",$data->id).' class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-arrow-alt-circle-down"></i></span></a>'.'&nbsp';
                return $button;
            })
            ->rawColumns(['status', 'statusbutton', 'action'])->make(true);

        return $data;
    }
    public function downloadtugas($id)
    {
        $path='https://akn.s3-id-jkt-1.kilatstorage.id/';
        $data=DB::table('tasks')->select('document1', 'document2', 'document3')
        ->where('id',$id)
        ->get();
        $filename = $data[0]->document1;
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy('https://akn.s3-id-jkt-1.kilatstorage.id/'.$data[0]->document1, $tempImage);
        return response()->download($tempImage, $filename);
    }

    /* public function getTaskList($sales=NULL,$city=NULL,$area=NULL)
    {
    $taskall = DB::table('tasks AS t')
    ->select('t.id','t.is_finish','ttask.nama_kode as nama_tugas','city.name AS nama_kota','ar.name AS nama_area',
    'k.nama_Kios as nama_kios','s.nama_sales','t.date as tanggal')
    ->leftJoin('tipe_tasks as ttask', 'ttask.id', '=', 't.id_tipe_tasks')
    ->leftJoin('cities as city', 'city.id', '=', 't.id_kota')
    ->leftJoin('areas as ar', 'ar.id', '=', 't.id_area')
    ->leftJoin('kios as k', 'k.id', '=', 't.id_kios')
    ->leftJoin('sales as s', 's.id', '=', 't.id_sales')
    ->whereNull('t.deleted_at')
    ->whereNull('ttask.deleted_at')
    ->whereNull('city.deleted_at')
    ->whereNull('ar.deleted_at')
    ->whereNull('k.deleted_at')
    ->whereNull('s.deleted_at')
    ->where(function($q)use ($city, $area, $sales){
    if(($area!=null)&& ($city!=null) &&($sales !=null))
    {
    $q->where('t.id_kota', 'like', '%' . $city. '%');
    $q->where('t.id_area', 'like', '%' . $area. '%');
    $q->where('t.id_sales', 'like', '%' . $sales. '%');

    }elseif(($city!=null) && ($area!=null)){
    $q->where('t.id_kota', 'like', '%' . $city. '%');
    $q->where('t.id_area', 'like', '%' . $area. '%');
    }
    elseif(($area!=null)&&($sales !=null)){
    $q->where('t.id_area', 'like', '%' . $area. '%');
    $q->where('t.id_sales', 'like', '%' . $sales. '%');

    }
    elseif($area!=null){
    $q->where('t.id_area', 'like', '%' . $area. '%');
    }else{
    if($sales!=null)
    {
    $q->where('t.id_sales', 'like', '%' . $sales. '%');
    }
    }

    })->get();

    //dd($taskall);
    $data = datatables()->of($taskall)
    ->addColumn('status',function ($data){ //m

    $status = $data->is_finish;
    $str = '';
    if($status==0){
    $str='Belum Terealisasi';
    }elseif($status==1){
    $str="Sedang Dalam Perjalanan";
    }elseif($status==2){
    $str="Perjalanan Selesai";
    }elseif($status==3){
    $str="Tugas Selesai";
    }elseif($status==4){
    $str="Dibatalkan Admin";
    }else{
    $str="Dibatalkan Sales";
    }
    return $str;
    })
    ->addColumn('statusbutton',function ($data){ //m

    $tombol='<button class="btn btn-xs btn-warning" data-record-id="'.$data->id.'" data-record-title="Status" data-toggle="modal" data-target="#confirm-status"><span class="btn-label">Ubah status</span></button>';
    $tombol.="&nbsp";
    return $tombol;
    })
    ->addColumn('action',function ($data){ //m
    $button ='<a href="/tugas/edit-tugas/'.$data->id.'">
    <button class="btn btn-xs btn-primary " type="button">
    <span class="btn-label"><i class="fa fa-file"></i></span>
    </button>
    </a>';
    $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
    $button.="&nbsp";
    return $button;
    })
    ->rawColumns(['status','statusbutton','action'])->make(true);

    return $data;
    } */

    

    public function getTaskListToday()
    {
        /* $records = DB::table('users')->select(DB::raw('*'))
        ->whereRaw('Date(created_at) = CURDATE()')->get();
        dd($record); */
        $taskall = DB::table('tasks AS t')
        ->select('t.id','t.is_finish','ttask.nama_kode as nama_tugas','city.name AS nama_kota','ar.name AS nama_area',
            'k.nama_Kios as nama_kios','s.nama_sales','t.date as tanggal','t.id_share_lock')
        ->leftJoin('tipe_tasks as ttask', 'ttask.id', '=', 't.id_tipe_tasks')
        ->leftJoin('cities as city', 'city.id', '=', 't.id_kota')
        ->leftJoin('areas as ar', 'ar.id', '=', 't.id_area')
        ->leftJoin('kios as k', 'k.id', '=', 't.id_kios')
        ->leftJoin('sales as s', 's.id', '=', 't.id_sales')
        ->whereNull('t.deleted_at')
        ->whereNull('ttask.deleted_at')
        ->whereNull('city.deleted_at')
        ->whereNull('ar.deleted_at')
        ->whereNull('k.deleted_at')
        ->whereNull('s.deleted_at')
        ->whereDay('t.date', '=', date('d'))
        ->get();

       // dd($taskall);
        $data = datatables()->of($taskall)
            ->addColumn('status',function ($data){ //m

                $status = $data->is_finish;
                $str = '';
                if($status==0){
                    $str='Belum Terealisasi';
                }elseif($status==1){
                    $str="Sedang Dalam Perjalanan";
                }elseif($status==2){
                    $str="Perjalanan Selesai";
                }elseif($status==3){
                    $str="Tugas Selesai";
                }elseif($status==4){
                    $str="Dibatalkan Admin";
                }else{
                    $str="Dibatalkan Sales";
                }
                return $str;
            })
            ->addColumn('statusbutton',function ($data){ //m

                $tombol='<button class="btn btn-xs btn-warning" data-record-id="'.$data->id.'" data-record-title="Status" data-toggle="modal" data-target="#confirm-status"><span class="btn-label">Ubah status</span></button>';
                $tombol.="&nbsp";
                return $tombol;
            })
            ->addColumn('action',function ($data){ //m
                $button ='<a href="/tugas/edit-tugas/'.$data->id.'">
                    <button class="btn btn-xs btn-primary " type="button">
                    <span class="btn-label"><i class="fa fa-file"></i></span>
                    </button>
                    </a>';
                $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button.="&nbsp";
                return $button;
            })
            ->addColumn('tracking',function ($data){ //m
             
                $button='<button class="btn btn-xs btn-info" data-record-id="'.$data->id_share_lock.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-tracking"><span class="btn-label"> Track &nbsp<i class="fa fa-map"></i></span></button>';
                $button.="&nbsp";
                return $button;
            })
            ->rawColumns(['status','statusbutton','action','tracking'])->make(true);

            return $data;
    }

    


    public function getTaskListUnsigned()
    {
        /* $records = DB::table('users')->select(DB::raw('*'))
        ->whereRaw('Date(created_at) = CURDATE()')->get();
        dd($record); */
        $taskall = DB::table('tasks AS t')
            ->select('t.id', 't.is_finish', 't.is_verified','loans.is_verified as loansverif', 'ttask.nama_kode as nama_tugas','ttask.kode_task', 'city.name AS nama_kota', 'ar.name AS nama_area',
                'k.nama_Kios as nama_kios', 's.nama_sales', 't.date as tanggal')
            ->leftJoin('tipe_tasks as ttask', 'ttask.id', '=', 't.id_tipe_tasks')
            ->leftJoin('cities as city', 'city.id', '=', 't.id_kota')
            ->leftJoin('areas as ar', 'ar.id', '=', 't.id_area')
            ->leftJoin('kios as k', 'k.id', '=', 't.id_kios')
            ->leftJoin('sales as s', 's.id', '=', 't.id_sales')
            ->leftJoin('loans',function($join){
                $join->on('loans.id','=','t.id_transaksi')->where('ttask.kode_task',2);
            })
            ->whereNull('t.deleted_at')
            ->whereNull('ttask.deleted_at')
            ->whereNull('city.deleted_at')
            ->whereNull('ar.deleted_at')
            ->whereNull('k.deleted_at')
            ->whereNull('s.deleted_at')
            ->where('t.is_verified', '=', 0)
            ->get();
        // dd($taskall);

        // dd($taskall);
        $data = datatables()->of($taskall)
            ->addColumn('approval', function ($data) {
                //m
                if($data->kode_task == 2 && $data->loansverif == 0){
                    $na = '<p>Pengajuan cicilan blm di approve.</p>';
                    $na .= "&nbsp";
                    return $na;
                }

                    $tombol = '<button class="btn btn-xs btn-primary" data-record-id="' . $data->id . '" data-record-title="Status" data-toggle="modal" data-target="#confirm-approve"><span class="btn-label">Approved</span></button>';
                    $tombol .= "&nbsp";
                    return $tombol;
            })
            ->addColumn('status', function ($data) {
                //m

                $status = $data->is_finish;
                $str    = '';
                if ($status == 0) {
                    $str = 'Belum Terealisasi';
                } elseif ($status == 1) {
                    $str = "Sedang Dalam Perjalanan";
                } elseif ($status == 2) {
                    $str = "Perjalanan Selesai";
                } elseif ($status == 3) {
                    $str = "Tugas Selesai";
                } elseif ($status == 4) {
                    $str = "Dibatalkan Admin";
                } else {
                    $str = "Dibatalkan Sales";
                }
                return $str;
            })
            ->addColumn('statusbutton', function ($data) {
                //m

                $tombol = '<button class="btn btn-xs btn-warning" data-record-id="' . $data->id . '" data-record-title="Status" data-toggle="modal" data-target="#confirm-status"><span class="btn-label">Ubah status</span></button>';
                $tombol .= "&nbsp";
                return $tombol;
            })
            ->addColumn('action', function ($data) {
                //m
                $button = '<a href="/tugas/edit-tugas/' . $data->id . '">
                    <button class="btn btn-xs btn-primary " type="button">
                    <span class="btn-label"><i class="fa fa-file"></i></span>
                    </button>
                    </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button .= "&nbsp";
                return $button;
            })
            ->rawColumns(['approval', 'status', 'statusbutton', 'action'])->make(true);

        return $data;
    }

    public function addTugas()
    {
        $data['tipe_tasks'] = TipeTask::distinct('nama_kode')->get();
        $data['cities']     = City::all();
        // $data['areas'] = Area::all();
        // $data['kioses']    = Kios::all();
        $data['transaksi'] = Transaction::all();
        $controller        = new Controller;
        $data['menus']     = $controller->menus();
        //dd($data['invoc']);
        return view('tugas.addTugas', $data);
    }

    public function listArea($city)
    {
        $area = Area::select('area_code', 'name')->distinct()->where("city_code", $city)->get();
        //dd($city);

        admin_logs::addLogs("DTL-004", "Tugas Detail Area");
        return response()->json($area);
    }

    public function listSales($area)
    {
        $sales = Sales::select('id', 'nama_sales as name')->where("id_area", $area)->get();
        //dd($city);

        admin_logs::addLogs("DTL-004", "Tugas Detail Sales");
        return response()->json($sales);
    }

    public function listKios($area)
    {
        $kios = Kios::select('id', 'nama_Kios as name')->where("id_area", $area)->get();
        //dd($city);

        admin_logs::addLogs("DTL-004", "Tugas Detail kios");
        return response()->json($kios);
    }

    public function noInvoiceTagihan($idloan){
        $noinvoiceTagihan = DB::table('tenors')
        ->select('tenors.id as idTenor','tenors.no_invoice', 'tenors.no_cicilan')
        ->leftJoin('loans', 'loans.id', '=', 'tenors.id_loans')
        ->whereNull('tenors.deleted_at')
        ->whereNull('loans.deleted_at')
        ->where("tenors.id_loans", $idloan)
        ->get();

        return response()->json($noinvoiceTagihan);
    }


    public function listTagihan($kios){
        $tagihan = DB::table('transactions AS tran')
        ->select('lo.id as idLoan','tran.no_invoice as invoice', 'tippem.kode_pembayaran')
        ->leftJoin('loans as lo', 'lo.id_transaksi', '=', 'tran.id')
        ->leftJoin('tipe_pembayarans as tippem', 'tippem.id', '=', 'tran.id_tipe_pembayaran')
        ->whereNull('tippem.deleted_at')
        ->whereNull('tran.deleted_at')
        ->where("tippem.kode_pembayaran", "CC")
        ->where("tran.id_kios", $kios)
        ->get();
       // DB::select('id','no_invoice as invoice')->where("id_kios", $kios)->get();

        admin_logs::addLogs("DTL-004","Tugas Detail Tagihan");
        return response()->json($tagihan);
    }


    public function listTableTagihan($idTenor){
        $detailtagihan = DB::table('tenors')
        ->select('tenors.no_invoice','tenors.nominal','tenors.date','tenors.no_cicilan','tenors.status_lunas')
        ->leftJoin('loans', 'loans.id', '=', 'tenors.id_loans')
        ->whereNull('tenors.deleted_at')
        ->whereNull('loans.deleted_at')
        ->where("tenors.id", $idTenor)
        ->get();

        admin_logs::addLogs("DTL-004","Tugas Table Tagihan");
        return response()->json($detailtagihan);
    }


    public function listTransaksi($kios)
    {
        $transaksi = Transaction::select('id', 'no_invoice as invoice')->where("id_kios", $kios)->get();
        //dd($city);
        return response()->json($transaksi);
    }

    public function listTableTransaksi($idtran)
    {

        $detailtransaksi = DB::table('detail_transaction AS dettran')
            ->select('pro.nama_product', 'dettran.jumlah', 'pro.harga_jual')
            ->leftJoin('transactions AS tran', 'tran.id', '=', 'dettran.id_transaction')
            ->leftJoin('products as pro', 'pro.id', '=', 'dettran.id_product')
            ->whereNull('dettran.deleted_at')
            ->whereNull('tran.deleted_at')
            ->whereNull('pro.deleted_at')
            ->where("dettran.id_transaction", $idtran)
            ->get();

        admin_logs::addLogs("DTL-004", "Tugas Table Transaksi");
        return response()->json($detailtransaksi);
    }

    public function listTagihanTunggakan($kios)
    {
        $tag = DB::table('loans as lo')
            ->select('loar.id as id_tugg', 'loar.no_invoice as invoice', 'loar.kode_status_cicilan')
            ->leftJoin('transactions as tran', 'tran.id', '=', 'lo.id_transaksi')
            ->leftJoin('loan_arreas as loar', 'loar.id_loans', '=', 'lo.id')
            ->whereNull('loar.deleted_at')
            ->whereNull('lo.deleted_at')
            ->whereNull('tran.deleted_at')
            ->where('tran.id_kios', $kios)
            ->get();
        // dd($tag);

        // DB::select('id','no_invoice as invoice')->where("id_kios", $kios)->get();

        admin_logs::addLogs("DTL-004", "Tugas Tagihan Tunggakan");
        return response()->json($tag);
    }

    // Tagihan Tunggakan

    // public function listTableTagihanTunggakan($idtagtung)
    // {

    //     $detailtagtung = DB::table('loan_arreas AS loar')
    //         ->select('loar.no_invoice', 'loar.nominal', 'loar.date', 'loar.no_cicilan', 'loar.status_lunas')
    //         ->leftJoin('loans', 'loans.id', '=', 'loar.id_loans')
    //         ->whereNull('loar.deleted_at')
    //         ->whereNull('loans.deleted_at')
    //         ->where("loar.id", $idtagtung)
    //         ->get();

    //     admin_logs::addLogs("DTL-004", "Table Tagihan Tunggakan");
    //     return response()->json($detailtagtung);
    // }

    public function storeTask(Request $request)
    {
        //dd($request);
        $request->validate([
            'tipe_task' => 'required',
            'city_code' => 'required',
            'area_code' => 'required',
            'sales' => 'required',
            'kios' => 'required',
            'catatan' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
        ]);
        // dd($request);

        $idTipeTask = TipeTask::where('kode_task', $request->tipe_task)->get();
        $idkota = City::select('id')->where('city_code', $request->city_code)->get();
        $idarea = Area::select('id')->where('area_code', $request->area_code)->get();

        $tokenfirebaseofsales = Sales::select('firebase_token')->where("id", $request->sales)->get();
        //dd($tokenfirebaseofsales[0]->firebase_token);
        // jika request punya TAGIHAN ID
        if( $request->input('tagihan') && $request->input('transaksi')){
            // dd($request);
            // simpan id tenor di column tagihan
            // saat tipenya penagihan yang disimpan di table task column id_tagihan adalah id Tenor
            // $idTran = Loan::select('id')->where('id_', $request->transaksi)->get();
            $idTenor = Tenor::select('id')->where('id_loans', $request->transaksi)->get();
            // dd($idTran[0]->id_transaksi);
            // $request transaksi adalah id Loan
           $idLoan = $request->transaksi;

            $idtask = DB::table('tasks')->insertGetId(
                [ 'id_tipe_tasks' => $idTipeTask[0]->id,'id_admin'=>Auth::user()->id ,'id_sales'=>$request->sales,'id_kios'=>$request->kios,
                'id_transaksi'=> $idLoan,'id_tagihan'=> $request->tagihan,'catatan'=>$request->catatan,'is_finish'=>0,'deskripsi'=>$request->deskripsi,
                'id_kota'=> $idkota[0]->id,'id_area'=>$idarea[0]->id,'date'=>$request->tanggal,'is_running'=>0,'verified_by'=>Auth::user()->id,'is_verified'=>1,
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );

            $insertToUserNotif = [
                ['id_user' => $request->kios,
                'tipe_user' => 1,
                'created_by'=> Auth::user()->id,
                'is_view' => 0,
                'id_detail' => $idtask,
                'tipe_page' => 1,
                'page' => 1,
                'created_at'=>date('Y-m-d H:m:s'),
                'updated_at'=>date('Y-m-d H:m:s')
                ],
                ['id_user' => $request->sales,
                'tipe_user' => 2,
                'created_by'=> Auth::user()->id,
                'is_view' => 0,
                'id_detail' => $idtask,
                'tipe_page' => 1,
                'page' => 1,
                'created_at'=>date('Y-m-d H:m:s'),
                'updated_at'=>date('Y-m-d H:m:s')
                ]
            ];
            
            DB::table('user_notifications')->insert($insertToUserNotif);

            DB::table('log_tasks')->insert(
                ['id_task' => $idtask, 'date' => $request->tanggal,'updated_by'=>Auth::user()->id,'is_admin'=>1,'deskripsi'=>"create new task from CMS",
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );

        }elseif($request->input('transaksi')){
            $idtask = DB::table('tasks')->insertGetId(
                [ 'id_tipe_tasks' => $idTipeTask[0]->id,'id_admin'=>Auth::user()->id ,'id_sales'=>$request->sales,'id_kios'=>$request->kios,
                'id_transaksi'=> $request->transaksi,'catatan'=>$request->catatan,'is_finish'=>0,'deskripsi'=>$request->deskripsi,
                'id_kota'=> $idkota[0]->id,'id_area'=>$idarea[0]->id,'date'=>$request->tanggal,'is_running'=>0,'verified_by'=>Auth::user()->id,'is_verified'=>1,
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );
            $insertToUserNotif = [
                ['id_user' => $request->kios,
                'tipe_user' => 1,
                'created_by'=> Auth::user()->id,
                'is_view' => 0,
                'id_detail' => $idtask,
                'tipe_page' => 1,
                'page' => 1,
                'created_at'=>date('Y-m-d H:m:s'),
                'updated_at'=>date('Y-m-d H:m:s')
                ],
                ['id_user' => $request->sales,
                'tipe_user' => 2,
                'created_by'=> Auth::user()->id,
                'is_view' => 0,
                'id_detail' => $idtask,
                'tipe_page' => 1,
                'page' => 1,
                'created_at'=>date('Y-m-d H:m:s'),
                'updated_at'=>date('Y-m-d H:m:s')
                ]
            ];
            
            DB::table('user_notifications')->insert($insertToUserNotif);

            DB::table('log_tasks')->insert(
                ['id_task' => $idtask, 'date' => $request->tanggal,'updated_by'=>Auth::user()->id,'is_admin'=>1,'deskripsi'=>"create new task from CMS",
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );
        }
        // elseif($request->input('tagtung')){
        //     $idLoan = LoanArrea::select('id_loans')->where('id', '=', $request->tagtung)->get();
        //     $idTran =  Loan::select('id_transaksi')->where('id', $idLoan[0]->id_loans)->get();

        //     $idtask = DB::table('tasks')->insertGetId(
        //         [ 'id_tipe_tasks' => $idTipeTask[0]->id,'id_admin'=>Auth::user()->id ,'id_sales'=>$request->sales,'id_kios'=>$request->kios,
        //         'id_transaksi'=> $idTran[0]->id_transaksi,'id_tagihan'=> $idLoan[0]->id_loans,'catatan'=>$request->catatan,'is_finish'=>0,'deskripsi'=>$request->deskripsi,
        //         'id_kota'=> $idkota[0]->id,'id_area'=>$idarea[0]->id,'date'=>$request->tanggal,'is_running'=>0,'verified_by'=>Auth::user()->id,'is_verified'=>1,
        //         'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s'),'id_tunggakan_tagihan'=> $request->tagtung
        //         ]
        //     );

        //     DB::table('log_tasks')->insert(
        //         ['id_task' => $idtask, 'date' => $request->tanggal,'updated_by'=>Auth::user()->id,'is_admin'=>1,'deskripsi'=>"create new task from CMS",
        //         'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
        //         ]
        //     );
        // }
        else{

            $idtask = DB::table('tasks')->insertGetId(
                [ 'id_tipe_tasks' => $idTipeTask[0]->id,'id_admin'=>Auth::user()->id ,'id_sales'=>$request->sales,'id_kios'=>$request->kios,
                'catatan'=>$request->catatan,'is_finish'=>0,'deskripsi'=>$request->deskripsi,
                'id_kota'=> $idkota[0]->id,'id_area'=>$idarea[0]->id,'date'=>$request->tanggal,'is_running'=>0,'verified_by'=>Auth::user()->id,'is_verified'=>1,
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );

             $insertToUserNotif = [
                ['id_user' => $request->kios,
                'tipe_user' => 1,
                'created_by'=> Auth::user()->id,
                'is_view' => 0,
                'id_detail' => $idtask,
                'tipe_page' => 1,
                'page' => 1,
                'created_at'=>date('Y-m-d H:m:s'),
                'updated_at'=>date('Y-m-d H:m:s')
                ],
                ['id_user' => $request->sales,
                'tipe_user' => 2,
                'created_by'=> Auth::user()->id,
                'is_view' => 0,
                'id_detail' => $idtask,
                'tipe_page' => 1,
                'page' => 1,
                'created_at'=>date('Y-m-d H:m:s'),
                'updated_at'=>date('Y-m-d H:m:s')
                ]
            ];
            
            DB::table('user_notifications')->insert($insertToUserNotif);

            DB::table('log_tasks')->insert(
                ['id_task' => $idtask, 'date' => $request->tanggal,'updated_by'=>Auth::user()->id,'is_admin'=>1,'deskripsi'=>"create new task from CMS",
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );
        }

         // Sent to FCM

        // Jika token firebase tidak null maka kirim ke fcm
        if(!is_null($tokenfirebaseofsales[0]->firebase_token)){
            $messageToFcm = array(
                "tipe"=>"TUGAS",
                "catatan"=>$request->catatan,
                "deskripsi"=> $request->deskripsi
            );
    
            try {
                $this->sendToFcm($tokenfirebaseofsales[0]->firebase_token, $messageToFcm);
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }
        }else{
            
        }

        admin_logs::addLogs("ADD-001","Tugas");
        return redirect()->route('list-tugas');
    }



    public function totalInv($noinvoice)
    {
        $loan = DB::table('loans')->where('no_invoice', $noinvoice)->sum('total');
        //dd($city);
        return response()->json($loan);
    }

    public function totalTransaction($noinvoice)
    {
        $transaksi = DB::table('transactions')->where('no_invoice', $noinvoice)->sum('total');
        //dd($city);
        return response()->json($transaksi);
    }

    public function deleteTugas($id)
    {
        $data = Task::find($id);
        $data->delete();

        DB::table('user_notifications')->where('id_detail', $id)->delete();

        $message = "Delete Task with id : " . $id;

        $dblog = DB::table('log_tasks')->insert(
            ['id_task'   => $id, 'date'                       => date('Y-m-d H:m:s'), 'updated_by' => Auth::user()->id, 'is_admin' => 1, 'deskripsi' => $message,
                'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s'),
            ]
        );

        admin_logs::addLogs("DEL-003", "Tugas");
        return redirect()->route('list-tugas');
    }
    public function changeStatusTugas($id, $nostastus)
    {
        $status = (int) $nostastus;
        $str    = '';
        if ($status == 0) {
            $str = 'Belum Terealisasi';
        } elseif ($status == 1) {
            $str = "Sedang Dalam Perjalanan";
        } elseif ($status == 2) {
            $str = "Perjalanan Selesai";
        } elseif ($status == 3) {
            $str = "Tugas Selesai";
        } elseif ($status == 4) {
            $str = "Dibatalkan Admin";
        } else {
            $str = "Dibatalkan Sales";
        }
        $message = "Change status Tugas to " . $str . " " . "no : ." . $nostastus . "  from CMS";

        $dblog = DB::table('log_tasks')->insert(
            ['id_task'   => $id, 'date'                       => date('Y-m-d H:m:s'), 'updated_by' => Auth::user()->id, 'is_admin' => 1, 'deskripsi' => $message,
                'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s'),
            ]
        );
        //dd($dblog);
        DB::table('tasks')
            ->where('id', $id)
            ->update(['is_finish' => (int) $nostastus, 'updated_at' => date('Y-m-d H:m:s')]);

        admin_logs::addLogs("UPD-002", "Status Tugas");
        return redirect()->route('list-tugas');
    }
    public function changeStatusApprove($id)
    {
        $message = "Aprrove Task with id : " . $id;
        $dblog   = DB::table('log_tasks')->insert(
            ['id_task'   => $id, 'date'                       => date('Y-m-d H:m:s'), 'updated_by' => Auth::user()->id, 'is_admin' => 1, 'deskripsi' => $message,
                'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s'),
            ]
        );
        DB::table('tasks')
            ->where('id', $id)
            ->update(['is_verified' => 1]);

        admin_logs::addLogs("UPD-002", "Status Approve Tugas");
        return redirect()->route('list-tugas');
    }

    public function editTugas($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data["task"] = Task::find($id);
        $data["tipe_tasks"] = TipeTask::distinct('nama_kode')->get();
        $data["cities"] = City::all();
        $data["areas"] = Area::all();
        $data["sales"] = Sales::find($data["task"]->id_sales);
        $data['kioses'] = Kios::all();
        // dd($data);
        // $data['checktagihantunggakan'] = DB::table('loan_arreas as loar')->select('loar.id as id_tugg')
        //             ->where('loar.id_loans',$data['task']->id_tagihan)
        //             ->get();

        if($data["task"]->id_tagihan==null && $data["task"]->id_transaksi==null){
            // if verivikasi or othrs

        }elseif($data["task"]->id_tagihan==null){
            // if pengiriman
            $data['transactions'] = Transaction::select('id','no_invoice as invoice')->where("id_kios",  $data['task']->id_kios)->get();
            $data['detailtransaksi'] = DB::table('detail_transaction AS dettran')
                ->select('pro.nama_product','dettran.jumlah','pro.harga_jual')
                ->leftJoin('transactions AS tran', 'tran.id', '=', 'dettran.id_transaction')
                ->leftJoin('products as pro', 'pro.id', '=', 'dettran.id_product')
                ->whereNull('dettran.deleted_at')
                ->whereNull('tran.deleted_at')
                ->whereNull('pro.deleted_at')
                ->where("dettran.id_transaction", $data['task']->id_transaksi)
                ->get();

        }
        // for tagihan tunggakan
        // elseif(($data["task"]->id_tagihan!=null) && ($data["task"]->id_transaksi!=null) && ($data['task']->id_tunggakan_tagihan != null)){
        //     // Untuk Task dengan tipe Tagihan TUnggakan
        //        // echo $data['checktagihantunggakan'];
        //        // dd($data['checktagihantunggakan']);
        //        $data['tagihantunggakan'] = DB::table('loans as lo')
        //        ->select('loar.id as id_tugg','loar.no_invoice as invoice', 'loar.kode_status_cicilan')
        //        ->leftJoin('transactions as tran', 'tran.id', '=', 'lo.id_transaksi')
        //        ->leftJoin('loan_arreas as loar', 'loar.id_loans', '=', 'lo.id')
        //        ->whereNull('loar.deleted_at')
        //        ->whereNull('lo.deleted_at')
        //        ->whereNull('tran.deleted_at')
        //        ->where('tran.id_kios',$data['task']->id_kios)
        //        ->get();
        //         $data['detailtagihantunggakan'] = DB::table('loan_arreas AS loar')
        //         ->select('loar.no_invoice','loar.nominal','loar.date','loar.no_cicilan','loar.status_lunas')
        //         ->leftJoin('loans', 'loans.id', '=', 'loar.id_loans')
        //         ->whereNull('loar.deleted_at')
        //         ->whereNull('loans.deleted_at')
        //         ->where("loar.id",$data['task']->id_tunggakan_tagihan )
        //         ->get();
        // }
        else{

                // if tagihan
                // transaksi diisi dengan tagihan
                // ID transaksi adalah id loan, id Tagihan adalah id Tenors
                $data['transact'] =  DB::table('transactions AS tran')
                ->select('lo.id as idLoan','tran.no_invoice as invoice', 'tippem.kode_pembayaran')
                ->leftJoin('loans as lo', 'lo.id_transaksi', '=', 'tran.id')
                ->leftJoin('tipe_pembayarans as tippem', 'tippem.id', '=', 'tran.id_tipe_pembayaran')
                ->whereNull('tippem.deleted_at')
                ->whereNull('tran.deleted_at')
                ->where("tippem.kode_pembayaran", "CC")
                ->where("tran.id_kios", $data['task']->id_kios)
                ->get();
                $data['tagihan'] = DB::table('tenors')
                ->select('tenors.id as idTenor','tenors.no_invoice', 'tenors.no_cicilan')
                ->leftJoin('loans', 'loans.id', '=', 'tenors.id_loans')
                ->whereNull('tenors.deleted_at')
                ->whereNull('loans.deleted_at')
                ->where("tenors.id_loans", $data['task']->id_transaksi)
                ->get();
                // dd($data);
                // $data['tagihan'] = DB::table('transactions AS tran')
                // ->select('lo.id as idtran','tran.no_invoice as invoice', 'tippem.kode_pembayaran','lo.id_transaksi')
                // ->leftJoin('loans as lo', 'lo.id_transaksi', '=', 'tran.id')
                // ->leftJoin('tipe_pembayarans as tippem', 'tippem.id', '=', 'tran.id_tipe_pembayaran')
                // ->whereNull('tippem.deleted_at')
                // ->whereNull('tran.deleted_at')
                // ->where("tran.id_kios", $data['task']->id_kios)
                // ->where("tippem.kode_pembayaran", "2")
                // ->get();

                // $dataloans = Loan::select('id')->where('id_transaksi', $data['task']->id_transaksi)->get();
                $data['detailtagihan'] = DB::table('tenors')
                ->select('tenors.no_invoice','tenors.nominal','tenors.date','tenors.no_cicilan','tenors.status_lunas')
                ->leftJoin('loans', 'loans.id', '=', 'tenors.id_loans')
                ->whereNull('tenors.deleted_at')
                ->whereNull('loans.deleted_at')
                ->where("tenors.id", $data['task']->id_tagihan)
                ->get();
                // dd($data);


        }
        //dd($data);
        //dd($data['task']->id_tipe_tasks);

        return view('tugas.editTugas', $data);
    }


    public function UpdateTugas(Request $request){
        // dd($request);
        $request->validate([
            'id_task' => 'required',
            'tipe_tasks' => 'required',
            'city_code' => 'required',
            'area_code' => 'required',
            'sales' => 'required',
            'kios' => 'required',
            'catatan' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
        ]);
        // dd($request);

        $idTipeTask = TipeTask::where('kode_task', $request->tipe_tasks)->get();
        $idkota = City::select('id')->where('city_code', $request->city_code)->get();
        $idarea = Area::select('id')->where('area_code', $request->area_code)->get();

        // jika request punya TAGIHAN ID
        if( $request->input('tagihan')  && $request->input('transaksi')){
            // simpan id tenor di column tagihan
            // $idTenor = Tenor::select('id')->where('id_loans', $request->tagihan)->get();
            // $idTran = Loan::select('id_transaksi')->where('id', $request->tagihan)->get();

             // simpan id tenor di column tagihan
            // saat tipenya penagihan yang disimpan di table task column id_tagihan adalah id Tenor
            // $idTran = Loan::select('id')->where('id_', $request->transaksi)->get();
            $idTenor = Tenor::select('id')->where('id_loans', $request->transaksi)->get();
            // dd($idTran[0]->id_transaksi);
            // $request transaksi adalah id Loan
            // dd($idTenor);
            $idLoan = $request->transaksi;

             DB::table('tasks')
             ->where('id', $request->id_task)
             ->update(
                [ 'id_tipe_tasks' => $idTipeTask[0]->id,'id_admin'=>Auth::user()->id ,'id_sales'=>$request->sales,'id_kios'=>$request->kios,
                'id_transaksi'=> $idLoan,'id_tagihan'=> $request->tagihan,'catatan'=>$request->catatan,'is_finish'=>0,'deskripsi'=>$request->deskripsi,
                'id_kota'=> $idkota[0]->id,'id_area'=>$idarea[0]->id,'date'=>$request->tanggal,'is_running'=>0,'verified_by'=>Auth::user()->id,'is_verified'=>1,
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );

            DB::table('log_tasks')->insert(
                ['id_task' =>  $request->id_task, 'date' => $request->tanggal,'updated_by'=>Auth::user()->id,'is_admin'=>1,'deskripsi'=>"update new task from CMS ",
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );

        }elseif($request->input('transaksi')){
             DB::table('tasks')
             ->where('id', $request->id_task)
             ->update(
                [ 'id_tipe_tasks' => $idTipeTask[0]->id,'id_admin'=>Auth::user()->id ,'id_sales'=>$request->sales,'id_kios'=>$request->kios,
                'id_transaksi'=> $request->transaksi,'catatan'=>$request->catatan,'is_finish'=>0,'deskripsi'=>$request->deskripsi,
                'id_kota'=> $idkota[0]->id,'id_area'=>$idarea[0]->id,'date'=>$request->tanggal,'is_running'=>0,'verified_by'=>Auth::user()->id,'is_verified'=>1,
                'updated_at'=>date('Y-m-d H:m:s')
                ]
            );

            DB::table('log_tasks')->insert(
                ['id_task' => $request->id_task, 'date' => $request->tanggal,'updated_by'=>Auth::user()->id,'is_admin'=>1,'deskripsi'=>"update new task from CMS",
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );
        }
        // elseif($request->input('tagtung')){
        //     // Get dataTask to get id_transaksi and id_tagihan
        //     $dataTask = Task::find($request->id_task);

        //     // get id
        //     DB::table('tasks')
        //     ->where('id', $request->id_task)
        //     ->update(
        //         [ 'id_tipe_tasks' => $idTipeTask[0]->id,'id_admin'=>Auth::user()->id ,'id_sales'=>$request->sales,'id_kios'=>$request->kios,
        //         'id_transaksi'=> $dataTask->id_transaksi,'id_tagihan'=> $dataTask->id_tagihan,'catatan'=>$request->catatan,'is_finish'=>0,'deskripsi'=>$request->deskripsi,
        //         'id_kota'=> $idkota[0]->id,'id_area'=>$idarea[0]->id,'date'=>$request->tanggal,'is_running'=>0,'verified_by'=>Auth::user()->id,'is_verified'=>1,
        //         'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s'),'id_tunggakan_tagihan'=> $request->tagtung
        //         ]
        //     );

        //     DB::table('log_tasks')->insert(
        //         ['id_task' =>  $request->id_task, 'date' => $request->tanggal,'updated_by'=>Auth::user()->id,'is_admin'=>1,'deskripsi'=>"update new task from CMS",
        //         'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
        //         ]
        //     );
        // }
        else{

             DB::table('tasks')
                ->where('id', $request->id_task)
             ->update(
                [ 'id_tipe_tasks' => $idTipeTask[0]->id,'id_admin'=>Auth::user()->id ,'id_sales'=>$request->sales,'id_kios'=>$request->kios,
                'catatan'=>$request->catatan,'is_finish'=>0,'deskripsi'=>$request->deskripsi,
                'id_kota'=> $idkota[0]->id,'id_area'=>$idarea[0]->id,'date'=>$request->tanggal,'is_running'=>0,'verified_by'=>Auth::user()->id,'is_verified'=>1,
                'updated_at'=>date('Y-m-d H:m:s')
                ]
            );

            DB::table('log_tasks')->insert(
                ['id_task' => $request->id_task, 'date' => $request->tanggal,'updated_by'=>Auth::user()->id,'is_admin'=>1,'deskripsi'=>"update new task from CMS",
                'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')
                ]
            );
        }

        admin_logs::addLogs("UPD-002","Tugas");
        return redirect()->route('list-tugas');
    }



}
