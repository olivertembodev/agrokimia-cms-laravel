<?php

namespace App\Http\Controllers;

use App\Informasi;
use Illuminate\Http\Request;
use Auth;
use App\City;
use App\Sales;
use App\Kios;
use DB;
use App\Pemberitahuan;
use App\Traits\admin_logs;
use GuzzleHttp\Client;

class InformasiController extends Controller
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

    public function sendToFcm($reg_id, $payload){
        $URL = "https://fcm.googleapis.com/fcm/send";
        $KEY = env("FIREBASE_CREDENTIALS", null);
        $client = new Client;
        $data = $client->request('POST', $URL, [
            'headers' => array(
                'Authorization' => 'key='.$KEY,
                'Content-Type' => 'application/json'
            ),
            'json' => array(
                'registration_ids' => array($reg_id),
                'data' => is_object($payload) ? $payload : $payload
            )
        ]);
        $result = $data->getBody();
        $res = json_decode($result);
        //buat log fcm request
        $logs = new FcmLogsModel;
        $logs->reg_id = $reg_id;
        $logs->payload = is_object($payload) ? $payload : $payload;
        $logs->result = $res;
        $logs->save();

        return $res;
    }

    public function indexNotifikasi(){

        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        return view('informasi.listNotification', $data);
    }

    public function listNotifData()
    {
        $datalist = DB::table('pemberitahuan as p')
        ->select('p.*','ad.name as admin_name','k.nama_Kios','s.nama_sales','a.name as area_name')
        ->leftJoin('administrators as ad', 'ad.id', '=', 'p.created_by')
        ->leftJoin('kios as k', 'k.id', '=', 'p.id_user')
        ->leftJoin('sales as s', 's.id', '=', 'p.id_user')
        ->leftJoin('areas as a', function($join){
            // $join->on('a.area_code','=','s.id_area')->where('p.tipe_user',1);
            $join->on('a.area_code','=','k.id_area')->where('p.tipe_user',2)->orOn('a.area_code','=','s.id_area')->where('p.tipe_user',1);
        })
        ->where('p.deleted_at',null)
        ->where('k.deleted_at',null)
        ->where('s.deleted_at',null)
        ->where('ad.deleted_at',null)->distinct()
        ->orderBy('p.updated_at', 'DESC')
        ->get();
        //    dd($datalist);

        $data = datatables()->of($datalist)
            ->addColumn('checkbox', function($data){
                return $data->id;
            })
            ->editColumn('created_at', function ($user) 
            {
                //change over here
                return date('H:i:s', strtotime($user->created_at) );
            
            })->addColumn('user', function($row){
                if(is_null($row->nama_Kios)){
                    return  $row->nama_sales.'<small>  (sales)</small>';
                }
                return $row->nama_Kios.'<small>  (kios)</small>';
            })
            ->addColumn('action',function ($data){ //m
                $button='<a href="' . action('InformasiController@show', ['id' => $data->id]) . '"><button type="button" class="btn btn-xs btn-info btnDetail"><span class="btn-label"><i class="fa fa-eye"></i></span></button></a>';
                $button.='&nbsp';
                // $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                return $button;
            })->rawColumns(['checkbox','user','action'])->make(true);

        return $data;
    }

    public function show($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['notif'] = DB::table('pemberitahuan as p')
        ->select('p.*','ad.name as admin_name','k.nama_Kios','s.nama_sales','a.name as area_name')
        ->leftJoin('administrators as ad', 'ad.id', '=', 'p.created_by')
        ->leftJoin('kios as k', 'k.id', '=', 'p.id_user')
        ->leftJoin('sales as s', 's.id', '=', 'p.id_user')
        ->leftJoin('areas as a', function($join){
            $join->on('a.area_code','=','k.id_area')->where('p.tipe_user',2)->orOn('a.area_code','=','s.id_area')->where('p.tipe_user',1);
        })
        ->where('p.deleted_at',null)
        ->where('k.deleted_at',null)
        ->where('s.deleted_at',null)
        ->where('p.id', $id)
        ->where('ad.deleted_at',null)->distinct()
        ->get();
        //dd($data['notif'][0]);

        return view('informasi.showinfo', $data);
    }

    public function addNotifikasi(){
       // $data['notification'] = Province::all();
        $controller = new Controller;
        $data['menus'] =  $controller->menus();
        $data['cities'] = City::all();

        return view('informasi.addNotification',$data);
    }

    public function getuserwithtype($type,$kota=null){
        $users;
        if(!empty($kota)){
            if($type==1){
                $users = Sales::select('id','nama_sales as name')
                ->where('id_kota', $kota)
                ->get();
            }else{
                $users = Kios::select('id','nama_Kios as name')
                ->where('id_kota', $kota)
                ->get();
            }
        }else{
            if($type==1){
                $users = Sales::select('id','nama_sales as name')
                ->get();
            }else{
                $users = Kios::select('id','nama_Kios as name')
                ->get();
            }
        }

        return response()->json($users);
    }

    // Method untuk testing saja
    public function generateInfo(Request $request){
        dd($request);
        return view();
    }

    public function storeNotification(Request $request){
        // city_code
        // user_type 1: sales 2:kios
        // users
        // judul
        // deskripsi
        // tanggal
        // checksemuaarea
        $emailss = array();
        $ids = array();
        $tokenUser = array();

        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
        ]);
        // dd($request);


       // dd($request->user_type);
        if ($request->has('checksemuaarea') && $request->has('checktipeuser')) {
           // code to be executed if this condition is true;
           $sales = Sales::select('id','email','nama_sales as name')->get();
           if(!empty($sales)){

            foreach($sales as $sale){
                $emailss = array_merge($emailss, [$sale->email => $sale->name]);
                 array_push($tokenUser, $sale->firebase_token);
               // array_push($emailss[$sale->email],$sale->name);
                $ids[] = array('id'=>$sale->id, 'tipe'=>1);
            }
           }
           $kioses = Kios::select('id','email','nama_Kios as name')->get();
           if(!empty($kioses)){
            foreach($kioses as $kios){
                $emailss = array_merge($emailss, [$kios->email => $kios->name]);
                $ids[] = array('id'=>$kios->id, 'tipe'=>2);
            }
           }

           //dd($ids);
        } elseif ($request->has('checksemuaarea')) {
            // CHECK APAKAH USER TERYENTU YANG DIPILIH
            if($request->has('users')){
                if($request->user_type=="1"){
                    echo " <br> 1a  <br> " ;
                    $users = Sales::select('id','email', 'nama_sales as name')
                    ->whereIn('id', $request->users)
                    ->get();
                    if(!empty($users)){
                        foreach($users as $sale){
                            $emailss = array_merge($emailss, [$sale->email => $sale->name]);
                            array_push($tokenUser, $sale->firebase_token);
                            $ids[] = array('id'=>$sale->id, 'tipe'=>1);
                        }
                    }
                }else{
                    echo " <br> 2a  <br> " ;
                    $users = Kios::select('id','email','nama_Kios as name')
                    ->whereIn('id', $request->users)
                    ->get();
                    if(!empty($users)){
                        foreach($users as $kios){
                            $emailss = array_merge($emailss, [$kios->email => $kios->name]);
                            $ids[] = array('id'=>$kios->id, 'tipe'=>2);
                        }
                    }
                }
            }else{
                // CHECK KE SALAH SATU TYPE USER
                if($request->user_type == "1"){
                    echo " <br> 1  <br> " ;
                    $sales = Sales::select('id','email','nama_sales as name')->get();
                    if(!empty($sales)){
                        foreach($sales as $sale){
                            $emailss = array_merge($emailss, [$sale->email => $sale->name]);
                            array_push($tokenUser, $sale->firebase_token);
                            $ids[] = array('id'=>$sale->id, 'tipe'=>1);
                        }
                    }
                }else{
                    echo " <br> 2  <br> " ;
                    dd($request);
                    $kioses = Kios::select('id','email','nama_Kios as name')->get();
                    if(!empty($kioses)){
                        foreach($kioses as $kios){
                            $emailss = array_merge($emailss, [$kios->email => $kios->name]);
                            $ids[] = array('id'=>$kios->id, 'tipe'=>2);
                        }
                    }
                }
            }

        } elseif ($request->has('checktipeuser')){
            // kirim ke semua user berdasarkan citycode
            echo " <br> 1x  <br> " ;
            $sales = Sales::select('id','email','nama_sales as name')
            ->where('id_kota', $request->city_code)
            ->get();
            if(!empty($sales)){
                foreach($sales as $sale){
                    $emailss = array_merge($emailss, [$sale->email => $sale->name]);
                    array_push($tokenUser, $sale->firebase_token);
                    $ids[] = array('id'=>$sale->id, 'tipe'=>1);
                }
            }
            echo " <br> 2x  <br> " ;
            $kioses = Kios::select('id','email','nama_Kios as name')
            ->where('id_kota', $request->city_code)
            ->get();
            if(!empty($kioses)){
                foreach($kioses as $kios){
                    $emailss = array_merge($emailss, [$kios->email => $kios->name]);
                    $ids[] = array('id'=>$kios->id, 'tipe'=>2);
                }
            }

        }else{
            // jika semua area dan semua user not checked
            if($request->has('users')){
                if($request->user_type=="1"){
                    echo " <br> 1z  <br> " ;
                    $users = Sales::select('id','email','nama_sales as name')
                    ->where('id_kota', $request->city_code)
                    ->whereIn('id', $request->users)
                    ->get();
                    if(!empty($users)){
                        foreach($users as $sale){
                            $emailss = array_merge($emailss, [$sale->email => $sale->name]);
                            array_push($tokenUser, $sale->firebase_token);
                            $ids[] = array('id'=>$sale->id, 'tipe'=>1);
                        }
                    }
                }else{
                    echo " <br> 2z  <br> " ;
                    $users = Kios::select('id','email','nama_Kios as name')
                    ->where('id_kota', $request->city_code)
                    ->whereIn('id', $request->users)
                    ->get();
                    if(!empty($users)){
                        foreach($users as $kios){
                            $emailss = array_merge($emailss, [$kios->email => $kios->name]);
                            $ids[] = array('id'=>$kios->id, 'tipe'=>2);
                        }
                    }
                }

            }else{
                // CHECK KE SALAH SATU TYPE USER
                if($request->user_type == "1"){
                    echo " <br> 1zz  <br> " ;
                    $sales = Sales::select('id','email','nama_sales as name')
                    ->where('id_kota', $request->city_code)
                    ->get();
                    if(!empty($sales)){
                        foreach($sales as $sale){
                            $emailss = array_merge($emailss, [$sale->email => $sale->name]);
                            array_push($tokenUser, $sale->firebase_token);
                            $ids[] = array('id'=>$sale->id, 'tipe'=>1);
                        }
                    }

                }else{
                    echo " <br> 2zz  <br> " ;
                    dd($request);
                    $kioses = Kios::select('id','email','nama_Kios as name')
                    ->where('id_kota', $request->city_code)
                    ->get();
                    if(!empty($kioses)){
                        foreach($kioses as $kios){
                            $emailss = array_merge($emailss, [$kios->email => $kios->name]);
                            $ids[] = array('id'=>$kios->id, 'tipe'=>2);
                        }
                    }
                }

            }

        }
        // Save to DB
        try{
            foreach($ids as $loop){
                // $pemberitahuan = new Pemberitahuan;
                // $pemberitahuan->id_user = $loop["id"];
                // $pemberitahuan->judul = $request->judul;
                // $pemberitahuan->deskripsi = $request->deskripsi;
                // $pemberitahuan->tanggal = $request->tanggal;
                // $pemberitahuan->waktu = $request->waktu;
                // $pemberitahuan->created_by = Auth::user()->id ;
                // $pemberitahuan->tipe_user = $loop["tipe"];
                // $pemberitahuan->created_at = date('Y-m-d H:m:s');
                // $pemberitahuan->updated_at = date('Y-m-d H:m:s');
                // $pemberitahuan->save();

                $pemberitahuan = DB::table('pemberitahuan')->insertGetId([
                    'id_user'            => $loop["id"],
                    'judul'              => $request->judul,
                    'deskripsi'          => $request->deskripsi,
                    'tanggal'            => $request->tanggal,
                    'waktu'              => $request->waktu,
                    'created_by'         => Auth::user()->id,
                    'tipe_user'          => $loop["tipe"],
                    'created_at'         => date('Y-m-d H:m:s'),
                    'updated_at'         => date('Y-m-d H:m:s')
                ]);

                // DB::table('user_notifications')->insert(
                //     ['id_user' => $loop["id"],
                //     'tipe_user' => $loop["tipe"],
                //     'created_by'=> Auth::user()->id,
                //     'is_view' => 0,
                //     'id_detail' => $pemberitahuan,
                //     'tipe_page' => 3,
                //     'page' => 3,
                //     'created_at'=>date('Y-m-d H:m:s'),
                //     'updated_at'=>date('Y-m-d H:m:s')
                //     ]
                // );

            }

        }catch(Exception $e){
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

        // Sent to FCM
        $messageToFcm = array(
            "tipe"=>"INFORMASI",
            "title"=>$request->judul,
            "deskripsi"=> $request->deskripsi
        );

        // Just mengirim ke useer yang punya token firebase
        foreach ($tokenUser as $key => $value) {
            
            $value = trim($value);
            if (empty($value)){
                print_r($key);
                print_r("<br>");
                print_r($value);
                echo "$key empty <br/>";
            }
            else{
                try {
                    $this->sendToFcm($value, $messageToFcm);
                } catch (Exception $e) {
                    echo 'Caught exception: '. $e->getMessage() ."\n";
                }
            }
        }

        
        //dd($emailss);

     /*     $input = $request->all();
       Pemberitahuan::create($input);
        logs::addLogs("menambah notifikasi promo");

        $title = $request->input('title');
        $content = $request->input('content');
        $tos = [
            "fikridotnet@gmail.com" => "gmail User1",
            "juangsalaz@gmail.com" => "gmail User2"
        ];
       print_r($emailss);
        echo '<br>';
       $emails = pasien::pluck('nama_depan', 'email')->toArray(); */

        // SENDEMAIL
         $email = new \SendGrid\Mail\Mail();
         $email->setFrom("agrokimiadev@gmail.com", "Admin");
         $email->setSubject($request->judul);
         $email->addTos($emailss);
         $email->addContent("text/html", $request->deskripsi);
         $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
         try {
             $response = $sendgrid->send($email);
          //  print $response->statusCode() . "\n";
          //  print_r($response->headers());
          //  print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

        admin_logs::addLogs("ADD-001", "Notifikasi");
        return redirect('/informasi/list-notification');
    }

    public function deleteNotification($id){
        $ids= array();
        $pemberitahuan = Pemberitahuan::find($id);
        $semuarealated = Pemberitahuan::where('created_at',$pemberitahuan->created_at)->get();
        foreach ($semuarelated as $data) {
            array_push($semuarealated, $data->id);
        }
        $pemberitahuan->delete();
        admin_logs::addLogs("DEL-003", "Notifikasi");
        return redirect()->route('list-notification');
    }

    public function deleteMultiple(Request $request){
        $request->validate(
            [
                'id' => 'required',
                ]
            );
        $ids = $request->id;
        $org = Pemberitahuan::whereIn('id', $ids)->delete();

        $users = DB::table('user_notifications')
             ->whereIn('id_detail', $ids)
             ->delete();

       // dd($org);
       return redirect()->route('list-notification');
    }
    
}
