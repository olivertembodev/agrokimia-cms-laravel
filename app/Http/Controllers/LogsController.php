<?php

namespace App\Http\Controllers;

use App\Log_admin;
use App\Log_user;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function admin()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('logs.admin', $data);
    }

    public function admin_data()
    {
        $data = Log_admin::with('admins', 'saless', 'kioss', 'principles', 'aktifitass')->orderBy('created_at', 'DESC')->get();
        return datatables()->of($data)
            ->addColumn('admin', function ($data) {
                if ($data->id_admin) {
                    $nama_admin = $data->admins['name'];
                } else {
                    $nama_admin = '';
                }
                return $nama_admin;
            })
            ->addColumn('principle', function ($data) {
                if ($data->id_vendor) {
                    $principles = $data->principles['nama_principle'];
                } else {
                    $principles = '';
                }
                return $principles;
            })
            ->addColumn('date', function ($data) {
                $date = $data->created_at->toDateString();
                return $date;
            })
            ->make(true);
    }

    public function user()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('logs.user', $data);
    }

    public function user_data()
    {
        $data = Log_user::with('saless', 'kioss', 'principles', 'aktifitass')->orderBy('created_at', 'DESC')->get();
        return datatables()->of($data)
            ->addColumn('sales', function ($data) {
                if ($data->id_sales) {
                    $sales = $data->saless['nama_sales'];
                } else {
                    $sales = '';
                }
                return $sales;
            })
            ->addColumn('kios', function ($data) {
                if ($data->id_kios) {
                    $kios = $data->kioss['nama_Kios'];
                } else {
                    $kios = '';
                }
                return $kios;
            })
            ->addColumn('principle', function ($data) {
                if ($data->id_vendor) {
                    $principles = $data->principles['nama_principle'];
                } else {
                    $principles = '';
                }
                return $principles;
            })
            ->addColumn('aktifitas', function ($data) {
                if ($data->id_aktifitas) {
                    $aktifitas = $data->aktifitass['nama_aktifitas'];
                } 
                return $aktifitas;
            })
            ->addColumn('date', function ($data) {
                $date = $data->created_at->toDateString();
                return $date;
            })
            ->make(true);
    }
}
