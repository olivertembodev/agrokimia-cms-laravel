<?php

namespace App\Http\Controllers;

use App\Limit_kredit;
use Illuminate\Http\Request;

class LimitKreditController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master.limit_kredit.index', $data);
    }

    public function data_index()
    {
        $data = Limit_kredit::all();
        return datatables()->of($data)
            ->addColumn('c_batas_kredit', function ($data) {
                $batas_kredit = 'Rp. '. number_format($data->batas_kredit, 0, ",", ".");
                return $batas_kredit;
            })
            ->addColumn('maksimal', function ($data) {
                $maksimal = 'Rp. '. number_format($data->maksimal_boleh_kredit, 0, ",", ".");
                return $maksimal;
            })
            ->addColumn('action', function ($data) {
                $button = '<a href="' . action('LimitKreditController@edit', ['id' => $data->id]) . '"><button class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></button>
                    </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#delete-modal"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button .= "&nbsp";
                return $button;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function create()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('master.limit_kredit.add', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'batas_kredit'          => 'required',
            'tipe'                  => 'required',
            'maksimal_boleh_kredit' => 'required',
        ]);
        $data['batas_kredit']          = preg_replace('/\D/', '', $data['batas_kredit']);
        $data['maksimal_boleh_kredit'] = preg_replace('/\D/', '', $data['maksimal_boleh_kredit']);
        $data['urutan'] = $request->urutan;
        Limit_kredit::create($data);

        return redirect()->route('limit-kredit');
    }

    public function edit($id)
    {
        $controller     = new Controller;
        $data['menus']  = $controller->menus();
        $data['kredit'] = Limit_kredit::where('id',$id)->first();
        $data['kredit']['batas_kredit']          = 'Rp. '. number_format($data['kredit']['batas_kredit'], 0, ",", ".");
        $data['kredit']['maksimal_boleh_kredit'] = 'Rp. '. number_format($data['kredit']['maksimal_boleh_kredit'], 0, ",", ".");
        $data['kredit']['urutan'] = $data['kredit']['urutan'];

        return view('master.limit_kredit.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'batas_kredit'          => 'required',
            'tipe'                  => 'required',
            'maksimal_boleh_kredit' => 'required',
        ]);
        $data['batas_kredit']          = preg_replace('/\D/', '', $data['batas_kredit']);
        $data['maksimal_boleh_kredit'] = preg_replace('/\D/', '', $data['maksimal_boleh_kredit']);
        $data['urutan'] = $request->urutan;
        Limit_kredit::find($id)->update($data);

        return redirect()->route('limit-kredit');
    }

    public function destroy($id)
    {
        Limit_kredit::destroy($id);
        return redirect()->route('limit-kredit');
    }
}
