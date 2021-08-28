<?php

namespace App\Http\Controllers;

use App\Area;
use App\City;
use App\Classes\upload;
use App\Sales;
use App\Traits\admin_logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
        // $this->middleware('auth:principle');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();
        $data['cities'] = City::all();
        return view('sales.sales', $data);
    }
    public function getindex()
    {
        $sales= DB::table('sales')
                    // ->distinct('areas.name')
                    ->select('sales.*','cities.name as id_kota','areas.name as id_area')
                    ->leftJoin('cities', 'cities.city_code', '=', 'sales.id_kota')
                    ->leftJoin('areas', 'areas.area_code', '=', 'sales.id_area')
                    ->where('sales.deleted_at',null)
                    ->DISTINCT('sales.id')
                    ->get();

        $i=0;
        foreach ($sales as $item){
            if ($item->status == 1) {
                $sales[$i]->status= 'Aktif';
            }else{
                $sales[$i]->status= 'Tidak Aktif';
            }
            $i++;
        }
        return datatables()->of($sales)
            ->addColumn('action',function ($data){ //m
             $button ='<a href="'.route("editSales",$data->id).'">
             <button class="btn btn-xs btn-primary " type="button">
             <span class="btn-label"><i class="fa fa-file"></i></span>
             </button>
             </a>';
             $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
             $button.="&nbsp";
             $button.='<a href="'.route("detailsales",$data->id).'" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
             $button.="&nbsp";
             $button.='<a href="'.route("password.change.sales",$data->id).'" class="btn btn-xs btn-info " type="button"><span class="btn-label"><i class="fa fa-key"></i></span></a>';
            return $button;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function add_sales()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['cities'] = City::all();
        $data['area'] = Area::all();

        return view('sales.addsales', $data);
    }
    public function insertSales(Request $request)
    {

        $request->validate([
            'nama_sales' => 'required',
            'id_kota' => 'required',
            'area_code' => 'required',
            'alamat_sales' => 'required',
            'nik' => 'required',
            'nip' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'mimes:jpeg,jpg,png|max:2048',
            'status' => 'required',
            'email' => 'required|email',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ]);
        $sales=new Sales();
        $sales->nama_sales = $request->nama_sales;
        $sales->id_kota = $request->id_kota;
        $sales->id_area = $request->area_code;
        $sales->alamat_sales = $request->alamat_sales;
        $sales->nik = $request->nik;
        $sales->nip = $request->nip;
        $sales->jenis_kelamin = $request->jenis_kelamin;
        $sales->status = $request->status;
        if ($request->file('foto')) {
            $upload       = new upload();
            $sales->foto = $upload->img($request->file('foto'));
        } else {
            $sales->foto = env('DEFAULT_IMAGE');
        }
        $sales->email = $request->email;
        $sales->password = bcrypt($request->password);
        $sales->save();
        admin_logs::addLogs("ADD-001","Sales");

        return redirect()->route('list-sales');
    }
    public function deletesales($id)
    {
        $data=Sales::find($id);
        $data->delete();
        admin_logs::addLogs("DEL-003","Sales");
        return redirect()->route('list-sales');
    }
    public function editsales($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();
        $data['images']     = Sales::where('id', $id)->get();
        $data['sales'] = Sales::find($id);
        $data['cities'] = City::all();
        $data['area'] = Area::select('area_code','name')->distinct()->get();

        //dd($data);
        return view('sales.editsales', $data);
    }
    public function updateSales($id,Request $request)
    {
        $request->validate([
            'nama_sales' => 'required',
            'id_kota' => 'required',
            'area_code' => 'required',
            'alamat_sales' => 'required',
            'nik' => 'required',
            'nip' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'mimes:jpeg,jpg,png|max:2048',
            'status' => 'required',
            'email' => 'required|email',
        ]);
        $sales=new Sales();
        $sales=Sales::find($id);
        $sales->nama_sales = $request->nama_sales;
        $sales->id_kota = $request->id_kota;
        $sales->id_area = $request->area_code;
        $sales->alamat_sales = $request->alamat_sales;
        $sales->nik = $request->nik;
        $sales->nip = $request->nip;
        $sales->jenis_kelamin = $request->jenis_kelamin;
        $sales->status = $request->status;
        if ($request->file('foto')) {
            $upload       = new upload();
            $sales->foto = $upload->img($request->file('foto'));
        } else {
            $sales->foto = env('DEFAULT_IMAGE');
        }
        $sales->email = $request->email;
        //$sales->password = bcrypt($request->password);
        $sales->save();
        admin_logs::addLogs("UPD-002","Sales");

        return redirect()->route('list-sales');

    }
    public function detailsales($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();
        $data['sales']= DB::table('sales')
        ->select('sales.*','cities.name as id_kota','areas.name as id_area')
        ->leftJoin('cities', 'cities.city_code', '=', 'sales.id_kota')
        ->leftJoin('areas', 'areas.area_code', '=', 'sales.id_area')
        ->where('sales.deleted_at',null)->where('sales.id',$id)
        ->get();
        //dd($sales);
        admin_logs::addLogs("DTL-004","Sales");
        return view('sales.detailsales',$data);
    }

    public function changePassword($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['sales'] = Sales::find($id);

        return view('sales.password_change', $data);
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);

        $sales = Sales::find($id);
        $plainPassword = $request->get('current_password');

        if (Hash::check($plainPassword, $sales->password) == true) {
            $sales->password = bcrypt(request('password'));
            $sales->save();

            return redirect()
            ->route('password.change.sales', [$sales->id])
            ->withSuccess('Password Baru Disimpan.');
        }

        return redirect()
            ->route('password.change.sales', [$sales->id])
            ->with('error', 'Password Lama Salah');
    }
}
