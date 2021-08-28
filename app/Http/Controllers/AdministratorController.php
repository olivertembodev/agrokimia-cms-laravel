<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administrator;
use App\Role;
use App\Traits\admin_logs;
use DB;

class AdministratorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controller = new Controller;
        $data['roles']=Role::all();
        $data['menus'] =  $controller->menus();
        return view('admin.index', $data);
    }
    public function getIndex()
    {
        $data = DB::table('administrators')
                            ->select('administrators.*', 'roles.name as role_name')
                            ->leftJoin('roles', 'roles.id', 'administrators.id_role')
                            ->whereNull('administrators.deleted_at')
                            ->get();
        return datatables()->of($data)
        ->addColumn('action',function ($data){ //m
            if($data->role_name=='SUPERADMIN'||$data->role_name=='PRINCIPLE'){
                $button ='<a href='.route("edit-admin",$data->id).' style="display:none;" class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></a>'.'&nbsp';
                $button.='<button class="btn btn-xs btn-danger" style="display:none;" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button.="&nbsp";
                $button.='<a href='.route("show-admin", $data->id).' class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
                $button.="&nbsp";
            }else{
                $button ='<a href='.route("edit-admin",$data->id).' class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></a>'.'&nbsp';
                $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button.="&nbsp";
                $button.='<a href='.route("show-admin", $data->id).' class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
                $button.="&nbsp";
            }
        return $button;
        })
        ->rawColumns(['action'])->make(true);
    }
    public function roleIndex($query)
    {
        $data = DB::table('administrators')
                            ->select('administrators.*', 'roles.name as role_name')
                            ->leftJoin('roles', 'roles.id', 'administrators.id_role')
                            ->whereNull('administrators.deleted_at')
                            ->where('id_role',$query)
                            ->get();
        return datatables()->of($data)
        ->addColumn('action',function ($data){ //m
            if($data->role_name=='SUPERADMIN'||$data->role_name=='PRINCIPLE'){
                $button ='<a href='.route("edit-admin",$data->id).' style="display:none;" class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></a>'.'&nbsp';
                $button.='<button class="btn btn-xs btn-danger" style="display:none;" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button.="&nbsp";
                $button.='<a href='.route("show-admin", $data->id).' class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
                $button.="&nbsp";
            }else{
                $button ='<a href='.route("edit-admin",$data->id).' class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></a>'.'&nbsp';
                $button.='<button class="btn btn-xs btn-danger" data-record-id="'.$data->id.'" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button.="&nbsp";
                $button.='<a href='.route("show-admin", $data->id).' class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
                $button.="&nbsp";
            }

        return $button;
        })
        ->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['roles'] = Role::where('status', 1)->get();

        return view('admin.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'required',
            'nip' => 'required',
            'phone' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
            'address' => 'required',
            'id_role' => 'required',
        ]);

        $admin = new Administrator;
        $admin->name = $request->name;
        $admin->id_role = $request->id_role;
        $admin->nik = $request->nik;
        $admin->nip = $request->nip;
        $admin->phone = $request->phone;
        $admin->tanggal_lahir = $request->tanggal_lahir;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->address = $request->address;
        $admin->status = $request->status;
        $admin->created_at = date('Y-m-d H:m:s');
        $admin->updated_at = date('Y-m-d H:m:s');
        $admin->save();
        admin_logs::addLogs("ADD-001","Administrator");

        return redirect()->route('list-admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['admin'] = DB::table('administrators')
                            ->select('administrators.*', 'roles.name as role_name')
                            ->leftJoin('roles', 'roles.id', 'administrators.id_role')
                            ->where('administrators.id', $id)
                            ->get();
        admin_logs::addLogs("DTL-004","Administrator");

        return view('admin.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $controller = new Controller;
        $data['menus'] =  $controller->menus();

        $data['roles'] = Role::all();
        $data['admin'] = Administrator::find($id);

        return view('admin.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'required',
            'nip' => 'required',
            'phone' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required',
            'id_role' => 'required',
        ]);

        $admin = Administrator::find($id);
        $admin->name = $request->name;
        $admin->nik = $request->nik;
        $admin->nip = $request->nip;
        $admin->phone = $request->phone;
        $admin->tanggal_lahir = $request->tanggal_lahir;
        $admin->email = $request->email;
        $admin->id_role = $request->id_role;
        $admin->status = $request->status;
        $admin->address = $request->address;
        $admin->save();
        admin_logs::addLogs("UPD-002","Administrator");

        return redirect()->route('list-admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Administrator::find($id);
        $admin->delete();
        admin_logs::addLogs("DEL-003","Administrator");

        return redirect()->route('list-admin');
    }
}
