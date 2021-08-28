<?php

namespace App\Http\Controllers;

use App\Category_product;
use App\Principle;
use App\Product;
use App\Riwayat_Stok;
use App\Stok;
use App\Traits\admin_logs;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('product.stock.index', $data);
    }

    public function data_index()
    {
        $data = Stok::with('products')->get();
        // $data['stok'] =
        return datatables()->of($data)
            ->addColumn('nama_principle', function ($data) {
                $nama_principle = DB::table('products')
                    ->where('products.id', $data->id_produk)
                    ->leftJoin('principles', 'principles.id', 'products.id_principle')
                    ->pluck('principles.nama_principle')->first();

                return $nama_principle;
            })
            ->addColumn('kategori', function ($data) {
                $kategori = DB::table('products')
                    ->where('products.id', $data->id_produk)
                    ->leftJoin('category_products', 'category_products.id', 'products.id_category_product')
                    ->pluck('category_products.nama_category')->first();

                return $kategori;
            })
            ->addColumn('nama_product', function ($data) {
                $nama_product = Product::where('id', $data->id_produk)->pluck('nama_product')->first();
                return $nama_product;
            })
            ->addColumn('stokn', function ($data) {
                $stok = $data->stok . ' ' . $data->products->satuan;
                return $stok;
            })
            ->make(true);
        // return view('product.index', $data);
    }

    public function add()
    {
        $data['categories'] = Category_product::all();
        $data['principles'] = Principle::all();

        $controller    = new Controller;
        $data['menus'] = $controller->menus();
        return view('product.stock.add', $data);
    }

    public function get_produk($category, $principle)
    {
        $products = Product::where('id_category_product', $category)->where('id_principle', $principle)->get();

        return response()->json($products);
    }

    public function get_satuan($id)
    {
        $products = Product::find($id);

        return response()->json($products);
    }

    public function get_stock($product_id)
    {
        $stocks = Riwayat_Stok::where('id_product', $product_id)->distinct('date')->get();

        return response()->json($stocks);
    }

    public function delete_stock($id_product, $tanggal, $jumlah)
    {
        $stok_awal = Stok::where('id_produk', $id_product)->pluck('stok')->first();
        Stok::where('id_produk', $id_product);
        admin_logs::addLogs("DEL-003", "Stock");
        // return redirect()->route('product-category');
    }

    public function store(Request $request, $product_id)
    {
        $data = $request->validate([
            'id_produk' => 'required',
            'stok'      => 'required',
        ]);
        $stok_awal = Stok::where('id_produk', $product_id)->pluck('stok')->first();
        $new_stok = $stok_awal + $data['stok'];

        Stok::where('id_produk', $product_id)->update([
            'stok'      => $new_stok,
            'date'      => date('Y-m-d'),
        ]);

        Riwayat_Stok::create([
            'id_product'  => $product_id,
            'date'        => date('Y-m-d'),
            'stok'        => $data['stok'],
            'status_stok' => 1,
            'created_by'  => Auth::user()->id,
        ]);

        admin_logs::addLogs("ADD-001", "Stock");
        return redirect()->route('stock');
    }

}
