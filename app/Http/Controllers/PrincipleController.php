<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Category_principle;
use App\Classes\upload;
use App\Principle;
use App\Role;
use App\Traits\admin_logs;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class PrincipleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['principles'] = Principle::all();

        return view('principle.index', $data);
    }

    public function add()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['categories'] = Category_principle::all();

        return view('principle.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_principle'   => 'required',
            'email_principle'  => 'required',
            'alamat_principle' => 'required',
            'phone_principle'  => 'required',
            'tanggal_lahir',
            'nama_pic'         => 'required',
            'nomor_pic'        => 'required',
            'email'        => 'required',
            'password'         => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'status_principle' => 'required',
            'id_kategori'      => 'required',
            'logo'             => 'max:2048',
        ]);
        $principle= new Principle();
        $principle->id_kategori=$request->id_kategori;
        $principle->nama_principle=$request->nama_principle;
        $principle->email_principle=$request->email_principle;
        $principle->alamat_principle=$request->alamat_principle;
        $principle->phone_principle=$request->phone_principle;
        $principle->tanggal_lahir=$request->tanggal_lahir;
        $principle->nama_pic=$request->nama_pic;
        $principle->nomor_pic=$request->nomor_pic;
        $principle->email=$request->email;
        $principle->status_principle=$request->status_principle;
        $principle->password=bcrypt($request->password);

        if ($request->file('logo')) {
            $upload       = new upload();
            $principle->logo = $upload->img($request->file('logo'));
        } else {
            $principle->logo = env('DEFAULT_IMAGE');
        }

        $principle->save();
        $last_entry = Principle::latest()->first();
        $last_entry->id;
        $administrator=new Administrator();
        $administrator->id_principle=$last_entry->id;
        $administrator->email=$request->email;
        $administrator->password=bcrypt($request->password);
        $administrator->status=$request->status_principle;
        $administrator->name=$request->nama_pic;
        $administrator->address=$request->alamat_principle;
        $role=DB::table('roles')
            ->where('name', "PRINCIPLE")->first();
        $id_role=$role->id;
        $administrator->id_role=$id_role;
        $administrator->save();
        admin_logs::addLogs("ADD-001","Principle");
        return redirect()->route('list-principle');
    }

    public function show(Principle $principle, $id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['principle'] = Principle::where('id', $id)
                                    ->with('categories')
                                    ->first();
        admin_logs::addLogs("DTL-004","Kios");

        return view('principle.show', $data);
    }

    public function edit(Principle $principle, $id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['categories'] = Category_principle::all();
        $data['principle']  = Principle::where('id', $id)
                                        ->with('categories')
                                        ->first();

        return view('principle.edit', $data);
    }

    public function update(Request $request, Principle $principle, $id)
    {
        $data = $request->validate([
            'nama_principle'   => 'required',
            'email_principle'  => 'required',
            'alamat_principle' => 'required',
            'phone_principle'  => 'required',
            'tanggal_lahir',
            'nama_pic'         => 'required',
            'nomor_pic'        => 'required',
            'email'        => 'required',
            'status_principle' => 'required',
            'id_kategori'      => 'required',
            'logo'         => 'max:2048',
        ]);

        if ($request->file('logo')) {
            $upload       = new upload();
            $data['logo'] = $upload->img($request->file('logo'));
        }

        Principle::where('id', $id)->update($data);
        admin_logs::addLogs("UPD-002","Principle");

        return redirect()->route('list-principle');
    }

    public function delete($id)
    {
        admin_logs::addLogs("DEL-003","Principle");
        Principle::where('id', $id)->delete();
        return redirect()->route('list-principle');
    }

    public function category()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['categories'] = Category_principle::all();

        return view('principle.category.index', $data);
    }

    public function add_category()
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        return view('principle.category.add', $data);
    }

    public function store_category(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required',
            'status' => 'required',
            'icon'         => 'max:2048',
        ]);

        if ($request->file('icon')) {
            $upload       = new upload();
            $data['icon'] = $upload->img($request->file('icon'));
        } else {
            $data['icon'] = env('DEFAULT_IMAGE');
        }

        Category_principle::create($data);
        admin_logs::addLogs("ADD-001","Kategori Principle");
        return redirect()->route('principle-category');
    }

    public function edit_category($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['category'] = Category_principle::where('id', $id)->first();

        return view('principle.category.edit', $data);
    }

    public function update_category(Request $request, $id)
    {
        admin_logs::addLogs("UPD-002","Kategori Principle");
        $data = $request->validate([
            'name'   => 'required',
            'status' => 'required',
            'icon'         => 'max:2048',
        ]);

        if ($request->file('icon')) {
            $upload       = new upload();
            $data['icon'] = $upload->img($request->file('icon'));
        }

        Category_principle::where('id', $id)->update($data);
        return redirect()->route('principle-category');
    }

    public function delete_category($id)
    {
        admin_logs::addLogs("DEL-003","Kategori Principle");
        Category_principle::where('id', $id)->delete();
        return redirect()->route('principle-category');
    }

    public function changePassword($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['principle'] = Principle::find($id);

        return view('principle.password_change', $data);
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);

        $principle = Principle::find($id);
        $plainPassword = $request->get('current_password');

        if (Hash::check($plainPassword, $principle->password) == true) {
            $principle->password = bcrypt(request('password'));
            $principle->save();

            return redirect()
            ->route('password.change.principle', [$principle->id])
            ->withSuccess('Password Baru Disimpan.');
        }

        return redirect()
            ->route('password.change.principle', [$principle->id])
            ->with('error', 'Password Lama Salah');
    }

}
