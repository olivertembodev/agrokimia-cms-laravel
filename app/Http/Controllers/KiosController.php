<?php

namespace App\Http\Controllers;

use App\Area;
use App\Category_Kios;
use App\City;
use App\Classes\upload;
use App\Kios;
use App\Role_Pembayaran;
use App\TipeKios;
use App\Traits\admin_logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTables;

class KiosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    //tipe kios
    public function indexTipeKios()
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['data'] = Category_Kios::all();
        return view('kios.tipekios', $data);
    }
    public function addTipeKios()
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['data'] = Role_Pembayaran::all();

        return view('kios.addTipeKios', $data);
    }
    public function inserttipekioskios(Request $request)
    {

        $tipe_kios=new Category_Kios();
        $tipe_kios->nama_tipe=$request->nama_tipe_kios;
        $tipe_kios->save();
        admin_logs::addLogs("ADD-001","Tipe Kios");
        return redirect()->route('tipe-kios');

    }
    public function deletetipekios($id)
    {
        $data=Category_Kios::find($id);
        $data->delete();
        admin_logs::addLogs("DEL-003","Tipe Kios");
        return redirect()->route('tipe-kios');

    }
    public function edittipekios($id)
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['data'] = Category_Kios::find($id);
        return view('kios.edittipekios', $data);

    }
    public function updatetipekios(Request $request,$id)
    {
        $tipe_kios=new Category_Kios();
        $tipe_kios=Category_Kios::find($id);
        $tipe_kios->nama_tipe=$request->nama_tipe_kios;
        $tipe_kios->save();
        admin_logs::addLogs("UPD-002","Tipe Kios");
        return redirect()->route('tipe-kios');
    }

    //kios
    public function indexKios()
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['cities'] = City::all();
        return view('kios.listkios', $data);

    }
    //buat fungsi untuk server side nya
    public function getindexKios()
    {
        $kios=Kios::latest()->get();
        $i=0;
            foreach($kios as $item){
                if ($item->status == "1") {
                    $kios[$i]->status= 'Aktif';
                }elseif($item->status == "2"){
                    $kios[$i]->status= 'Expired';
                }else{
                    $kios[$i]->status= 'Tidak Aktif';
                }
                $i++;
            }
        return datatables()->of($kios)
            ->addColumn('action',function ($data){ //m
            $button ='<a href="'.route("editKios",$data->id).'">
             <button class="btn btn-xs btn-primary " type="button">
             <span class="btn-label"><i class="fa fa-file"></i></span>
             </button>
             </a>';
             $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
             $button.="&nbsp";
             $button.='<button class="btn btn-xs btn-success" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#status-modal"><span class="btn-label"><i class="fa fa-undo"></i></span></button>';
             $button.="&nbsp";
             $button.='<a href="'.route("detailkios",$data->id).'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
            return $button;
            })
            ->rawColumns(['action'])->make(true);

    }
    public function getindexKiosBy($query)
    {
        $kioscari=Kios::where('id_area', $query)->get();
        $i=0;
        foreach($kioscari as $item){
            if ($item->status == "1") {
                $kioscari[$i]->status= 'Aktif';
            }elseif($item->status == "2"){
                $kioscari[$i]->status= 'Expired';
            }else{
                $kioscari[$i]->status= 'Tidak Aktif';
            }
            $i++;
        }
        return datatables()->of($kioscari)
            ->addColumn('action',function ($data){ //m
            $button ='<a href="'.route("editKios",$data->id).'">
             <button class="btn btn-xs btn-primary " type="button">
             <span class="btn-label"><i class="fa fa-file"></i></span>
             </button>
             </a>';
             $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
             $button.="&nbsp";
             $button.='<button class="btn btn-xs btn-success" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#status-modal"><span class="btn-label"><i class="fa fa-undo"></i></span></button>';
             $button.="&nbsp";
             $button.='<a href="'.route("detailkios",$data->id).'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
            return $button;
            })
            ->rawColumns(['action'])->make(true);

    }
    public function getindexKiosByKota($query)
    {
        $kioscari=Kios::where('id_kota', $query)->get();
        $i=0;
        foreach($kioscari as $item){
            if ($item->status == "1") {
                $kioscari[$i]->status= 'Aktif';
            }elseif($item->status == "2"){
                $kioscari[$i]->status= 'Expired';
            }else{
                $kioscari[$i]->status= 'Tidak Aktif';
            }
            $i++;
        }
        return datatables()->of($kioscari)
            ->addColumn('action',function ($data){ //m
            $button ='<a href="'.route("editKios",$data->id).'">
             <button class="btn btn-xs btn-primary " type="button">
             <span class="btn-label"><i class="fa fa-file"></i></span>
             </button>
             </a>';
             $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
             $button.="&nbsp";
             $button.='<button class="btn btn-xs btn-success" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#status-modal"><span class="btn-label"><i class="fa fa-undo"></i></span></button>';
             $button.="&nbsp";
             $button.='<a href="'.route("detailkios",$data->id).'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
            return $button;
            })
            ->rawColumns(['action'])->make(true);

    }

    public function addKios()
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['cities'] = City::all();
        $data['kios_utama'] = DB::table('kios')
                                ->select('*')
                                ->whereNull('id_kios_utama')
                                ->whereNull('deleted_at')
                                ->get();

        $data['area'] = Area::all();
        $data['category_kios'] = Category_Kios::all();
        $data['tipe_kios'] = TipeKios::all();

        return view('kios.addKios', $data);
    }

    public function insertKios(Request $request)
    {
        $request->validate([
            'nama_kios'=>'required',
            'tipe_kios'=>'required',
            'category_kios'=>'required',
            'id_kota'=>'required',
            'area_code'=>'required',
            'alamat_kios'=>'required',
            'alamat'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'email'=>'required|email',
            'nama_pic'=>'required',
            'nomor_hp_pic'=>'required',
            'nomor_ktp_pic'=>'required',
            'nomor_npwp_pic'=>'required',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'status'=>'required',
            'image_npwp' => 'mimes:jpeg,jpg,png|max:2048',
            'image_ktp' => 'mimes:jpeg,jpg,png|max:2048',
            'image_selfi_ktp' => 'mimes:jpeg,jpg,png|max:2048',
            'image_kios_depan' => 'mimes:jpeg,jpg,png|max:2048',
            'image_kios_dalam' => 'mimes:jpeg,jpg,png|max:2048',
        ]);
        $kios=new Kios();
        $last=Kios::latest()->first();
        if (!empty($last)) {
            $new_kios=1;
        } else {
            $exp=explode("-",$last->kode_kios);
            $new_kios=$exp[1]+1;
        }
        $kios->nama_Kios=$request->nama_kios;
        $kios->id_kios_utama=$request->kios_utama;
        $kios->tipe_kios=$request->tipe_kios;
        $kios->id_category=$request->category_kios;
        $kios->kode_kios=date("Ymd").date("his")."-".$new_kios;
        $kios->id_kota=$request->id_kota;
        $kios->id_area=$request->area_code;
        $kios->alamat_kios=$request->alamat_kios;
        $kios->alamat=$request->alamat;
        $kios->maps="https://www.google.com/maps/search/?api=1&query=". $kios->latitude=$request->latitude.",".$kios->longitude=$request->longitude;
        $kios->latitude=$request->latitude;
        $kios->longitude=$request->longitude;
        $kios->email=$request->email;
        $kios->nama_pic=$request->nama_pic;
        $kios->nomor_hp_pic=$request->nomor_hp_pic;
        $kios->nomor_ktp_pic=$request->nomor_ktp_pic;
        $kios->nomor_npwp_pic=$request->nomor_npwp_pic;
        $kios->password=bcrypt($request->password);
        $kios->status=$request->status;
        //image
        $upload       = new upload();
        if ($request->file('image_npwp')) {
            $kios->image_npwp = $upload->img($request->file('image_npwp'));
        } if($request->file('image_ktp')){
            $kios->image_ktp = $upload->img($request->file('image_ktp'));
        } if($request->file('image_selfi_ktp')){
            $kios->image_selfi_ktp = $upload->img($request->file('image_selfi_ktp'));
        } if($request->file('image_kios_depan')){
            $kios->image_kios_depan = $upload->img($request->file('image_kios_depan'));
        } if($request->file('image_kios_dalam')){
            $kios->image_kios_dalam = $upload->img($request->file('image_kios_dalam'));
        }
        if(!$kios->image_npwp) {
            $kios->image_npwp = env('DEFAULT_IMAGE');
         }
         if(!$kios->image_ktp) {
            $kios->image_ktp = env('DEFAULT_IMAGE');
         }
         if(!$kios->image_selfi_ktp) {
            $kios->image_selfi_ktp = env('DEFAULT_IMAGE');
         }
         if(!$kios->image_kios_depan) {
            $kios->image_kios_depan = env('DEFAULT_IMAGE');
         }
         if(!$kios->image_kios_dalam) {
            $kios->image_kios_dalam = env('DEFAULT_IMAGE');
         }
        admin_logs::addLogs("ADD-001","Kios");
        $kios->save();
        //die();
        return redirect()->route('list-kios');
    }
    public function editKios($id)
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['data'] = Kios::find($id);
        $data['cities'] = City::all();
        $data['kios_utama'] = DB::table('kios')
                                ->select('*')
                                ->where('id_kios_utama',null)
                                ->get();
        $data['area'] = Area::all();
        $data['category_kios'] = Category_Kios::all();
        $data['tipe_kios'] = TipeKios::all();


        return view('kios.editKios', $data);
    }
    public function deletekios($id)
    {
        $data=Kios::find($id);
        $data->delete();
        return redirect()->route('list-kios');
    }
    public function updateKios(Request $request, $id)
    {
        $kios=new Kios();
        $kios=Kios::find($id);
        $request->validate([
            'nama_kios'=>'required',
            'tipe_kios'=>'required',
            'category_kios'=>'required',
            'id_kota'=>'required',
            'area_code'=>'required',
            'alamat_kios'=>'required',
            'alamat'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'email'=>'required|email',
            'nama_pic'=>'required',
            'nomor_hp_pic'=>'required',
            'nomor_ktp_pic'=>'required',
            'nomor_npwp_pic'=>'required',
            'status'=>'required',
            'image_npwp' => 'mimes:jpeg,jpg,png|max:2048',
            'image_ktp' => 'mimes:jpeg,jpg,png|max:2048',
            'image_selfi_ktp' => 'mimes:jpeg,jpg,png|max:2048',
            'image_kios_depan' => 'mimes:jpeg,jpg,png|max:2048',
            'image_kios_dalam' => 'mimes:jpeg,jpg,png|max:2048',
        ]);
        //dd($request);
        $kios->nama_Kios=$request->nama_kios;
        $kios->id_kios_utama=$request->kios_utama;
        $kios->tipe_kios=$request->tipe_kios;
        $kios->id_category=$request->category_kios;
        $kios->id_kota=$request->id_kota;
        $kios->id_area=$request->area_code;
        $kios->alamat_kios=$request->alamat_kios;
        $kios->alamat=$request->alamat;
        $kios->maps="https://www.google.com/maps/search/?api=1&query=". $kios->latitude=$request->latitude.",".$kios->longitude=$request->longitude;

        $kios->latitude=$request->latitude;
        $kios->longitude=$request->longitude;
        $kios->email=$request->email;
        $kios->nama_pic=$request->nama_pic;
        $kios->nomor_hp_pic=$request->nomor_hp_pic;
        $kios->nomor_ktp_pic=$request->nomor_ktp_pic;
        $kios->nomor_npwp_pic=$request->nomor_npwp_pic;
        $kios->status=$request->status;
        //image
        $upload       = new upload();
        if ($request->file('image_npwp')) {
            $kios->image_npwp = $upload->img($request->file('image_npwp'));
        } if($request->file('image_ktp')){
            $kios->image_ktp = $upload->img($request->file('image_ktp'));
        } if($request->file('image_selfi_ktp')){
            $kios->image_selfi_ktp = $upload->img($request->file('image_selfi_ktp'));
        } if($request->file('image_kios_depan')){
            $kios->image_kios_depan = $upload->img($request->file('image_kios_depan'));
        } if($request->file('image_kios_dalam')){
            $kios->image_kios_dalam = $upload->img($request->file('image_kios_dalam'));
        }
         if(!$kios->image_npwp) {
            $kios->image_npwp = env('DEFAULT_IMAGE');
         }
         if(!$kios->image_ktp) {
            $kios->image_ktp = env('DEFAULT_IMAGE');
         }
         if(!$kios->image_selfi_ktp) {
            $kios->image_selfi_ktp = env('DEFAULT_IMAGE');
         }
         if(!$kios->image_kios_depan) {
            $kios->image_kios_depan = env('DEFAULT_IMAGE');
         }
         if(!$kios->image_kios_dalam) {
            $kios->image_kios_dalam = env('DEFAULT_IMAGE');
         }
        admin_logs::addLogs("UPD-002","Kios");
        $kios->save();
        return redirect()->route('list-kios');

    }
    public function detailkios($id)
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['data'] = DB::table('kios')
                        ->select('kios.*','cities.name as id_kota','areas.name as id_area','category_kios.nama_tipe as tipe_kios', 'tipe_kios.nama_tipe_kios')
                        ->leftJoin('cities', 'cities.city_code', '=', 'kios.id_kota')
                        ->leftJoin('areas', 'areas.area_code', '=', 'kios.id_area')
                        ->leftJoin('category_kios', 'category_kios.id', '=', 'kios.id_category')
                        ->leftJoin('tipe_kios', 'tipe_kios.id', '=', 'kios.tipe_kios')
                        ->where('kios.deleted_at',null)->where('kios.id',$id)
                        ->get();

        if ($data['data'][0]->id_kios_utama!="") {
            $data['kios_utama'] = DB::table('kios')->select('nama_Kios')
                                    ->where('id_kios_utama',$data['data'][0]->id_kios_utama)
                                    ->where('nama_Kios',$data['data'][0]->nama_Kios)
                                    ->get();
        } else {
            $data['kios_utama'] = DB::table('kios')->select('nama_Kios')
                                    ->where('id_kios_utama',$data['data'][0]->id_kios_utama)
                                    ->where('nama_Kios',"Gii")
                                    ->get();
        }
        admin_logs::addLogs("DTL-004","Kios");

        return view('kios.detailkios', $data);
    }
    public function updatestatuskios(Request $request)
    {
        $id= $request->id;
        $stat=$request->status;
        $tanggal=$request->tanggal;
        $status=new Kios();
        $status=Kios::find($id);
        if($status){
            $status->status=$stat;
            $status->exp_date=$tanggal;
            admin_logs::addLogs("UPD-002","Status Kios");
            $status->save();
            return response()->json('success');
        }else{
            return response()->json('gagal');
        }
    }

}
