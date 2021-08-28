<?php

namespace App\Http\Controllers;

use App\Aktivitas_Logs;
use App\Area;
use App\City;
use App\Departement;
use App\Fee_Admin;
use App\Kecamatan;
use App\Province;
use App\Role_Pembayaran;
use App\StatusTransaksiReward;
use App\Status_Cicilan;
use App\Status_pembayaran;
use App\Status_pengiriman;
use App\Status_transaksi;
use App\TipeCicilan;
use App\TipeKios;
use App\TipeTask;
use App\TipeUser;
use App\Traits\admin_logs;
use Datatables;
use DB;
use Illuminate\Http\Request;

class MasterController extends Controller
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

    public function province()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['provinces'] = Province::all();

        return view('master.province', $data);
    }
    public function addProvince()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['provinces'] = Province::all();

        return view('master.addProvince', $data);
    }
    public function storeProvince(Request $request)
    {
        $request->validate([
            'province_code' => 'required',
            'name'          => 'required',
        ]);

        $province                = new Province;
        $province->province_code = $request->province_code;
        $province->name          = $request->name;
        $province->status        = 1;
        $province->created_at    = date('Y-m-d H:m:s');
        $province->updated_at    = date('Y-m-d H:m:s');
        $province->save();

        admin_logs::addLogs("ADD-001", "Provinsi");
        return redirect()->route('provinsi');
    }
    public function editProvince($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data["prov"] = Province::find($id);

        return view('master.editProvince', $data);
    }

    public function updateProvince(Request $request)
    {
        $request->validate([
            'province_code' => 'required',
            'name'          => 'required',
        ]);

        $province                = Province::find($request->id);
        $province->province_code = $request->province_code;
        $province->name          = $request->name;
        $province->save();

        admin_logs::addLogs("UPD-002", "Provinsi");
        return redirect()->route('provinsi');
    }
    public function deleteProvince($id)
    {
        $province = Province::find($id);
        $province->delete();

        admin_logs::addLogs("DEL-003", "Provinsi");
        return redirect()->route('provinsi');
    }

    // KOTA
    public function city()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['cities'] = DB::table('cities')
            ->select('provinces.name as province_name', 'cities.city_code as city_code', 'cities.name as city_name', 'cities.id as id')
            ->leftJoin('provinces', 'cities.province_code', '=', 'provinces.province_code')
            ->whereNull('cities.deleted_at')
            ->whereNull('provinces.deleted_at')
            ->get();

        return view('master.city', $data);
    }

    public function addCity()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['cities']     = City::all();
        $data['provincies'] = Province::all();

        return view('master.addCity', $data);
    }

    public function storeCity(Request $request)
    {
        $request->validate([
            'province_code' => 'required',
            'city_code'     => 'required',
            'name'          => 'required',
        ]);

        $city                = new City;
        $city->city_code     = $request->city_code;
        $city->province_code = $request->province_code;
        $city->name          = $request->name;
        $city->status        = 1;
        $city->created_at    = date('Y-m-d H:m:s');
        $city->updated_at    = date('Y-m-d H:m:s');
        $city->save();

        admin_logs::addLogs("ADD-001", "City");
        return redirect()->route('kota');
    }
    public function editCity($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data["city"] = City::find($id);
        $data["prov"] = Province::all();

        return view('master.editCity', $data);
    }

    public function updateCity(Request $request)
    {
        $request->validate([
            'city_code' => 'required',
            'name'      => 'required',
            'province'  => 'required',
        ]);

        $city                = City::find($request->id);
        $city->province_code = $request->province;
        $city->city_code     = $request->city_code;
        $city->name          = $request->name;
        $city->updated_at    = date('Y-m-d H:m:s');
        $city->save();

        admin_logs::addLogs("UPD-002", "City");
        return redirect()->route('kota');
    }
    public function deleteCity($id)
    {
        $kota = City::find($id);
        $kota->delete();

        admin_logs::addLogs("DEL-003", "City");
        return redirect()->route('kota');
    }

    // KECAMATAN
    public function kecamatan()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['kecamatans'] = DB::table('kecamatans')
            ->select('kecamatans.id as id', 'provinces.name as province_name', 'cities.name as city_name', 'kecamatans.name')
            ->leftJoin('provinces', 'provinces.province_code', '=', 'kecamatans.province_code')
            ->leftJoin('cities', 'cities.city_code', '=', 'kecamatans.city_code')
            ->whereNull('provinces.deleted_at')
            ->whereNull('cities.deleted_at')
            ->whereNull('kecamatans.deleted_at')
            ->get();

        return view('master.kecamatan', $data);
    }

    public function getDataKecamatan()
    {
        $data = DB::table('kecamatans')
            ->select('kecamatans.id as id', 'provinces.name as province_name', 'cities.name as city_name', 'kecamatans.kecamatan_code as kecamatan_code', 'kecamatans.name')
            ->leftJoin('provinces', 'provinces.province_code', '=', 'kecamatans.province_code')
            ->leftJoin('cities', 'cities.city_code', '=', 'kecamatans.city_code')
            ->whereNull('provinces.deleted_at')
            ->whereNull('cities.deleted_at')
            ->whereNull('kecamatans.deleted_at')
            ->get();

        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="kecamatan/edit-kecamatan/' . $data->id . '">
            <button class="btn btn-xs btn-primary " type="button">
            <span class="btn-label"><i class="fa fa-file"></i></span>
            </button>
            </a>';
                $button .= '<button class="btn btn-xs btn-danger delete-button" deletevalue="' . $data->id . '" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                return $button;
            })->rawColumns(['action'])->make(true);
    }

    public function addKecamatan()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['kecamatans'] = Kecamatan::all();
        $data['cities']     = City::all();
        $data['provincies'] = Province::all();

        return view('master.addKecamatan', $data);
    }

    public function storeKecamatan(Request $request)
    {
        $request->validate([
            'province_code'  => 'required',
            'city_code'      => 'required',
            'kecamatan_code' => 'required',
            'name'           => 'required',
        ]);

        $kecamatan                 = new Kecamatan;
        $kecamatan->kecamatan_code = $request->kecamatan_code;
        $kecamatan->city_code      = $request->city_code;
        $kecamatan->province_code  = $request->province_code;
        $kecamatan->name           = $request->name;
        $kecamatan->status         = 1;
        $kecamatan->created_at     = date('Y-m-d H:m:s');
        $kecamatan->updated_at     = date('Y-m-d H:m:s');
        $kecamatan->save();

        admin_logs::addLogs("ADD-001", "Kecamatan");
        return redirect()->route('kecamatan');
    }
    public function editKecamatan($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['kecamatans'] = Kecamatan::find($id);
        $data['cities']     = City::where('province_code', $data['kecamatans']->province_code)->get();
        $data['provincies'] = Province::all();

        return view('master.editKecamatan', $data);
    }

    public function updateKecamatan(Request $request)
    {
        $request->validate([
            'kecamatan_code' => 'required',
            'name'           => 'required',
            'city'           => 'required',
            'province'       => 'required',
        ]);

        $kecamatan                 = Kecamatan::find($request->id);
        $kecamatan->kecamatan_code = $request->kecamatan_code;
        $kecamatan->province_code  = $request->province;
        $kecamatan->city_code      = $request->city;
        $kecamatan->name           = $request->name;
        $kecamatan->updated_at     = date('Y-m-d H:m:s');
        $kecamatan->save();

        admin_logs::addLogs("UPD-002", "Kecamatan");
        return redirect()->route('kecamatan');
    }
    public function deleteKecamatan($id)
    {
        $kecamatan = Kecamatan::find($id);
        $kecamatan->delete();

        admin_logs::addLogs("DEL-003", "Kecamatan");
        return redirect()->route('kecamatan');
    }

    //AREA
    public function area()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['areas'] = DB::table('areas')
            ->select('areas.id as id', 'provinces.name as province_name', 'cities.name as city_name', 'kecamatans.name as kecamatan_name', 'areas.name')
            ->leftJoin('provinces', 'provinces.province_code', '=', 'areas.province_code')
            ->leftJoin('cities', 'cities.city_code', '=', 'areas.city_code')
            ->leftJoin('kecamatans', 'kecamatans.kecamatan_code', '=', 'areas.kecamatan_code')
            ->whereNull('provinces.deleted_at')
            ->whereNull('cities.deleted_at')
            ->whereNull('kecamatans.deleted_at')
            ->whereNull('areas.deleted_at')
            ->get();

        return view('master.area', $data);
    }

    public function getDataArea()
    {
        $data = DB::table('areas')
            ->select('areas.id as id', 'provinces.name as province_name', 'cities.name as city_name', 'kecamatans.name as kecamatan_name', 'areas.area_code as area_code', 'areas.name')
            ->leftJoin('provinces', 'provinces.province_code', '=', 'areas.province_code')
            ->leftJoin('cities', 'cities.city_code', '=', 'areas.city_code')
            ->leftJoin('kecamatans', 'kecamatans.kecamatan_code', '=', 'areas.kecamatan_code')
            ->whereNull('provinces.deleted_at')
            ->whereNull('cities.deleted_at')
            ->whereNull('kecamatans.deleted_at')
            ->whereNull('areas.deleted_at')
            ->get();

        return \DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="area/edit-area/' . $data->id . '">
            <button class="btn btn-xs btn-primary " type="button">
            <span class="btn-label"><i class="fa fa-file"></i></span>
            </button>
            </a>';
                $button .= '<button class="btn btn-xs btn-danger delete-button" deletevalue="' . $data->id . '" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                return $button;
            })->rawColumns(['action'])->make(true);
    }

    public function addArea()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['kecamatans'] = Kecamatan::all();
        $data['cities']     = City::all();
        $data['provincies'] = Province::all();

        return view('master.addArea', $data);
    }

    public function storeArea(Request $request)
    {
        $request->validate([
            'name'           => 'required',
            'area_code'      => 'required',
            'kecamatan_code' => 'required',
            'city_code'      => 'required',
            'province_code'  => 'required',
        ]);

        foreach ($request->kecamatan_code as $key => $value) {
            # code...
            $kode_kecamatan       = $value;
            $area                 = new Area;
            $area->province_code  = $request->province_code;
            $area->city_code      = $request->city_code;
            $area->kecamatan_code = $kode_kecamatan;
            $area->area_code      = $request->area_code;
            $area->name           = $request->name;
            $area->status         = 1;
            $area->created_at     = date('Y-m-d H:m:s');
            $area->updated_at     = date('Y-m-d H:m:s');
            $area->save();
        }

        admin_logs::addLogs("ADD-001", "Area");
        return redirect()->route('area');
    }

    public function editArea($id)
    {
        $controller         = new Controller;
        $data['menus']      = $controller->menus();
        $data['areas']      = Area::find($id);
        $data['kecamatans'] = DB::table('areas as A')->select('A.kecamatan_code', 'K.name')
            ->leftJoin('kecamatans as K', 'K.kecamatan_code', '=', 'A.kecamatan_code')
            ->where('A.area_code', $data['areas']->area_code)
            ->whereNull('K.deleted_at')
            ->get();

        $data['provincies'] = Province::all();
        $data['cities']     = City::all();
        return view('master.editArea', $data);
    }

    public function updateArea(Request $request)
    {

        $request->validate([
            'name'           => 'required',
            'old_area_code'  => 'required',
            'area_code'      => 'required',
            'kecamatan_code' => 'required',
            'city_code'      => 'required',
            'province_code'  => 'required',
        ]);
        // get id dari area yang mempunyai kecamatan yang sama
        $idsofOldArea = DB::table('areas as A')->select('A.id')
            ->leftJoin('kecamatans as K', 'K.kecamatan_code', '=', 'A.kecamatan_code')
            ->where('A.area_code', $request->old_area_code)
            ->get();

        // Delete Old Data
        foreach ($idsofOldArea as $area) {
            foreach ($area as $id) {
                DB::table('areas')->where('id', $id)->delete();
            }
        }
        // Make new Data Behaving as Update Data
        foreach ($request->kecamatan_code as $key => $value) {
            # code...
            $kode_kecamatan       = $value;
            $area                 = new Area;
            $area->province_code  = $request->province_code;
            $area->city_code      = $request->city_code;
            $area->kecamatan_code = $kode_kecamatan;
            $area->area_code      = $request->area_code;
            $area->name           = $request->name;
            $area->status         = 1;
            $area->created_at     = date('Y-m-d H:m:s');
            $area->updated_at     = date('Y-m-d H:m:s');
            $area->save();
        }

        admin_logs::addLogs("UPD-002", "Area");
        return redirect()->route('area');
    }

    public function deleteArea($id)
    {
        $area = Area::find($id);
        $area->delete();

        admin_logs::addLogs("DEL-003", "Area");
        return redirect()->route('area');
    }

    public function listCities($idprovince)
    {
        $city = City::select('city_code', 'name')->where("province_code", $idprovince)->get();

        admin_logs::addLogs("DTL-004", "City");
        return response()->json($city);
    }
    public function listArea($idprovince)
    {
        $city = Area::select('area_code', 'name')->distinct()->where("city_code", $idprovince)->get();

        admin_logs::addLogs("DTL-004", "Area");
        return response()->json($city);
    }

    public function listKecamatan($idcity)
    {
        $city = Kecamatan::select('kecamatan_code', 'name')->where("city_code", $idcity)->get();

        admin_logs::addLogs("DTL-004", "Kecamatan");
        return response()->json($city);
    }

    // public function listAreaCode($areacode){
    //     $area = Area::select('area_code','name')->where("name", "==", $areacode."%")->get();
    //     return response()->json($area);
    // }

    public function getAutoArea(Request $request)
    {

        $search = $request->search;

        if ($search == '') {
            $area = Area::orderby('name', 'asc')->select('area_code', 'name')->limit(5)->distinct()->get();
        } else {
            $area = Area::orderby('name', 'asc')->select('area_code', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->distinct()->get();
        }

        $response = array();
        foreach ($area as $areas) {
            $response[] = array("value" => $areas->area_code, "label" => $areas->name);
        }

        echo json_encode($response);
        exit;
    }

    public function indexStatusTransaksi()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['status_transaksis'] = DB::table('status_transaksis')
            ->where('deleted_at', null)
            ->get();

        return view('master.status_transaksi', $data);
    }

    public function indexMetodePengiriman()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['status_pengirimans'] = DB::table('tipe_pengirimans')
            ->where('deleted_at', null)
            ->get();

        return view('master.metode_pengiriman', $data);
    }

    public function createStatusTransaksi()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master.addstatus_transaksi', $data);
    }

    public function createMetodePengiriman()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master.addmetode_pengiriman', $data);
    }

    public function storeStatusTransaksi(Request $request)
    {
        $request->validate([
            'nama_status' => 'required',
            'kode_status' => 'required',
            'urutan'      => 'required',
        ]);

        $status_transaksi              = new Status_transaksi;
        $status_transaksi->nama_status = $request->nama_status;
        $status_transaksi->kode_status = $request->kode_status;
        $status_transaksi->urutan      = $request->urutan;
        $status_transaksi->created_at  = date('Y-m-d H:m:s');
        $status_transaksi->updated_at  = date('Y-m-d H:m:s');
        $status_transaksi->save();

        admin_logs::addLogs("ADD-001", "Status Transaksi");
        return redirect()->route('status_transaksi');
    }

    public function storeMetodePengiriman(Request $request)
    {
        $request->validate([
            'nama_metode' => 'required',
            'kode_metode' => 'required',
        ]);

        $status_pengiriman              = new Status_pengiriman;
        $status_pengiriman->nama_metode = $request->nama_metode;
        $status_pengiriman->kode_metode = $request->kode_metode;
        $status_pengiriman->created_at  = date('Y-m-d H:m:s');
        $status_pengiriman->updated_at  = date('Y-m-d H:m:s');
        $status_pengiriman->save();

        admin_logs::addLogs("ADD-001", "Metode Pengiriman");
        return redirect()->route('metode_pengiriman');
    }

    public function editMetodePengiriman($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $status_pengiriman          = Status_pengiriman::where('id', $id)->first();
        $data['status_pengirimans'] = $status_pengiriman;

        return view('master.editmetode_pengiriman', $data);
    }

    public function updateMetodePengiriman(Request $request)
    {
        $status_pengiriman              = Status_pengiriman::find($request->id);
        $status_pengiriman->nama_metode = $request->nama_metode;
        $status_pengiriman->kode_metode = $request->kode_metode;
        $status_pengiriman->save();

        admin_logs::addLogs("UPD-002", "Metode Pengiriman");
        return redirect()->route('metode_pengiriman');
    }

    public function deleteStatusTransaksi($id)
    {
        $status_transaksi = Status_transaksi::find($id);
        $status_transaksi->delete();

        admin_logs::addLogs("DEL-003", "Status Transaksi");
        return redirect()->route('status_transaksi');
    }

    public function deleteMetodePengiriman($id)
    {
        $status_pengiriman = Status_pengiriman::find($id);
        $status_pengiriman->delete();

        admin_logs::addLogs("DEL-003", "Metode Pengiriman");
        return redirect()->route('metode_pengiriman');
    }

    public function indexMetodePembayaran()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['metode_pembayaran'] = Status_pembayaran::all();

        return view('master/metodePembayaran', $data);
    }

    public function addMetodePembayaran()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master/addmetodePembayaran', $data);
    }

    public function insertMetodePembayaran(Request $request)
    {
        $request->validate([
            'nama_metode'     => 'required',
            'kode_pembayaran' => 'required',
        ]);

        $metodePembayaran                  = new Status_pembayaran();
        $metodePembayaran->nama_metode     = $request->nama_metode;
        $metodePembayaran->kode_pembayaran = $request->kode_pembayaran;
        $metodePembayaran->save();

        admin_logs::addLogs("ADD-001", "Metode Pembayaran");
        return redirect()->route('metode_pembayaran');
    }

    public function deleteMetodePembayaran($id)
    {
        $metodePembayaran = Status_pembayaran::find($id);
        $metodePembayaran->delete();

        admin_logs::addLogs("DEL-003", "Metode Pembayaran");
        return redirect()->route('metode_pembayaran');
    }

    public function editMetodePembayaran($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['data'] = Status_pembayaran::find($id);
        return view('master.editmetodePembayaran', $data);
    }

    public function updateMetodePembayaran($id, Request $request)
    {
        $request->validate([
            'nama_metode'     => 'required',
            'kode_pembayaran' => 'required',
        ]);

        $metodePembayaran                  = Status_pembayaran::find($id);
        $metodePembayaran->nama_metode     = $request->nama_metode;
        $metodePembayaran->kode_pembayaran = $request->kode_pembayaran;
        $metodePembayaran->save();

        admin_logs::addLogs("UPD-002", "Metode Pembayaran");
        return redirect()->route('metode_pembayaran');
    }

    public function indexDepartment()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['data'] = Departement::all();
        return view('master/departement', $data);
    }

    public function addDepartment()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master/adddepartement', $data);
    }

    public function insertdepartement(Request $request)
    {
        $request->validate([
            'nama_departement' => 'required',
            'kode_departement' => 'required',
            'urutan'           => 'required',
            'deskripsi'        => 'required',
        ]);

        $departement                   = new Departement();
        $departement->nama_departement = $request->nama_departement;
        $departement->kode_departement = $request->kode_departement;
        $departement->deskripsi        = $request->deskripsi;
        $departement->urutan           = $request->urutan;
        $departement->save();

        admin_logs::addLogs("ADD-001", "Departemen");
        return redirect()->route('departement');
    }

    public function editdepartement($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['data'] = Departement::find($id);

        return view('master/editDepartement', $data);
    }

    public function updateDepartement($id, Request $request)
    {
        $request->validate([
            'nama_departement' => 'required',
            'kode_departement' => 'required',
            'urutan'           => 'required',
            'deskripsi'        => 'required',
        ]);

        $departement                   = new Departement();
        $departement                   = Departement::find($id);
        $departement->nama_departement = $request->nama_departement;
        $departement->kode_departement = $request->kode_departement;
        $departement->deskripsi        = $request->deskripsi;
        $departement->urutan           = $request->urutan;
        $departement->save();

        admin_logs::addLogs("UPD-002", "Departemen");
        return redirect()->route('departement');
    }

    public function deletedepartement($id)
    {
        $data = Departement::find($id);
        $data->delete();

        admin_logs::addLogs("DEL-003", "Departemen");
        return redirect()->route('departement');
    }

    //cicilan
    public function indexCicilan()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['data'] = TipeCicilan::all();
        return view('master.cicilanMaster', $data);
    }

    public function addCicilan()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master.addcicilan', $data);
    }

    public function insertCicilan(Request $request)
    {
        $request->validate([
            'tenor'         => 'required',
            'tipe'          => 'required',
            'day_per_month' => 'required',
            'status'        => 'required',
        ]);
        $cicilan                 = new TipeCicilan();
        $cicilan->tenor          = $request->tenor;
        $cicilan->tipe           = $request->tipe;
        $cicilan->day_per_mounth = $request->day_per_month;
        $cicilan->status         = $request->status;
        $cicilan->save();

        admin_logs::addLogs("ADD-001", "Master Tipe Cicilan");
        return redirect()->route('tipe_cicilan');
    }

    public function deleteCicilan($id)
    {
        $data = TipeCicilan::find($id);
        $data->delete();

        admin_logs::addLogs("DEL-003", "Master Tipe Cicilan");
        return redirect()->route('tipe_cicilan');
    }

    public function editCicilan($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['data'] = TipeCicilan::find($id);
        return view('master.editCicilan', $data);
    }
    public function updateCicilan(Request $request, $id)
    {
        $request->validate([
            'tenor'         => 'required',
            'tipe'          => 'required',
            'day_per_month' => 'required',
            'status'        => 'required',
        ]);

        $cicilan                 = new TipeCicilan();
        $cicilan                 = TipeCicilan::find($id);
        $cicilan->tenor          = $request->tenor;
        $cicilan->tipe           = $request->tipe;
        $cicilan->day_per_mounth = $request->day_per_month;
        $cicilan->status         = $request->status;
        $cicilan->save();

        admin_logs::addLogs("UPD-002", "Master Tipe Cicilan");
        return redirect()->route('tipe_cicilan');
    }
    public function indexTipeKios()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['data'] = DB::table('tipe_kios')
            ->where('tipe_kios.deleted_at', null)
            ->get();

        return view('master.tipeKios', $data);
    }

    public function addTipeKios()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master.addtipekios', $data);
    }

    public function inserttipekios(Request $request)
    {
        $request->validate([
            'nama_tipe' => 'required',
        ]);

        $tipeKios                 = new TipeKios();
        $tipeKios->nama_tipe_kios = $request->nama_tipe;
        $tipeKios->created_at     = date('Y-m-d H:m:s');
        $tipeKios->updated_at     = date('Y-m-d H:m:s');
        $tipeKios->save();

        admin_logs::addLogs("ADD-001", "Master Tipe Kios");
        return redirect()->route('tipe_kios');
    }
    public function editTipeKios($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['tipe_kios'] = TipeKios::find($id);

        return view('master.edittipeKios', $data);

    }
    public function updateTipeKios(Request $request, $id)
    {
        $request->validate([
            'nama_tipe_kios' => 'required',
        ]);

        $tipeKios                 = TipeKios::find($id);
        $tipeKios->nama_tipe_kios = $request->nama_tipe_kios;
        $tipeKios->save();

        admin_logs::addLogs("UPD-002", "Master Tipe Kios");
        return redirect()->route('tipe_kios');
    }

    public function deletetipekios($id)
    {
        $data = TipeKios::find($id);
        $data->delete();

        admin_logs::addLogs("DEL-003", "Master Tipe Kios");
        return redirect()->route('tipe_kios');
    }

    public function indexTipeUser()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['tipeusers'] = TipeUser::all();

        return view('master.tipeUser', $data);
    }

    public function addTipeUser()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['tipeusers'] = TipeUser::all();

        return view('master.addTipeUser', $data);
    }

    public function storeTipeUser(Request $request)
    {
        $request->validate([
            'kode_user' => 'required',
            'nama_kode' => 'required',
        ]);

        $tipeuser             = new TipeUser;
        $tipeuser->kode_user  = $request->kode_user;
        $tipeuser->nama_kode  = $request->nama_kode;
        $tipeuser->created_at = date('Y-m-d H:m:s');
        $tipeuser->updated_at = date('Y-m-d H:m:s');
        $tipeuser->save();

        admin_logs::addLogs("ADD-001", "Master Tipe User");
        return redirect()->route('tipe_user');
    }
    public function deletetipeuser($id)
    {
        $data = TipeUser::find($id);
        $data->delete();

        admin_logs::addLogs("DEL-003", "Master Tipe User");
        return redirect()->route('tipe_user');
    }

    public function indexTipeTask()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['data'] = TipeTask::all();
        return view('master.tipeTask', $data);
    }

    //feeadmin
    public function indexFeeAdmin()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['fee_admin'] = DB::table('fee_admin')
            ->where('deleted_at', null)
            ->get();

        return view('master.feeadmin', $data);
    }

    public function indexListFeeAdmin()
    {
        $fee_admin = Fee_Admin::all();
        return datatables()->of(Fee_Admin::latest()->get())
            ->addColumn('action', function ($data) {
                //m
                $button = '<a href="editfee-admin/' . $data->id . '">
                       <button class="btn btn-xs btn-primary " type="button">
                       <span class="btn-label"><i class="fa fa-file"></i></span>
                       </button>
                       </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button .= "&nbsp";
                return $button;
            })
            ->addColumn('tipe', function ($data) {
                $tipe = 'Nominal';
                if ($data->tipe == 1) {
                    $tipe = 'Prosentase';
                }
                return $tipe;
            })
            ->addColumn('status', function ($data) {
                $status = 'Tidak Aktif';
                if ($data->status == 1) {
                    $status = 'Aktif';
                }
                return $status;
            })
            ->rawColumns(['action'])->make(true);

    }

    public function createFeeAdmin()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master.addfee-admin', $data);
    }
    public function editFeeAdmin($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();
        $data['fee_admin'] = DB::table('fee_admin')
        ->where('deleted_at', null)
        ->where('id',$id)
        ->get();

        // dd($data);

        return view('master.editfee-admin', $data);
    }

    public function storeFeeAdmin(Request $request)
    {
        $request->validate([
            'tipe'          => 'required',
            'is_precentage' => 'required',
            'jumlah'        => 'required',
            'nominal'       => 'required',
            'status'        => 'required',
        ]);

        $fee_admin                = new Fee_Admin;
        $fee_admin->tipe          = $request->tipe;
        $fee_admin->is_precentage = $request->is_precentage;
        $fee_admin->jumlah        = preg_replace('/\D/', '', $request->jumlah);
        $fee_admin->nominal       = $request->nominal;
        $fee_admin->status        = $request->status;
        $fee_admin->created_at    = date('Y-m-d H:m:s');
        $fee_admin->updated_at    = date('Y-m-d H:m:s');
        $fee_admin->save();

        admin_logs::addLogs("ADD-001", "Fee Admin");
        return redirect()->route('fee_admin');
    }

    public function updateFeeAdmin(Request $request)
    {
        $request->validate([
            'tipe' => 'required',
            'is_precentage' => 'required',
            'jumlah' => 'required',
            'nominal' => 'required',
            'status' => 'required'
        ]);


        $feeadmin = Fee_Admin::find($request->id);
        $feeadmin->tipe = $request->tipe;
        $feeadmin->is_precentage = $request->is_precentage;
        $feeadmin->jumlah = $request->jumlah;
        $feeadmin->nominal = $request->nominal;
        $feeadmin->status = $request->status;
        $feeadmin->updated_at = date('Y-m-d H:m:s');
        $feeadmin->save();

        admin_logs::addLogs("UPD-001","Fee Admin");
        return redirect()->route('fee_admin');
    }

    public function deleteFeeAdmin($id)
    {
        $data = Fee_Admin::find($id);
        $data->delete();

        admin_logs::addLogs("DEL-003", "Fee Admin");
        return redirect()->route('fee_admin');
    }

    //feeadmin
    public function indexRolePembayaran()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['role_pembayarans'] = DB::table('role_pembayarans')
            ->select('role_pembayarans.*', 'tipe_kios.nama_tipe_kios as nama_tipe_kios', 'tipe_pembayarans.nama_metode as nama_tipe_pembayaran')
            ->leftJoin('tipe_kios', 'tipe_kios.id', 'role_pembayarans.id_tipe_kios')
            ->leftJoin('tipe_pembayarans', 'tipe_pembayarans.id', 'role_pembayarans.id_tipe_pembayaran')
            ->whereNull('role_pembayarans.deleted_at')
            ->get();

        return view('master.rolepembayaran', $data);
    }

    public function createRolePembayaran()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['tipe_pembayarans'] = DB::table('tipe_pembayarans')
            ->whereNull('deleted_at')
            ->get();
        $data['tipe_kios'] = DB::table('tipe_kios')
            ->whereNull('deleted_at')
            ->get();

        return view('master.addrole_pembayaran', $data);
    }

    public function storeRolePembayaran(Request $request)
    {
        $request->validate([
            'id_tipe_kios'       => 'required',
            'id_tipe_pembayaran' => 'required',
        ]);

        $role_pembayaran                     = new Role_Pembayaran;
        $role_pembayaran->id_tipe_kios       = $request->id_tipe_kios;
        $role_pembayaran->id_tipe_pembayaran = $request->id_tipe_pembayaran;
        $role_pembayaran->created_at         = date('Y-m-d H:m:s');
        $role_pembayaran->updated_at         = date('Y-m-d H:m:s');
        $role_pembayaran->save();

        admin_logs::addLogs("ADD-001", "Role Pembayaran");
        return redirect()->route('role_pembayaran');
    }

    public function editRolePembayaran($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $role_pembayaran          = Role_Pembayaran::where('id', $id)->get();
        $data['role_pembayarans'] = $role_pembayaran;

        $data['tipe_pembayarans'] = DB::table('tipe_pembayarans')
            ->whereNull('deleted_at')
            ->get();
        $data['tipe_kios'] = DB::table('tipe_kios')
            ->whereNull('deleted_at')
            ->get();

        return view('master.editrole_pembayaran', $data);
    }

    public function updateRolePembayaran(Request $request)
    {
        $role_pembayaran                     = Role_Pembayaran::find($request->id);
        $role_pembayaran->id_tipe_kios       = $request->id_tipe_kios;
        $role_pembayaran->id_tipe_pembayaran = $request->id_tipe_pembayaran;
        $role_pembayaran->save();

        admin_logs::addLogs("UPD-002", "Role Pembayaran");
        return redirect()->route('role_pembayaran');
    }

    public function deleteRolePembayaran($id)
    {
        $role_pembayaran = Role_Pembayaran::find($id);
        $role_pembayaran->delete();

        admin_logs::addLogs("DEL-003", "Role Pembayaran");
        return redirect()->route('role_pembayaran');
    }

    //Status Cicilan
    // public function indexStatusCicilan()
    // {
    //     $controller = new Controller;
    //     $data['menus'] = $controller->menus();

    //     $data['aktifity_logs'] = DB::table('aktifity_logs')
    //     ->get();

    //     return view('master.aktifity_logs', $data);
    // }
    public function indexAktivitasLog()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['aktifity_logs'] = DB::table('aktifity_logs')
            ->get();

        return view('master.aktifity_logs', $data);
    }

    public function indexListAktivitasLog()
    {
        $aktifity_logs = Aktivitas_Logs::all();
        return datatables()->of(Aktivitas_Logs::latest()->get())
            ->addColumn('action', function ($data) {
                //m
                $button = '<a href="edit-aktifitaslog/' . $data->id . '">
             <button class="btn btn-xs btn-primary " type="button">
             <span class="btn-label"><i class="fa fa-file"></i></span>
             </button>
             </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button .= "&nbsp";
                return $button;
            })->rawColumns(['action'])->make(true);
    }

    public function addAktivitasLog()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master.add-aktifitaslog', $data);
    }

    public function storeAktifitasLog(Request $request)
    {
        $request->validate([
            'nama_aktifitas' => 'required',
            'kode_aktifitas' => 'required',
        ]);

        $aktifity_logs                 = new Aktivitas_Logs;
        $aktifity_logs->nama_aktifitas = $request->nama_aktifitas;
        $aktifity_logs->kode_aktifitas = $request->kode_aktifitas;
        $aktifity_logs->created_at     = date('Y-m-d H:m:s');
        $aktifity_logs->updated_at     = date('Y-m-d H:m:s');
        $aktifity_logs->save();

        admin_logs::addLogs("ADD-001", "Aktivitas Log");
        return redirect()->route('aktifitas_logs');
    }

    public function editAktifitasLog($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['aktifity_logs'] = Aktivitas_Logs::find($id);

        return view('master.edit-aktifitaslog', $data);
    }

    public function deleteAktifitasLog($id)
    {
        $data = Aktivitas_Logs::find($id);
        $data->delete();

        admin_logs::addLogs("DEL-003", "Aktivitas Log");
        return redirect()->route('aktifitas_logs');
    }

    public function indexStatusCicilan()
    {
        $controller             = new Controller;
        $data['menus']          = $controller->menus();
        $data['status_cicilan'] = DB::table('status_cicilan')
            ->where('deleted_at', null)
            ->get();

        return view('master.status_cicilan', $data);
    }
    public function updateAktifitasLog(Request $request)
    {
        $aktifity_logs                 = Aktivitas_Logs::find($request->id);
        $aktifity_logs->nama_aktifitas = $request->nama_aktifitas;
        $aktifity_logs->kode_aktifitas = $request->kode_aktifitas;
        $aktifity_logs->save();

        admin_logs::addLogs("UPD-002", "Aktivitas Log");
        return redirect()->route('aktifitas_logs');
    }

    // public function deleteAktifitasLog($id)
    // {
    //     $data=Aktivitas_Logs::find($id);
    //     $data->delete();
    //     return redirect()->route('aktifitas_logs');
    // }

    public function indexListStatusCicilan()
    {
        $status_cicilan = Status_Cicilan::all();
        return datatables()->of(Status_Cicilan::latest()->get())
            ->addColumn('action', function ($data) {
                //m
                $button = '<a href="edit-statuscicilan/' . $data->id . '">
               <button class="btn btn-xs btn-primary " type="button">
               <span class="btn-label"><i class="fa fa-file"></i></span>
               </button>
               </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button .= "&nbsp";
                return $button;
            })
            ->addColumn('status', function ($data) {
                $status = 'Tidak Aktif';
                if ($data->status == 1) {
                    $status = 'Aktif';
                }
                return $status;
            })
            ->rawColumns(['action'])->make(true);

    }
    public function addStatusCicilan()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();
        return view('master.add-statuscicilan', $data);
    }

    public function storeStatusCicilan(Request $request)
    {
        $request->validate([
            'nama_status' => 'required',
            'kode'        => 'required',
            'status'      => 'required',
        ]);

        $status_cicilan              = new Status_Cicilan;
        $status_cicilan->nama_status = $request->nama_status;
        $status_cicilan->kode        = $request->kode;
        $status_cicilan->status      = $request->status;
        $status_cicilan->created_at  = date('Y-m-d H:m:s');
        $status_cicilan->updated_at  = date('Y-m-d H:m:s');
        $status_cicilan->save();

        admin_logs::addLogs("ADD-001", "Master Status Cicilan");
        return redirect()->route('status_cicilan');
    }

    public function editStatusCicilan($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data["status_cicilan"] = Status_Cicilan::find($id);
        return view('master.edit-statuscicilan', $data);
    }

    public function updateStatusCicilan(Request $request)
    {
        $request->validate([
            'nama_status' => 'required',
            'kode'        => 'required',
            'status'      => 'required',
        ]);

        $status_cicilan              = Status_Cicilan::find($request->id);
        $status_cicilan->nama_status = $request->nama_status;
        $status_cicilan->kode        = $request->kode;
        $status_cicilan->status      = $request->status;
        $status_cicilan->save();

        admin_logs::addLogs("UPD-002", "Master Status Cicilan");
        return redirect()->route('status_cicilan');
    }

    public function deleteStatusCicilan($id)
    {
        $status_cicilan = Status_Cicilan::find($id);
        $status_cicilan->delete();

        admin_logs::addLogs("DEL-003", "Master Status Cicilan");
        return redirect()->route('status_cicilan');
    }

    public function indexStatusReward()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();
        return view('master.statustransaksi-reward', $data);

    }

    public function indexListStatusReward()
    {
        $status_reward = StatusTransaksiReward::all();
        return datatables()->of(StatusTransaksiReward::latest()->get())
            ->addColumn('action', function ($data) {
                //m
                $button = '<a href="edit-statusreward/' . $data->id . '">
                       <button class="btn btn-xs btn-primary " type="button">
                       <span class="btn-label"><i class="fa fa-file"></i></span>
                       </button>
                       </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button .= "&nbsp";
                return $button;
            })
            ->rawColumns(['action'])->make(true);

    }

    public function addStatusReward()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();
        return view('master.addstatus-transaksireward', $data);
    }

    public function storeStatusReward(Request $request)
    {
        $request->validate([
            'nama_status' => 'required',
            'kode_status' => 'required',
        ]);

        $status_reward              = new StatusTransaksiReward;
        $status_reward->nama_status = $request->nama_status;
        $status_reward->kode_status = $request->kode_status;
        $status_reward->created_at  = date('Y-m-d H:m:s');
        $status_reward->updated_at  = date('Y-m-d H:m:s');
        $status_reward->save();

        return redirect()->route('statustransaksi-reward');
    }

    public function editStatusReward($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data["status_reward"] = StatusTransaksiReward::find($id);
        return view('master.editstatus-transaksireward', $data);
    }

    public function updateStatusReward(Request $request)
    {
        $request->validate([
            'nama_status' => 'required',
            'kode_status' => 'required',
        ]);

        $status_reward              = StatusTransaksiReward::find($request->id);
        $status_reward->nama_status = $request->nama_status;
        $status_reward->kode_status = $request->kode_status;
        $status_reward->save();

        return redirect()->route('statustransaksi-reward');
    }

    public function deleteStatusReward($id)
    {
        $status_reward = StatusTransaksiReward::find($id);
        $status_reward->delete();

        return redirect()->route('statustransaksi-reward');
    }

}
