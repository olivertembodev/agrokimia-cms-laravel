<?php

namespace App\Http\Controllers;

use App\Product;
use App\Top_product;
use Illuminate\Http\Request;

class TopProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function top_product()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        // $data['products'] = Top_product::distinct('id_product')->with('products')->get();
        // $data['date']     = date('Y-m-d');

        return view('product.top_product.index', $data);
    }

    public function get_top_product(Request $request)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['products'] = Top_product::distinct('id_product')->with('products')->get();

        $data['date'] = $request->input('expired_top_product');
        // dd($data);

        return view('product.top_product.index', $data);
    }

    public function list_top_product(Request $request)
    {

        $data = Top_product::with('products')->get();

        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                $button = '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#delete-modal"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $cek = Top_product::pluck('id_product');
        $data['products'] = Product::whereNotIn('id', $cek)->get();

        return view('product.top_product.add', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_product'          => 'required',
            'expired_top_product' => 'required',
        ]);

        foreach ($data['id_product'] as $value) {
            Top_product::create([
                'id_product'          => $value,
                'expired_top_product' => $data['expired_top_product'],
            ]);
        }

        return redirect()->route('top-product');
    }


    public function destroy($id)
    {
        Top_product::destroy($id);
    }
}
