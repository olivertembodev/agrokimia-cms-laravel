<?php

namespace App\Http\Controllers;

use App\Role;
use App\Departement;
use App\MenuModel;
use App\Traits\admin_logs;
use Illuminate\Http\Request;
use DB;

class RoleController extends Controller
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
        $data['menus'] = $controller->menus();

        $data['roles'] = DB::table('roles')
                            ->select('roles.*', 'departements.nama_departement')
                            ->leftJoin('departements', 'departements.id', 'roles.id_departement')
                            ->whereNull('roles.deleted_at')
                            ->whereNull('departements.deleted_at')
                            ->get();

        return view('role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['departements'] = Departement::all();
        $data['menu_utamas'] = MenuModel::where('parent_menu_id', 0)->get();
        $data['sub_menus'] = MenuModel::where('parent_menu_id', '<>', 0)->get();

        return view('role.add', $data);
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
            'id_departement' => 'required',
            'role_name' => 'required',
            'status' => 'required'
        ]);

        $role_id = DB::table('roles')->insertGetId(
            ['id_departement' => $request->id_departement, 'name' => $request->role_name, 'status' => $request->status, 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
        );

        if (!empty($request->menus)) {
            for ($i=0; $i < count($request->menus); $i++) {
                DB::table('role_menus')->insert(
                    ['role_id' => $role_id, 'menu_id' => $request->menus[$i], 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
                );
            }
        }
        admin_logs::addLogs("ADD-001","Role Admin");


        return redirect()->route('role-admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['departements'] = Departement::all();
        $data['role'] = Role::find($id);

        $role_menus = DB::table('role_menus')
                        ->where('role_id', $id)
                        ->get();

        $data['role_menus'] = $role_menus;

        $data['menu_utamas'] = MenuModel::where('parent_menu_id', 0)->get();
        $data['sub_menus'] = MenuModel::where('parent_menu_id', '<>', 0)->get();

        return view('role.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_departement' => 'required',
            'role_name' => 'required',
            'status' => 'required'
        ]);

        $role = Role::find($id);
        $role->id_departement = $request->id_departement;
        $role->name = $request->role_name;
        $role->status = $request->status;
        $role->created_at = date('Y-m-d H:m:s');
        $role->updated_at = date('Y-m-d H:m:s');
        $role->save();

        DB::table('role_menus')->where('role_id', $id)->delete();

        if (!empty($request->menus)) {
            for ($i=0; $i < count($request->menus); $i++) {
                DB::table('role_menus')->insert(
                    ['role_id' => $id, 'menu_id' => $request->menus[$i], 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')]
                );
            }
        }
        admin_logs::addLogs("UPD-002","Role Admin");

        return redirect()->route('role-admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        admin_logs::addLogs("DEL-004","Role Admin");

        return redirect()->route('role-admin');
    }
}
