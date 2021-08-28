<?php

namespace App\Http\Controllers;

use App\Promo;
use App\Promo_type;
use App\Traits\admin_logs;
use Illuminate\Http\Request;

class PromoController extends Controller
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

    public function index()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('promo.promo', $data);
    }

    public function getindexPromo()
    {
        $promo = Promo::all();
        return datatables()->of(Promo::latest()->get())
            ->addColumn('action', function ($data) {
                $button = '<a href="' . route("edit-promo", $data->id) . '">
            <button class="btn btn-xs btn-primary " type="button">
            <span class="btn-label"><i class="fa fa-file"></i></span>
            </button>
            </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button .= "&nbsp";
                $button .= '<a href="' . route("show-promo", $data->id) . '" class="btn btn-xs btn-warning " type="button"><span class="btn-label"><i class="fa fa-eye"></i></span></a>';
                return $button;
            })
            ->addColumn('c_potongan', function ($data) {
                $potongan = 'Rp. '. number_format($data->potongan,0,",",".");
                return $potongan;
            })
            ->rawColumns(['action'])->make(true);

    }

    public function create()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['type_promo'] = Promo_type::all();

        return view('promo.addpromo', $data);

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kupon'        => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'is_percentage'     => 'required',
            'minimal_transaksi' => 'required',
            'potongan'          => 'required',
            'type_id'           => 'required',
            'max_potongan'      => 'required',
        ]);
        $data['max_potongan']      = intval(preg_replace('/\D/', '', $data['max_potongan']));
        $data['minimal_transaksi'] = intval(preg_replace('/\D/', '', $data['minimal_transaksi']));
        $data['potongan']          = intval(preg_replace('/\D/', '', $data['potongan']));
        
        Promo::create($data);
        admin_logs::addLogs("ADD-001","Promo");
        return redirect()->route('list-promo');
    }

    public function show(Promo $promo, $id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['promo'] = Promo::where('id', $id)->with('promo_types')
            ->first();

        $data['promo']['potongan'] = 'Rp. '. number_format($data['promo']['potongan'],0,",",".");

        admin_logs::addLogs("DTL-004","Promo");
        return view('promo.show', $data);
    }

    public function edit($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data["type_promo"] = Promo_type::all();
        $data["promo"]      = Promo::where('id', $id)->with('promo_types')->first();

        $data['promo']['minimal_transaksi'] = 'Rp. '. number_format($data['promo']['minimal_transaksi'],0,",",".");
        $data['promo']['potongan'] = 'Rp. '. number_format($data['promo']['potongan'],0,",",".");
        $data['promo']['max_potongan'] = 'Rp. '. number_format($data['promo']['max_potongan'],0,",",".");

        return view('promo.editpromo', $data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_kupon'        => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'is_percentage'     => 'required',
            'minimal_transaksi' => 'required',
            'potongan'          => 'required',
            'max_potongan'      => 'required',
            'type_id'           => 'required',
        ]);

        $data['max_potongan']      = intval(preg_replace('/\D/', '', $data['max_potongan']));
        $data['minimal_transaksi'] = intval(preg_replace('/\D/', '', $data['minimal_transaksi']));
        $data['potongan']          = intval(preg_replace('/\D/', '', $data['potongan']));

        Promo::where('id', $id)->update($data);
        admin_logs::addLogs("UPD-002","Promo");
        return redirect()->route('list-promo');
    }

    public function delete($id)
    {
        $promo = Promo::find($id);
        $promo->delete();
        admin_logs::addLogs("DEL-003","Promo");
        return redirect()->route('list-promo');
    }

    public function indexTipePromo()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('promo.tipePromo', $data);
    }

    public function getindexTipePromo()
    {
        $promo_type = Promo_type::all();
        return datatables()->of(Promo_type::latest()->get())
            ->addColumn('action', function ($data) {
                //m
                $button = '<a href="' . route("edit-tipe-promo", $data->id) . '">
            <button class="btn btn-xs btn-primary " type="button">
            <span class="btn-label"><i class="fa fa-file"></i></span>
            </button>
            </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#confirm-delete"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                return $button;
            })
            ->rawColumns(['action'])->make(true);

    }

    public function addTipePromo()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('promo.addTipePromo', $data);
    }

    public function insertTipePromo(Request $request)
    {
        $data = $request->validate([
            'nama_type' => 'required',
        ]);
        Promo_type::create($data);
        admin_logs::addLogs("ADD-001","Tipe Promo");
        return redirect()->route('list-tipe-promo');

    }

    public function editTipePromo($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();
        $data['data']  = Promo_type::find($id);

        return view('promo.editTipePromo', $data);
    }

    public function updateTipePromo(Request $request, $id)
    {
        $tipe_promo            = new Promo_type();
        $tipe_promo            = Promo_type::find($id);
        $tipe_promo->nama_type = $request->nama_tipe_promo;
        $tipe_promo->save();
        admin_logs::addLogs("UPD-002","Tipe Promo");
        return redirect()->route('list-tipe-promo');
    }

    public function deleteTipePromo($id)
    {
        $data = Promo_type::find($id);
        $data->delete();
        admin_logs::addLogs("DEL-003","Tipe Promo");
        return redirect()->route('list-tipe-promo');

    }
}
