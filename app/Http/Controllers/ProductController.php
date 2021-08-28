<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Category_product;
use App\Classes\upload;
use App\Principle;
use App\Product;
use App\Product_image;
use App\Riwayat_Stok;
use App\Stok;
use App\Traits\admin_logs;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('product.index', $data);
    }

    public function riwayat_stock()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('product.stock.riwayat.riwayat', $data);
    }

    public function detail_riwayat_stock($id)
    {
        $stocks = Riwayat_Stok::with('products', 'transaksis')->where('id', $id)->first();
        // if (!isset($stocks->transaksis->nama_status)) {
        //     $stocks->transaksis->nama_status = 'status_transaksi tidak ditemukan';
        // }
        return response()->json($stocks);
    }

    public function get_riwayat_stock(Request $request)
    {
        $data = Riwayat_Stok::with('products', 'transaksis', 'admins')->orderBy('date', 'DESC')->get();

        return datatables()->of($data)
            ->addColumn('status', function ($data) {
                if ($data->status_stok == 1) {
                    $status = "Penambahan";
                } else {
                    $status = "Pengurangan";
                }

                return $status;
            })
            ->addColumn('stokn', function ($data) {
                $stok = $data->stok . ' ' . $data->products->satuan;
                return $stok;
            })
            ->addColumn('status_transaksi', function ($data) {
                $status = $data->transaksis->nama_status ?? '';
                return $status;
            })
            ->addColumn('created', function ($data) {
                $created = $data->admins->name ?? '';
                return $created;
            })
            ->addColumn('produk', function ($data) {
                $created = $data->products->nama_product ?? '';
                return $created;
            })
            ->rawColumns(['detail'])
            ->make(true);
    }

    public function data_index()
    {
        $check_principle = Auth::user()->id_principle;
        if ($check_principle == null) {
            $data = Product::with('principles', 'categories', 'stocks', 'images')->whereNull('deleted_at')->get();
        } else {
            $data = Product::with('principles', 'categories', 'stocks', 'images')->where('id_principle', $check_principle)->whereNull('deleted_at')->get();
        }
        // $data['stok'] =
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                //m
                $button = '<a href="' . action('ProductController@edit', ['id' => $data->id]) . '"><button class="btn btn-xs btn-primary " type="button"><span class="btn-label"><i class="fa fa-file"></i></span></button>
                    </a>';
                $button .= '<button class="btn btn-xs btn-danger" data-record-id="' . $data->id . '" data-record-title="The first one" data-toggle="modal" data-target="#delete-modal"><span class="btn-label"><i class="fa fa-trash"></i></span></button>';
                $button .= "&nbsp";
                $button .= '<a href="' . action('ProductController@show', ['id' => $data->id]) . '"><button type="button" class="btn btn-xs btn-warning btnDetail"><span class="btn-label"><i class="fa fa-eye"></i></span></button></a>';
                return $button;
            })
            ->addColumn('c_harga_jual', function ($data) {
                $c_harga_jual = 'Rp. ' . number_format($data->harga_jual, 0, ",", ".") . ' / '. $data->satuan;
                return $c_harga_jual;
            })
            ->addColumn('c_harga_beli', function ($data) {
                $c_harga_beli = 'Rp. ' . number_format($data->harga_beli, 0, ",", ".") . ' / '. $data->satuan;
                return $c_harga_beli;
            })
            ->addColumn('stok', function ($data) {
                $stok = $data->stocks->stok . ' ' . $data->satuan;
                return $stok;
            })
            ->rawColumns(['action'])->make(true);
        // return view('product.index', $data);
    }

    public function add()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['categories'] = Category_product::all();
        $data['principles'] = Principle::all();

        return view('product.add', $data);
    }

    public function store(Request $request)
    {
        $dataProduct = $request->validate([
            'id_category_product' => 'required',
            'id_principle'        => 'required',
            'nama_product'        => 'required',
            'berat_product'       => 'required',
            'lot_product'         => 'required',
            'deskripsi'           => 'required',
            'cara_pakai'          => 'required',
            'expired_date'        => 'required',
            'harga_jual'          => 'required',
            'harga_beli'          => 'required',
            'reward_poin'         => 'required',
            'satuan'              => 'required',
        ]);

        $check_principle = Auth::user()->id_principle;

        if ($check_principle == null) {
            $dataProduct['created_by'] = Auth::user()->id;
        } else {
            $dataProduct['created_by'] = Auth::user()->id_principle;
        }

        $data = $request->validate([
            'stok' => 'required',
            'date' => 'required',
        ]);
        $data['image'] = $request->file('image');

        $dataProduct['harga_jual'] = intval(preg_replace('/\D/', '', $dataProduct['harga_jual']));
        $dataProduct['harga_beli'] = intval(preg_replace('/\D/', '', $dataProduct['harga_beli']));

        $product_id = DB::table('products')->insertGetId($dataProduct);

        if ($data['image']) {
            foreach ($data['image'] as $image) {
                $upload = new upload();
                Product_image::create([
                    'product_id' => $product_id,
                    'image'      => $upload->img($image),
                ]);
            }
        } else {
            Product_image::create([
                'product_id' => $product_id,
                'image'      => env('DEFAULT_IMAGE'),
            ]);
        }

        $stok = 0;
        for ($i = 0; $i < count($data['stok']); $i++) {

            Riwayat_Stok::create([
                'id_product'  => $product_id,
                'stok'        => $data['stok'][$i],
                'status_stok' => 1,
                'date'        => $data['date'][$i],
                'created_by'  => Auth::user()->id,
            ]);
            $stok += $data['stok'][$i];
        }

        Stok::create([
            'id_produk' => $product_id,
            'stok'      => $stok,
            'date'      => date('Y-m-d'),
        ]);

        admin_logs::addLogs("ADD-001", "Product");
        return redirect()->route('list-product');
    }

    public function show($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['product']               = Product::where('id', $id)->with('principles', 'categories', 'stocks', 'images')->first();
        $data['product']['harga_jual'] = number_format($data['product']['harga_jual'], 0, ",", ".");
        $data['product']['harga_beli'] = number_format($data['product']['harga_beli'], 0, ",", ".");

        $is_principle = Administrator::where('id_principle', $data['product']['created_by'])->exists();

        if ($is_principle == true) {
            $data['product']['dibuat'] = Administrator::where('id_principle', $data['product']['created_by'])->pluck('name')->first();
        } else {
            $data['product']['dibuat'] = Administrator::where('id', $data['product']['created_by'])->pluck('name')->first();
        }

        admin_logs::addLogs("DTL-004", "Product");
        return view('product.show', $data);

    }

    public function edit($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['categories'] = Category_product::all();
        $data['principles'] = Principle::all();
        $data['images']     = Product_image::where('product_id', $id)->get();
        $data['product']    = Product::where('id', $id)->with('principles', 'categories')
            ->with(['riwayats' => function ($query) {$query->distinct('date');}])->first();
        $data['product']['harga_jual'] = 'Rp. ' . number_format($data['product']['harga_jual'], 0, ",", ".");
        $data['product']['harga_beli'] = 'Rp. ' . number_format($data['product']['harga_beli'], 0, ",", ".");

        #stok
        foreach ($data['product']['riwayats'] as $key => $value) {
            $min = Riwayat_Stok::where('date', $value->date)->where('status_stok', 2)->where('id_product', $id)->pluck('stok')->toArray();
            $min = array_sum($min);

            $ples = Riwayat_Stok::where('date', $value->date)->where('status_stok', 1)->where('id_product', $id)->pluck('stok')->toArray();
            $ples = array_sum($ples);

            $dateStr        = date("Ymd", strtotime($value->date));
            $value->date_id = $dateStr;
            $value->stok    = $ples - $min;

            // $i['awal'][] = $value->stok;
            // $i['min'][]  = $min;
            // $i['ples'][] = $ples;
        }

        return view('product.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $dataProduct = $request->validate([
            'id_category_product' => 'required',
            'id_principle'        => 'required',
            'nama_product'        => 'required',
            'berat_product'       => 'required',
            'lot_product'         => 'required',
            'deskripsi'           => 'required',
            'cara_pakai'          => 'required',
            'expired_date'        => 'required',
            'harga_jual'          => 'required',
            'harga_beli'          => 'required',
            'reward_poin'         => 'required',
            'satuan'              => 'required',
        ]);

        $data['date']     = $request->input('date');
        $data['new_date'] = $request->input('new_date');
        $data['stok']     = $request->input('stok');
        $data['new_stok'] = $request->input('new_stok');
        // dd($data);
        $dataProduct['harga_jual'] = intval(preg_replace('/\D/', '', $dataProduct['harga_jual']));
        $dataProduct['harga_beli'] = intval(preg_replace('/\D/', '', $dataProduct['harga_beli']));

        Product::find($id)->update($dataProduct);

        if ($request->file('images')) {
            Product_image::where('product_id', $id)->delete();
            foreach ($request->file('images') as $image) {
                $upload = new upload();
                Product_image::create([
                    'product_id' => $id,
                    'image'      => $upload->img($image),
                ]);
            }
        }

        foreach ($data['stok'] as $k => $v) {
            $prev_stok = Stok::where('id_produk', $id)->pluck('stok')->first();

            $min = Riwayat_Stok::where('date', $data['date'][$k])
                ->where('id_product', $id)
                ->where('status_stok', 2)
                ->pluck('stok')->toArray();
            $min = array_sum($min);

            $ples = Riwayat_Stok::where('date', $data['date'][$k])
                ->where('id_product', $id)
                ->where('status_stok', 1)
                ->pluck('stok')->toArray();
            $ples = array_sum($ples);

            $stok_awal = $ples - $min;

            if ($stok_awal < $v) {

                $stok = $v - $stok_awal;
                Riwayat_Stok::create([
                    'id_product'  => $id,
                    'date'        => $data['date'][$k],
                    'stok'        => $stok,
                    'status_stok' => 1,
                    'created_by'  => Auth::user()->id,
                ]);
                $cur_stok = $prev_stok + $stok;

                Stok::where('id_produk', $id)->update([
                    'stok' => $cur_stok,
                ]);

            } else if ($stok_awal > $v) {

                $stok = $stok_awal - $v;
                Riwayat_Stok::create([
                    'id_product'  => $id,
                    'date'        => $data['date'][$k],
                    'stok'        => $stok,
                    'status_stok' => 2,
                    'created_by'  => Auth::user()->id,
                ]);
                $cur_stok = $prev_stok - $stok;

                Stok::where('id_produk', $id)->update([
                    'stok' => $cur_stok,
                ]);
            }
        }

        if ($data['new_date']) {
            $add_stok   = 0;
            $prev_stok2 = Stok::where('id_produk', $id)->pluck('stok')->first();

            foreach ($data['new_date'] as $k => $v) {
                Riwayat_Stok::create([
                    'id_product'  => $id,
                    'date'        => $v,
                    'stok'        => $data['new_stok'][$k],
                    'status_stok' => 1,
                    'created_by'  => Auth::user()->id,
                ]);
                $add_stok += $data['new_stok'][$k];
            }

            $new_stok = $prev_stok + $add_stok;
            Stok::where('id_produk', $id)->update([
                'stok' => $new_stok,
            ]);
        }

        admin_logs::addLogs("UPD-002", "Product");
        return redirect()->route('list-product');
    }

    public function delete($id)
    {
        Product::destroy($id);
        admin_logs::addLogs("DEL-003", "Product");
    }

    public function category()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['categories'] = Category_product::all();

        return view('product.category.index', $data);
    }

    public function add_category()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('product.category.add', $data);
    }

    public function store_category(Request $request)
    {
        $data = $request->validate([
            'nama_category' => 'required',
            'icon'          => 'max:2048',
        ]);

        if ($request->file('icon')) {
            $upload       = new upload();
            $data['icon'] = $upload->img($request->file('icon'));
        } else {
            $data['icon'] = env('DEFAULT_IMAGE');
        }

        Category_product::create($data);
        admin_logs::addLogs("ADD-001", "Kategori Product");
        return redirect()->route('product-category');
    }

    public function edit_category($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['category'] = Category_product::where('id', $id)->first();

        return view('product.category.edit', $data);
    }

    public function update_category(Request $request, $id)
    {
        $data = $request->validate([
            'nama_category' => 'required',
            'icon'          => 'max:2048',
        ]);

        if ($request->file('icon')) {
            $upload       = new upload();
            $data['icon'] = $upload->img($request->file('icon'));
        }

        Category_product::find($id)->update($data);
        admin_logs::addLogs("UPD-002", "Kategori Product");
        return redirect()->route('product-category');
    }

    public function delete_category($id)
    {
        Category_product::destroy($id);
        admin_logs::addLogs("DEL-003", "Kategori Product");
        return redirect()->route('product-category');
    }

}
