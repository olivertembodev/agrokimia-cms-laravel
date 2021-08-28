<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskTodayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }
    public function indexHariini()
    {
        return view('tasktoday');
    }
    public function tracking()
    {
        return view('tracking');
    }
    public function getindextugashariini()
    {
        $today=date('d/m/Y');
        $dataku= DB::table('tasks')
        ->select('tasks.*','cities.name as id_kota','areas.name as id_area','kios.nama_Kios as id_kios','sales.nama_sales as id_sales','tipe_tasks.nama_kode as nama_tugas')
        ->leftJoin('cities', 'cities.city_code', '=', 'tasks.id_kota')
        ->leftJoin('areas', 'areas.id', '=', 'tasks.id_area')
        ->leftJoin('kios', 'kios.id', '=', 'tasks.id_kios')
        ->leftJoin('tipe_tasks', 'tipe_tasks.id', '=', 'tasks.id_tipe_tasks')
        ->leftJoin('sales', 'sales.id', '=', 'tasks.id_sales')
        ->where('tasks.date',$today)
        ->get();
        return datatables()->of($dataku)
            ->addColumn('action',function ($data){ //m
            $button='<a href="/tracking"><button class="btn btn-xs btn-success">
            <span class="btn-label"><i class="fa fa-map"></i></span>
            </button></a>';
            return $button;
            })->addColumn('status',function($data){
            $button1 ='<a href="editKios/'.$data->id.'">
            <button class="btn btn-xs btn-danger " type="button">
            <span class="btn-label"><i class="fa fa-undo"></i></span>
            </button>
            </a>';
            return $button1;
            })
            ->rawColumns(['status','action'])->make(true);

    }
}
