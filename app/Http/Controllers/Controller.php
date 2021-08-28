<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use App\Task;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function menus()
    {
        $role_id = Auth::user()->id_role;

        $menu_ids = DB::table('role_menus')
            ->select('menu_id')
            ->where('role_id', $role_id)->get();

        foreach ($menu_ids as $menu) {
            $data['menu_utama'][] = DB::table('menus')
                ->where('parent_menu_id', 0)
                ->where('id', $menu->menu_id)
                ->get();

            $data['sub_menus'][] = DB::table('menus')
                ->where('parent_menu_id', '<>', 0)
                ->where('id', $menu->menu_id)
                ->get();
        }

        $superadmin = DB::table('roles')->where('id', $role_id)->pluck('name')->first();
        if ($superadmin == 'SUPERADMIN') {
            $data['task_count'] = Task::where('is_verified', 0)->count();
            $data['task_list'] = Task::with('kioss','saless','tipe_tasks')->where('is_verified', 0)->orderBy('date', 'DESC')->take(5)->get();
        // dd($data['task_list']);
        }

        return $data;
    }
}
