<?php

namespace App\Http\Controllers;

use App\Classes\upload;
use App\Kategori_news;
use App\News;
use App\Sales;
use App\Traits\admin_logs;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function sendToFcm($reg_id, $payload)
    {
        $URL    = "https://fcm.googleapis.com/fcm/send";
        $KEY    = env("FIREBASE_CREDENTIALS", null);
        $client = new Client;
        $data   = $client->request('POST', $URL, [
            'headers' => array(
                'Authorization' => 'key=' . $KEY,
                'Content-Type'  => 'application/json',
            ),
            'json'    => array(
                'registration_ids' => $reg_id,
                'data'             => is_object($payload) ? $payload : $payload,
            ),
        ]);
        $result = $data->getBody();
        $res    = json_decode($result);

        return $res;
    }

    public function index()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['news'] = DB::table('news')
            ->select('news.*', 'administrators.name as name', 'kategori_news.nama_kategori as nama_kategori')
            ->leftJoin('administrators', 'administrators.id', 'news.created_by')
            ->leftJoin('kategori_news', 'kategori_news.id', 'news.id_kategori_berita')
            ->whereNull('news.deleted_at')
            ->whereNull('kategori_news.deleted_at')
            ->get();

        return view('news.index', $data);
    }

    public function add()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['categories'] = Kategori_news::all();

        return view('news.add', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'              => 'required',
            'id_kategori_berita' => 'required',
            'deskripsi'          => 'required',
            'image'              => 'max:2048',
            'tipe_user'          => 'required',
        ]);

        if ($request->file('image')) {
            $upload        = new upload();
            $data['image'] = $upload->img($request->file('image'));
        } else {
            $data['image'] = env('DEFAULT_IMAGE');
        }
        $data['tanggal']    = date('Y-m-d H:i:s');
        $data['created_by'] = Auth::user()->id;

        $news = DB::table('news')->insertGetID([
            'judul'              => $data['judul'],
            'id_kategori_berita' => $data['id_kategori_berita'],
            'tipe_user'          => $data['tipe_user'],
            'deskripsi'          => $data['deskripsi'],
            'image'              => $data['image'],
            'tanggal'            => $data['tanggal'],
            'created_by'         => $data['created_by'],
        ]);

        DB::table('user_notifications')->insert(
            ['id_user'   => null,
                'tipe_user'  => $data['tipe_user'],
                'created_by' => Auth::user()->id,
                'is_view'    => 0,
                'id_detail'  => $news,
                'tipe_page'  => 2,
                'page'       => 2,
                'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s'),
            ]
        );

        $token_sales = Sales::pluck('firebase_token');
        $token_kios  = [];
        // Kios::pluck('firebase_token');

        if ($data['tipe_user'] == 1) {
            $tokens = $token_sales;
        } else if ($data['tipe_user'] == 2) {
            $tokens = $token_kios;
        } else {
            $tokens = $token_kios->merge($token_sales);
        }

        if (!empty($tokens)) {
            $message = array(
                "tipe"      => "Berita",
                "catatan"     => $data['judul'],
                "deskripsi" => $data['deskripsi'],
            );
    
            $this->sendToFcm($tokens, $message);
        }

        admin_logs::addLogs("ADD-001", "Berita");
        return redirect()->route('list-news');
    }

    public function show(News $news, $id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['news'] = News::where('id', $id)
            ->with('categories', 'admins')
            ->first();

        return view('news.show', $data);
    }

    public function edit(News $news, $id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['categories'] = Kategori_news::all();
        $data['news']       = News::where('id', $id)
            ->with('categories')
            ->first();

        return view('news.edit', $data);
    }

    public function update(Request $request, News $news, $id)
    {
        $data = $request->validate([
            'judul'              => 'required',
            'id_kategori_berita' => 'required',
            'tipe_user'          => 'required',
            'deskripsi'          => 'required',
            'image'              => 'max:2048',
        ]);

        if ($request->file('image')) {
            $upload        = new upload();
            $data['image'] = $upload->img($request->file('image'));
        }

        News::where('id', $id)->update($data);

        $token_sales = Sales::pluck('firebase_token');
        $token_kios  = [];
        // Kios::pluck('firebase_token');
        
        if ($request->tipe_user == 1) {
            $tokens = $token_sales;
        } else if ($request->tipe_user == 2) {
            $tokens = $token_kios;
        } else {
            $tokens = $token_kios->merge($token_sales);
        }

        if (!empty($tokens)) {
            $message = array(
                "tipe"      => "Berita",
                "catatan"     => $data['judul'],
                "deskripsi" => $data['deskripsi'],
            );
    
            $this->sendToFcm($tokens, $message);
        }   

        admin_logs::addLogs("UPD-002", "Berita");
        return redirect()->route('list-news');
    }

    public function delete($id)
    {
        News::where('id', $id)->delete();
        DB::table('user_notifications')->where('id_detail', $id)->delete();
        
        admin_logs::addLogs("DEL-003", "Berita");
        return redirect()->route('list-news');
    }

    public function category()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['categories'] = Kategori_news::with('admins')->get();

        return view('news.category.index', $data);
    }

    public function add_category()
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        return view('news.category.add', $data);
    }

    public function store_category(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required',
            'image'         => 'max:2048',
        ]);

        if ($request->file('image')) {
            $upload        = new upload();
            $data['image'] = $upload->img($request->file('image'));
        } else {
            $data['image'] = env('DEFAULT_IMAGE');
        }

        $data['created_by'] = Auth::user()->id;

        Kategori_news::create($data);
        admin_logs::addLogs("ADD-001", "Kategori Berita");
        return redirect()->route('category_news');
    }

    public function edit_category($id)
    {
        $controller    = new Controller;
        $data['menus'] = $controller->menus();

        $data['category'] = Kategori_news::where('id', $id)->first();

        return view('news.category.edit', $data);
    }

    public function update_category(Request $request, $id)
    {
        $data = $request->validate([
            'nama_kategori' => 'required',
            'image'         => 'max:2048',
        ]);

        if ($request->file('image')) {
            $upload        = new upload();
            $data['image'] = $upload->img($request->file('image'));
        }

        Kategori_news::where('id', $id)->update($data);
        admin_logs::addLogs("UPD-002", "Kategori Berita");
        return redirect()->route('category_news');
    }

    public function delete_category($id)
    {
        Kategori_news::destroy($id);
        admin_logs::addLogs("DEL-003", "Kategori Berita");
        return redirect()->route('category_news');
    }
}
