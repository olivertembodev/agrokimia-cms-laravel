<?php

use Illuminate\Database\Seeder;
use App\MenuModel;
use App\RoleModel;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        date_default_timezone_set('Asia/Jakarta');
        DB::table('menus')->truncate();
        DB::table('menus')->insert([
            ['nama_menu' =>  'Dashboard',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 1,'slug' =>'dashboard','icon'=>'fas fa-warehouse','no_urut'=>1],
            ['nama_menu' =>  'Sales',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 2,'slug' =>'sales','icon'=>'fas fa-user','no_urut'=>2],
            ['nama_menu' =>  'Kios',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 3,'slug' =>'kios','icon'=>'fas fa-building','no_urut'=>3],
            ['nama_menu' =>  'Administrator',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 4,'slug' =>'administrator','icon'=>'fas fa-user-secret','no_urut'=>4],
            ['nama_menu' =>  'Principle',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 5,'slug' =>'principle','icon'=>'fas fa-clipboard-list','no_urut'=>5],
            ['nama_menu' =>  'Transaksi',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 6,'slug' =>'transaksi','icon'=>'fas fa-calendar-check','no_urut'=>6],
            ['nama_menu' =>  'Cicilan',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 7,'slug' =>'cicilan','icon'=>'fas fa-id-card-alt','no_urut'=>7],
            ['nama_menu' =>  'Master',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 8,'slug' =>'master','icon'=>'fas fa-database','no_urut'=>8],
            ['nama_menu' =>  'Informasi',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 9,'slug' =>'informasi','icon'=>'fas fa-file-alt','no_urut'=>9],
            ['nama_menu' =>  'Promo',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 10,'slug' =>'promo','icon'=>'fas fa-bolt','no_urut'=>10],
            ['nama_menu' =>  'Produk',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 11,'slug' =>'product','icon'=>'fas fa-archive','no_urut'=>11],
            ['nama_menu' =>  'Reward',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 12,'slug' =>'reward','icon'=>'fas fa-star','no_urut'=>12],
            ['nama_menu' =>  'Tugas',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 13,'slug' =>'reward','icon'=>'fas fa-th-list','no_urut'=>13],
            ['nama_menu' =>  'Tracking',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 17,'slug' =>'reward','icon'=>'far fa-map','no_urut'=>14],
            ['nama_menu' =>  'Logs',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 14,'slug' =>'logs','icon'=>'fa fa-history','no_urut'=>15],
            ['nama_menu' =>  'Setting',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 15,'slug' =>'setting','icon'=>'fa fa-cog','no_urut'=>16],
            ['nama_menu' =>  'Report',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 16,'slug' =>'report','icon'=>'fas fa-file','no_urut'=>17],
            ['nama_menu' =>  'Tambah Sales','parent_menu_id' => 2,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-sales','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'List Sales','parent_menu_id' => 2,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-sales','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'Tambah Kios','parent_menu_id' => 3,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-kios','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'List Kios','parent_menu_id' => 3,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-kios','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'Category Kios','parent_menu_id' => 3,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'tipe-kios','icon'=>'null','no_urut'=>3],
            ['nama_menu' =>  'Tambah Admin','parent_menu_id' => 4,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-admin','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'List Admin','parent_menu_id' => 4,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-admin','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'Role Admin','parent_menu_id' => 4,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'role-admin','icon'=>'null','no_urut'=>3],
            ['nama_menu' =>  'List Principle','parent_menu_id' => 5,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-principle','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'Tambah Principle','parent_menu_id' => 5,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-principle','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'List Kategori Principle','parent_menu_id' => 5,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'principle-category','icon'=>'null','no_urut'=>3],
            ['nama_menu' =>  'Tambah Kategori Principle','parent_menu_id' => 5,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-principle-category','icon'=>'null','no_urut'=>4],
            ['nama_menu' =>  'List Transaksi','parent_menu_id' => 6,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-transaksi','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'List Cicilan','parent_menu_id' => 7,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-cicilan','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'Provinsi','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'provinsi','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'Kota','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'kota','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'Area','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'area','icon'=>'null','no_urut'=>3],
            ['nama_menu' =>  'Kecamatan','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'kecamatan','icon'=>'null','no_urut'=>4],
            ['nama_menu' =>  'Fee Admin','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'fee_admin','icon'=>'null','no_urut'=>5],
            ['nama_menu' =>  'Status Transaksi','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'status_transaksi','icon'=>'null','no_urut'=>6],
            ['nama_menu' =>  'Metode Pembayaran','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'metode_pembayaran','icon'=>'null','no_urut'=>7],
            ['nama_menu' =>  'Metode Pengiriman','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'metode_pengiriman','icon'=>'null','no_urut'=>8],
            ['nama_menu' =>  'Departement','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'departement','icon'=>'null','no_urut'=>9],
            ['nama_menu' =>  'Tipe Cicilan','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'tipe_cicilan','icon'=>'null','no_urut'=>10],
            ['nama_menu' =>  'Tipe Tugas','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'tipe_tugas','icon'=>'null','no_urut'=>11],
            ['nama_menu' =>  'Tipe Kios','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'tipe_kios','icon'=>'null','no_urut'=>12],
            ['nama_menu' =>  'Aktifitas Log','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'aktifitas_logs','icon'=>'null','no_urut'=>13],
            ['nama_menu' =>  'Role Pembayaran','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'role_pembayaran','icon'=>'null','no_urut'=>14],
            ['nama_menu' =>  'Tipe User','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'tipe_user','icon'=>'null','no_urut'=>15],
            // ['nama_menu' =>  'Status Cicilan','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'status_cicilan','icon'=>'null','no_urut'=>16],
            ['nama_menu' =>  'Running Text','parent_menu_id' => 15,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'running_text','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'Limit Kredit','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'limit-kredit','icon'=>'null','no_urut'=>18],
            ['nama_menu' =>  'Status Transaksi Reward','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'statustransaksi-reward','icon'=>'null','no_urut'=>19],
            ['nama_menu' =>  'Potongan Tipe Pembayaran','parent_menu_id' => 8,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'potongan-tipe-pembayaran','icon'=>'null','no_urut'=>20],
            ['nama_menu' =>  'Tambah Berita','parent_menu_id' => 9,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-news','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'List Berita','parent_menu_id' => 9,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-news','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'Tambah Notifikasi','parent_menu_id' => 9,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-notification','icon'=>'null','no_urut'=>3],
            ['nama_menu' =>  'List Notifikasi','parent_menu_id' => 9,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-notification','icon'=>'null','no_urut'=>4],
            ['nama_menu' =>  'Kategori Berita','parent_menu_id' => 9,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'category_news','icon'=>'null','no_urut'=>5],
            ['nama_menu' =>  'Tambah Promo','parent_menu_id' => 10,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-promo','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'List Promo','parent_menu_id' => 10,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-promo','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'List Produk','parent_menu_id' => 11,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-product','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'Tambah Produk','parent_menu_id' => 11,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-product','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'List Kategori Produk','parent_menu_id' => 11,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'product-category','icon'=>'null','no_urut'=>3],
            ['nama_menu' =>  'Tambah Kategori Produk','parent_menu_id' => 11,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-product-category','icon'=>'null','no_urut'=>4],
            ['nama_menu' =>  'List Stock','parent_menu_id' => 11,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'stock','icon'=>'null','no_urut'=>5],
            ['nama_menu' =>  'Tambah Stock','parent_menu_id' => 11,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-stock','icon'=>'null','no_urut'=>6],
            ['nama_menu' =>  'List Top Produk','parent_menu_id' => 11,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'top-product','icon'=>'null','no_urut'=>7],
            ['nama_menu' =>  'Tambah Top Produk','parent_menu_id' => 11,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'top-product-add','icon'=>'null','no_urut'=>8],
            ['nama_menu' =>  'List Riwayat Stok','parent_menu_id' => 11,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'riwayat-stok','icon'=>'null','no_urut'=>9],
            ['nama_menu' =>  'List Tipe Promo','parent_menu_id' => 10,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-tipe-promo','icon'=>'null','no_urut'=>3],
            ['nama_menu' =>  'Tambah Produk Reward','parent_menu_id' => 12,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-product-reward','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'List Produk Reward','parent_menu_id' => 12,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-product-reward','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'List Kios Reward','parent_menu_id' => 12,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-kios-reward','icon'=>'null','no_urut'=>3],
            ['nama_menu' =>  'List Transaksi Reward','parent_menu_id' => 12,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-transaksi-reward','icon'=>'null','no_urut'=>4],
            ['nama_menu' =>  'List Tugas','parent_menu_id' => 13,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-tugas','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'Tambah Tugas','parent_menu_id' => 13,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-tugas','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'Logs Admin','parent_menu_id' => 14,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'logs_admin','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'Logs User','parent_menu_id' => 14,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'logs_user','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'Report Kios','parent_menu_id' => 16,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'report','icon'=>'null','no_urut'=>1],
            ['nama_menu' =>  'Report Sales','parent_menu_id' => 16,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'report_sales','icon'=>'null','no_urut'=>2],
            ['nama_menu' =>  'Tracking Tugas','parent_menu_id' => 17,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'tracking','icon'=>'null','no_urut'=>1],
        ]);
        date_default_timezone_set('Asia/Jakarta');
        // seeder departement
        DB::table('departements')->truncate();
        DB::table('departements')->insert(
            ['nama_departement' =>  'SUPERADMIN','kode_departement' =>  'A001',  'urutan' => 1,'deskripsi' =>  'SUPERADMIN','created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        $data_departement =  DB::table('departements')->get();
        DB::table('roles')->truncate();
        foreach ($data_departement as $i => $j) {
        DB::table('roles')->insert(
            ['id_departement'=>$j->id,'name' =>  'SUPERADMIN',  'status' => 1,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        DB::table('roles')->insert(
            ['id_departement'=>$j->id,'name' =>  'PRINCIPLE',  'status' => 1,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        }
        //seeder2
        DB::table('role_menus')->truncate();
        $data_array = MenuModel::all();
        $id_role = RoleModel::select('id')->pluck('id');
        foreach ($data_array as $k => $v) {
                date_default_timezone_set('Asia/Jakarta');
                DB::table('role_menus')->insert(
                    ['role_id' => $id_role[0],  'menu_id' => $v->id,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')]
                );
        }
        //insert principle
        $menu=[6,11,16];
        $menuprinciple=DB::table('menus')->select('id')
        ->whereIn('menu_id',$menu)
        ->get();
        $id_role_p = RoleModel::select('id')->pluck('id');
        $cek=$id_role_p[1];
        foreach ($menuprinciple as $i => $z) {
            date_default_timezone_set('Asia/Jakarta');
            DB::table('role_menus')->insert(

                ['role_id' => $cek,  'menu_id' => $z->id,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')]
            );
    }

        //seeder3
        DB::table('administrators')->truncate();
        $data_array = RoleModel::all();
        foreach ($data_array as $k => $v) {
                date_default_timezone_set('Asia/Jakarta');
                DB::table('administrators')->insert(
                    ['id_role' => $v->id,'name' => 'admin',  'phone' => '081320938989','email' => 'admin@gmail.com','password' => bcrypt('admin123'),'confirm_password' => encrypt('admin123'),'address' => 'surabaya','status' => 'aktif','created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')]
                );
        }
    }
}
