<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
// laporan sales
Route::get('/print_transaksi/{id}/{token}/{id_transaksi}', 'LaporanSalesController@print_transaksi');
Route::get('/laporan_sales/{id}/{token}', 'LaporanSalesController@laporan');
Route::post('/filter_tugas_sales', 'LaporanSalesController@filter_laporan');
Route::get('/crojobs_notifications', 'LaporanSalesController@crojobs_notifications');

// cek tugas tagihan sales
Route::get('/cek_tagihan/{id}/{token}', 'LaporanSalesController@tagihanSales');
Route::post('/tugas/cari_kios', 'LaporanSalesController@cariKios');
Route::post('/tugas/pilih_kios_tampil_cicilan', 'LaporanSalesController@pilihKios');
Route::post('/tugas/pilih_cicilan', 'LaporanSalesController@pilihCicilan');

Route::namespace('Auth')->group(function(){

    //Login Routes
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    //Forgot Password Routes
    Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    //Reset Password Routes
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.update');
});
Route::get('/home', 'DashboardController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/dashboardG', 'DashboardController@getgrafik')->name('getgrafik');
Route::get('/dashboardG2', 'DashboardController@getgrafik2')->name('getgrafik2');
Route::get('/getindexDS', 'DashboardController@getindexDS')->name('getindexDS');
Route::get('/getindexDS2', 'DashboardController@getindexDS2')->name('getindexDS2');
Route::get('/getindexDS3', 'DashboardController@getindexDS3')->name('getindexDS3');
Route::get('/getindexDS4', 'DashboardController@getindexDS4')->name('getindexDS4');
Route::get('/getMapKios', 'DashboardController@getMapKios')->name('getMap');
Route::get('/getMapSales', 'DashboardController@getMapSales')->name('getMap');

//Route Module Sales
Route::get('/sales', 'SalesController@index')->name('list-sales');
Route::get('/getlist-sales', 'SalesController@getindex')->name('getlist-sales');
Route::get('/sales/add', 'SalesController@add_sales')->name('add-sales');
Route::get('/area/{idprovince}', 'MasterController@listArea')->name('list-area-sales');
Route::post('/insertSales', 'SalesController@insertSales')->name('insertSales');
Route::get('/sales/edit/{id}', 'SalesController@editsales')->name('editSales');
Route::post('/updateSales/{id}', 'SalesController@updateSales')->name('updateSales');
Route::post('/deletesales/{id}', 'SalesController@deletesales')->name('deletesales');
Route::get('/detailsales/{id}', 'SalesController@detailsales')->name('detailsales');
Route::get('/password-change-sales/{id}', 'SalesController@changePassword')->name('password.change.sales');
Route::put('/password-update-sales/{id}', 'SalesController@updatePassword')->name('password.update.sales');
//End Route Module Sales

//Route Module Kios
Route::get('/kios', 'KiosController@indexKios')->name('list-kios');
Route::get('/getkios', 'KiosController@getindexKios')->name('getkios'); //buat route baru untuk server side
Route::get('/getindexKiosBy/{query}', 'KiosController@getindexKiosBy')->name('getindexKiosBy'); //buat route baru untuk server side
Route::get('/getindexKiosByKota/{query}', 'KiosController@getindexKiosByKota')->name('getindexKiosByKota'); //buat route baru untuk server side
Route::get('/kios/add', 'KiosController@addKios')->name('add-kios');
Route::post('/insertkios', 'KiosController@insertKios')->name('insertKios');
Route::get('/kios/edit/{id}', 'KiosController@editKios')->name('editKios');
Route::post('/kios/delete/{id}', 'KiosController@deletekios')->name('deletekios');
Route::post('/updateKios/{id}', 'KiosController@updateKios')->name('updateKios');
Route::post('/updatestatuskios', 'KiosController@updatestatuskios')->name('updatestatuskios');
//End Route Module Kios

//Route Tipe Kios
Route::get('/tipe-kios', 'KiosController@indexTipeKios')->name('tipe-kios');
Route::get('/tipe-kios/add', 'KiosController@addTipeKios')->name('addTipeKios');
Route::post('/inserttipekioskios', 'KiosController@inserttipekioskios')->name('inserttipekioskios');
Route::get('/tipe-kios/edit/{id}', 'KiosController@edittipekios')->name('edittipekios');
Route::get('/tipe-kios/detail/{id}', 'KiosController@detailkios')->name('detailkios');
Route::post('/tipe-kios/delete/{id}', 'KiosController@deletetipekios')->name('deletetipekios');
Route::post('/updatetipekios/{id}', 'KiosController@updatetipekios')->name('updatetipekios');
//End Route Tipe Kios

//role pembayaran
Route::get('/role-pembayaran', 'MasterController@indexRolePembayaran')->name('role_pembayaran');
Route::get('/addrole-pembayaran', 'MasterController@createRolePembayaran')->name('addrole_pembayaran');
Route::post('/storerole-pembayaran', 'MasterController@storeRolePembayaran')->name('storerole_pembayaran');

//Master Tipe Kios Route
Route::get('/master/tipe_kios', 'MasterController@indexTipeKios')->name('tipe_kios');
Route::get('/master/addtipekios', 'MasterController@addTipeKios')->name('addtipekios');
Route::post('/master/inserttipekios', 'MasterController@inserttipekios')->name('inserttipekios');
Route::get('/master/editTipeKios/{id}', 'MasterController@editTipeKios')->name('editTipeKios');
Route::post('/master/updateTipeKios/{id}', 'MasterController@updateTipeKios')->name('updateTipeKios');
Route::post('/master/deletetipekios/{id}', 'MasterController@deletetipekios')->name('deletetipekios');
//End Master Tipe Kios Route


//Master Aktivitas Logs
Route::get('/master/aktifitas_logs', 'MasterController@indexAktivitasLog')->name('aktifitas_logs');
Route::get('getaktifitaslogs', 'MasterController@indexListAktivitasLog')->name('getaktifitaslogs');
Route::get('/master/addaktifitaslog', 'MasterController@addAktivitasLog')->name('add-aktifitaslog');
Route::post('/master/storeaktifitaslog', 'MasterController@storeAktifitasLog')->name('store-aktifitaslog');
Route::get('/master/edit-aktifitaslog/{id}', 'MasterController@editAktifitasLog')->name('edit-aktifitaslog');
Route::post('/master/update-aktifitaslog/{id}', 'MasterController@updateAktifitasLog')->name('update-aktifitaslog');
Route::post('/master/delete-aktifitaslog/{id}', 'MasterController@deleteAktifitasLog')->name('delete-aktifitaslog');
//End Master Aktivitas Log

//Master Status Cicilan
Route::get('/master/status_cicilan', 'MasterController@indexStatusCicilan')->name('status_cicilan');
Route::get('/get-statuscicilan', 'MasterController@indexListStatusCicilan')->name('get-statuscicilan');
Route::get('/master/add-statuscicilan', 'MasterController@addStatusCicilan')->name('add-statuscicilan');
Route::post('/master/store-statuscicilan', 'MasterController@storeStatusCicilan')->name('store-statuscicilan');
Route::get('/master/edit-statuscicilan/{id}', 'MasterController@editStatusCicilan')->name('edit-statuscicilan');
Route::post('/master/update-statuscicilan/{id}', 'MasterController@updateStatusCicilan')->name('update-statuscicilan');
Route::post('/master/delete-statuscicilan/{id}', 'MasterController@deleteStatusCicilan')->name('delete-statuscicilan');
//End Master Status Cicilan

//Administrator Route
Route::get('/administrator', 'AdministratorController@index')->name('list-admin');
Route::get('/indexadministrator', 'AdministratorController@getIndex')->name('list-admin-index');
Route::get('/roleadministrator/{query}', 'AdministratorController@roleIndex')->name('role-admin-index');
Route::get('/administrator/add', 'AdministratorController@create')->name('add-admin');
Route::get('/administrator/edit/{id}', 'AdministratorController@edit')->name('edit-admin');
Route::post('/administrator/store', 'AdministratorController@store')->name('store-admin');
Route::post('/administrator/update/{id}', 'AdministratorController@update')->name('update-admin');
Route::post('/administrator/delete/{id}', 'AdministratorController@destroy')->name('delete-admin');
Route::get('/administrator/show/{id}', 'AdministratorController@show')->name('show-admin');
//End Administrator Route

//Module Principles Route
Route::get('/principle', 'PrincipleController@index')->name('list-principle');
Route::get('/principle/add', 'PrincipleController@add')->name('add-principle');
Route::post('/principle/store-principle', 'PrincipleController@store')->name('store-principle');
Route::get('/principle/edit/{id}', 'PrincipleController@edit')->name('edit-principle');
Route::post('/principle/update-principle/{id}', 'PrincipleController@update')->name('update-principle');
Route::get('/principle/show-principle/{id}', 'PrincipleController@show')->name('show-principle');
Route::post('/principle/delete/{id}', 'PrincipleController@delete')->name('delete-principle');
Route::get('/password-change-principle/{id}', 'PrincipleController@changePassword')->name('password.change.principle');
Route::put('/password-update-principle/{id}', 'PrincipleController@updatePassword')->name('password.update.principle');
//End Module Principles Route

Route::get('/principle-category', 'PrincipleController@category')->name('principle-category');
Route::get('/principle-category/add', 'PrincipleController@add_category')->name('add-principle-category');
Route::post('/principle-category/store', 'PrincipleController@store_category')->name('store-principle-category');
Route::get('/principle-category/edit/{id}', 'PrincipleController@edit_category')->name('edit-principle-category');
Route::post('/principle-category/update/{id}', 'PrincipleController@update_category')->name('update-principle-category');
Route::post('/principle-category/delete/{id}', 'PrincipleController@delete_category')->name('delete-principle-category');

//Transaksi Route
Route::get('/transaksi', 'TransaksiController@indexTransaksi')->name('list-transaksi');
Route::get('/gettransaksi', 'TransaksiController@getindexTransaksi')->name('getlist-transaksi');
Route::get('/transaksi/details/{id}', 'TransaksiController@details')->name('transaksi-details');
//Route::get('/status_transaksi', 'TransaksiController@index')->name('status_transaksi');
Route::post('/updatestatustransaksi', 'TransaksiController@updatestatustransaksi')->name('updatestatustransaksi');
//End Transaksi Route

//Master Status Transaksi Route
Route::get('/master/status-transaksi', 'MasterController@indexStatusTransaksi')->name('status_transaksi');
Route::get('/master/addstatus-transaksi', 'MasterController@createStatusTransaksi')->name('addstatus_transaksi');
Route::post('/master/storestatus-transaksi', 'MasterController@storeStatusTransaksi')->name('storestatus_transaksi');
Route::post('/master/deletestatus_transaksi/{id}', 'MasterController@deleteStatusTransaksi')->name('deletestatus_transaksi');
//End Master Metode Pengiriman Route

//Master Metode Pengiriman Route
Route::get('/master/metode_pengiriman', 'MasterController@indexMetodePengiriman')->name('metode_pengiriman');
Route::get('/master/addmetode-pengiriman', 'MasterController@createMetodePengiriman')->name('addmetode_pengiriman');
Route::post('/master/storemetode-pengiriman', 'MasterController@storeMetodePengiriman')->name('storemetode_pengiriman');
Route::get('/master/editmetode_pengiriman/{id}', 'MasterController@editMetodePengiriman')->name('editmetode_pengiriman');
Route::post('/master/deletemetode_pengiriman/{id}', 'MasterController@deleteMetodePengiriman')->name('deletemetode_pengiriman');
Route::post('/master/updatemetode_pengiriman/{id}', 'MasterController@updateMetodePengiriman')->name('updatemetode_pengiriman');
//End Master Metode Pengiriman Route

//Master Province Route
Route::get('/master/province', 'MasterController@province')->name('provinsi');
Route::get('/master/province/add-province', 'MasterController@addProvince')->name('add-province');
Route::post('/master/province/store-province', 'MasterController@storeProvince')->name('store-province');
Route::get('/master/province/edit-province/{id}', 'MasterController@editProvince')->name('edit-province');
Route::post('/master/province/update-province', 'MasterController@updateProvince')->name('update-province');
Route::post('master/province/delete-province/{id}', 'MasterController@deleteProvince')->name('delete-province');
//End Master Province Route

//Master Limit Kredit
Route::get('/master/limit-kredit', 'LimitKreditController@index')->name('limit-kredit');
Route::get('/master/limit-kredit/data', 'LimitKreditController@data_index')->name('limit-kredit-data');
Route::get('/master/limit-kredit/add', 'LimitKreditController@create')->name('limit-kredit-add');
Route::post('/master/limit-kredit/store', 'LimitKreditController@store')->name('limit-kredit-store');
Route::get('/master/limit-kredit/edit/{id}', 'LimitKreditController@edit')->name('limit-kredit-edit');
Route::post('/master/limit-kredit/update/{id}', 'LimitKreditController@update')->name('limit-kredit-update');
Route::post('/master/limit-kredit/delete/{id}', 'LimitKreditController@destroy')->name('limit-kredit-delete');
//End Master Limit Kredit

//Master City Route
Route::get('/master/city', 'MasterController@City')->name('kota');
Route::get('/master/city/add-city', 'MasterController@addCity')->name('add-city');
Route::get('/master/city/edit-city/{id}', 'MasterController@editCity')->name('edit-city');
Route::post('/master/city/store-city', 'MasterController@storeCity')->name('store-city');
Route::post('/master/city/update-city', 'MasterController@updateCity')->name('update-city');
Route::post('master/city/delete-city/{id}', 'MasterController@deleteCity')->name('delete-city');
//End Master City Route

//Master Kecamatan Route
Route::get('/master/kecamatan', 'MasterController@Kecamatan')->name('kecamatan');
Route::get('/master/kecamatan/add-kecamatan', 'MasterController@addKecamatan')->name('add-kecamatan');
Route::get('/master/kecamatan/edit-kecamatan/{id}', 'MasterController@editKecamatan')->name('edit-kecamatan');
Route::post('/master/kecamatan/store-kecamatan', 'MasterController@storeKecamatan')->name('store-kecamatan');
Route::post('/master/kecamatan/update-kecamatan', 'MasterController@updateKecamatan')->name('update-kecamatan');
Route::post('/master/kecamatan/delete-kecamatan/{id}', 'MasterController@deleteKecamatan')->name('delete-kecamatan');
Route::get('/master/kecamatan/get-data-kecamatan', 'MasterController@getDataKecamatan')->name('get-data-kecamatan');
//End Master Kecamatan Route

//Master Area Route
Route::get('/master/area', 'MasterController@area')->name('area');
Route::get('/master/area/add-area', 'MasterController@addArea')->name('add-area');
Route::post('/master/area/store-area', 'MasterController@storeArea')->name('store-area');
Route::get('/master/area/edit-area/{id}', 'MasterController@editArea')->name('edit-area');
Route::post('/master/area/update-area', 'MasterController@updateArea')->name('update-area');
Route::post('master/area/delete-area/{id}', 'MasterController@deleteArea')->name('delete-area');
Route::get('master/area/list-cities/{idprovince}', 'MasterController@listCities')->name('list-cities');
Route::get('master/area/list-kecamatan/{idprovince}', 'MasterController@listKecamatan')->name('list-kecamatan');
Route::get('/master/area/get-data-area', 'MasterController@getDataArea')->name('get-data-area');
Route::post('/master/area/get-auto-area','MasterController@getAutoArea')->name('get-auto-area');
//End Master Area Route

//Master Fee Admin Route
Route::get('/master/fee-admin', 'MasterController@indexFeeAdmin')->name('fee_admin');
Route::get('/master/indexlist-fadmin', 'MasterController@indexListFeeAdmin')->name('indexlist-fadmin');
Route::get('/master/addfee-admin', 'MasterController@createFeeAdmin')->name('addfee_admin');
Route::get('/master/editfee-admin/{id}', 'MasterController@editFeeAdmin')->name('editfee_admin');
Route::post('/master/storefee-admin', 'MasterController@storeFeeAdmin')->name('storefee_admin');
Route::post('/master/updatefee-admin', 'MasterController@updateFeeAdmin')->name('updatefee_admin');
Route::post('/master/deletefee-admin/{id}', 'MasterController@deleteFeeAdmin')->name('deletefee_admin');
//End Master Fee Admin Route

//Route Product
Route::get('/product', 'ProductController@index')->name('list-product');
Route::get('/list-product-data', 'ProductController@data_index')->name('list-product-data');

Route::get('/riwayat-stok', 'ProductController@riwayat_stock')->name('riwayat-stok');
Route::get('/data-riwayat-stok', 'ProductController@get_riwayat_stock')->name('data-riwayat-stok');
Route::get('/detail-riwayat-stok/{id}', 'ProductController@detail_riwayat_stock')->name('detail-riwayat-stok');

Route::get('/top-product', 'TopProductController@top_product')->name('top-product');
Route::get('/list-top-product', 'TopProductController@list_top_product')->name('list-top-product');
Route::get('/top-product-add', 'TopProductController@create')->name('top-product-add');
Route::post('/top-product-store', 'TopProductController@store')->name('top-product-store');
Route::post('/top-product-delete/{id}', 'TopProductController@destroy')->name('top-product-delete');

Route::get('/product/add', 'ProductController@add')->name('add-product');
Route::post('/product/store', 'ProductController@store')->name('store-product');
Route::get('/product/edit/{id}', 'ProductController@edit')->name('edit-product');
Route::post('/product/update/{id}', 'ProductController@update')->name('update-product');
Route::post('/product/delete/{id}', 'ProductController@delete')->name('delete-product');
Route::get('/product/show/{id}', 'ProductController@show')->name('show-product');

Route::get('/riwayat-stok', 'ProductController@riwayat_stock')->name('riwayat-stok');

Route::get('/stock', 'StockController@index')->name('stock');
Route::get('/stock-data', 'StockController@data_index')->name('stock-data');
Route::post('/delete-stock/{tgl}', 'StockController@delete_stock')->name('delete-stock');
Route::get('/product/stock/add', 'StockController@add')->name('add-stock');
Route::post('/get-produk/{category}/{principle}', 'StockController@get_produk')->name('get-produk');
Route::get('/get-satuan/{id}', 'StockController@get_satuan')->name('get-satuan');
Route::post('/product/stock/edit/{product_id}', 'StockController@get_stock')->name('get-stock');
Route::post('/product/stock/update/{product_id}', 'StockController@store')->name('update-stock');

Route::get('/product-category', 'ProductController@category')->name('product-category');
Route::get('/add-product-category', 'ProductController@add_category')->name('add-product-category');
Route::post('/store-product-category', 'ProductController@store_category')->name('store-product-category');
Route::get('/edit-product-category/{id}', 'ProductController@edit_category')->name('edit-product-category');
Route::post('/update-product-category/{id}', 'ProductController@update_category')->name('update-product-category');
Route::post('/delete-product-category/{id}', 'ProductController@delete_category')->name('delete-product-category');
//End Route Product

//Reward
Route::get('/addreward-product', 'RewardController@createProductReward')->name('add-product-reward');
Route::post('/storereward-product', 'RewardController@storeProductReward')->name('storereward-product');
Route::get('/list-product-reward', 'RewardController@indexListProductReward')->name('list-product-reward');
Route::get('/getrewardproduct', 'RewardController@getindexListProductReward')->name('getlist-reward-product');
Route::post('/deleteproduct-reward/{id}', 'RewardController@deleteProductReward')->name('deleteproduct-reward');
Route::get('/editproduct-reward/{id}', 'RewardController@editProductReward')->name('editproduct-reward');
Route::post('/updateproduct-reward/{id}', 'RewardController@updateProductReward')->name('updateproduct-reward');

Route::get('/list-kios-reward', 'RewardController@indexListKiosReward')->name('list-kios-reward');
Route::get('/getkiosreward', 'RewardController@getindexKiosReward')->name('getkiosreward');
Route::get('/detailrewardkios/{id}', 'RewardController@detailrewardkios')->name('detailrewardkios');
Route::get('/gettotal/{id}', 'RewardController@getTotal')->name('gettotal');
Route::get('/getkiostransaksireward/{id}', 'RewardController@getindexKiosTransaksiReward')->name('getkiostransaksireward');
Route::get('/filter-status/{query}', 'RewardController@FilterStatus')->name('filter-status');

Route::get('/list-transaksi-reward', 'RewardController@indexListTransaksiReward')->name('list-transaksi-reward');
Route::get('/gettransaksireward', 'RewardController@getindexTransaksiReward')->name('gettransaksireward');
Route::get('/detailrewardtransaksi/{id}', 'RewardController@detailrewardtransaksi')->name('detailrewardtransaksi');
Route::get('/getproduktransaksireward/{id}', 'RewardController@getindexProdukTransaksiReward')->name('getproduktransaksireward');
Route::get('/addreward-transaksi', 'RewardController@createTransaksiReward')->name('add-transaksi-reward');
Route::get('/filter-statustransaksi-reward/{query}', 'RewardController@FilterStatusTransaksiReward')->name('filter-statustransaksi-reward');
//End Reward

//Route::get('/reward', 'RewardController@index')->name('reward');


//Route Promo
Route::get('/promo', 'PromoController@index')->name('list-promo');
Route::get('/getindexPromo', 'PromoController@getindexPromo')->name('getindexPromo');
Route::get('/promo/add', 'PromoController@create')->name('add-promo');
Route::post('/promo/store', 'PromoController@store')->name('store-promo');
Route::get('/promo/edit/{id}', 'PromoController@edit')->name('edit-promo');
Route::post('/promo/update/{id}', 'PromoController@update')->name('update-promo');
Route::get('/promo/show/{id}', 'PromoController@show')->name('show-promo');
Route::post('/promo/delete/{id}', 'PromoController@delete')->name('delete-promo');
//End Route Promo

//Route Running Text
Route::get('/running_text', 'RunningTextController@index')->name('running_text');
Route::get('/getRunningText', 'RunningTextController@getRunningText')->name('getRunningText');
Route::get('/running_text/edit/{id}', 'RunningTextController@edit')->name('edit-running_text');
Route::post('/running_text/update/{id}', 'RunningTextController@update')->name('update-running_text');
//End Route Running Text

//Route Tipe Promo
Route::get('/promo/tipe-promo', 'PromoController@indexTipePromo')->name('list-tipe-promo');
Route::get('/getindexTipePromo', 'PromoController@getindexTipePromo')->name('getindexTipePromo');
Route::get('/promo/tipe-promo/add', 'PromoController@addTipePromo')->name('add-tipe-promo');
Route::post('/promo/tipe-promo//store', 'PromoController@insertTipePromo')->name('store-tipe-promo');
Route::get('/promo/tipe-promo/edit/{id}', 'PromoController@editTipePromo')->name('edit-tipe-promo');
Route::post('/promo/tipe-promo/update/{id}', 'PromoController@updateTipePromo')->name('update-tipe-promo');
Route::post('/promo/tipe-promo/delete/{id}', 'PromoController@deleteTipePromo')->name('delete-tipe-promo');
//End Route Tipe Promo

//Route Cicilan
Route::get('/list-cicilan', 'CicilanController@index')->name('list-cicilan');
Route::get('/getindexCicilan', 'CicilanController@getindexCicilan')->name('getindexCicilan');
Route::get('/getlihatCicilan', 'CicilanController@getlihatCicilan')->name('getlihatCicilan');
Route::get('/edit-cicilan/{id}', 'CicilanController@edit')->name('edit-cicilan');
Route::post('/update-cicilan/{id}', 'CicilanController@update')->name('update-cicilan');
Route::get('/show-cicilan/{id}', 'CicilanController@show')->name('show-cicilan');
Route::get('/lihat-cicilan/{id}', 'CicilanController@lihatCicilan')->name('lihat-cicilan');
Route::get('/status-cicilan/{id}', 'CicilanController@statusCicilan')->name('status-cicilan');
Route::post('/delete-cicilan/{id}', 'CicilanController@delete')->name('delete-cicilan');
Route::post('/updatestatusCicilan', 'CicilanController@updatestatusCicilan')->name('updatestatusCicilan');
//End Route Cicilan


// Route::get('/add-product-reward', 'RoleController@add')->name('add-product-reward');
// Route::get('/list-product-reward', 'RoleController@add')->name('list-product-reward');


Route::get('/logs', 'LogsController@index')->name('logs');
Route::get('/logs-admin', 'LogsController@admin')->name('logs_admin');
Route::get('/logs-admin-data', 'LogsController@admin_data')->name('logs-admin-data');
Route::get('/logs-user', 'LogsController@user')->name('logs_user');
Route::get('/logs-user-data', 'LogsController@user_data')->name('logs-user-data');

Route::get('/setting', 'SettingController@index')->name('setting');

//Master Admin Role Route
Route::get('/administrator/role', 'RoleController@index')->name('role-admin');
Route::get('/administrator/role/add', 'RoleController@create')->name('add-role');
Route::post('/administrator/role/store', 'RoleController@store')->name('store-role');
Route::get('/administrator/role/edit/{id}', 'RoleController@edit')->name('edit-role');
Route::post('/administrator/role/update/{id}', 'RoleController@update')->name('update-role');
Route::post('/administrator/role/delete/{id}', 'RoleController@destroy')->name('delete-role');
//End Master Admin Role Route

//Master Role Pembayaran Route
Route::get('/master/role-pembayaran', 'MasterController@indexRolePembayaran')->name('role_pembayaran');
Route::get('/master/addrole-pembayaran', 'MasterController@createRolePembayaran')->name('addrole_pembayaran');
Route::post('/master/storerole-pembayaran', 'MasterController@storeRolePembayaran')->name('storerole_pembayaran');
Route::get('/master/editrole_pembayaran/{id}', 'MasterController@editRolePembayaran')->name('editrole_pembayaran');
Route::post('/master/deleterole_pembayaran/{id}', 'MasterController@deleteRolePembayaran')->name('deleterole_pembayaran');
Route::post('/master/updaterole_pembayaran/{id}', 'MasterController@updateRolePembayaran')->name('updaterole_pembayaran');
//End Master Role Pembayaran Route

//Master Metode Pembayaran Route
Route::get('/master/metode_pembayaran', 'MasterController@indexMetodePembayaran')->name('metode_pembayaran');
Route::get('/master/addmetode_pembayaran', 'MasterController@addMetodePembayaran')->name('addmetode_pembayaran');
Route::post('/master/insertmetode_pembayaran', 'MasterController@insertMetodePembayaran')->name('insertmetode_pembayaran');
Route::post('/master/deleteMetodePembayaran/{id}', 'MasterController@deleteMetodePembayaran')->name('deleteMetodePembayaran');
Route::get('/master/editMetodePembayaran/{id}', 'MasterController@editMetodePembayaran')->name('editMetodePembayaran');
Route::post('/master/updateMetodePembayaran/{id}', 'MasterController@updateMetodePembayaran')->name('updateMetodePembayaran');

//End Master Metode Pembayaran Route

//Role Pembayaran
Route::get('/master/rolePembayaran', 'MasterController@indexRolePembayaran')->name('role_pembayaran');
Route::get('/master/addrolePembayaran', 'MasterController@addrolePembayaran')->name('addrolePembayaran');

//Master Departement Route
Route::get('/master/departement', 'MasterController@indexDepartment')->name('departement');
Route::get('/master/departement/add', 'MasterController@addDepartment')->name('adddepartement');
Route::post('/master/departement/create', 'MasterController@insertdepartement')->name('insertdepartement');
Route::get('/master/departement/editt/{id}', 'MasterController@editdepartement')->name('editdepartement');
Route::post('/master/departement/update/{id}', 'MasterController@updateDepartement')->name('updateDepartement');
Route::post('/master/departement/delete/{id}', 'MasterController@deletedepartement')->name('deletedepartement');
//End Master Departement Route

//Master Tipe Cicilan Route
Route::get('/master/tipe-cicilan', 'MasterController@indexCicilan')->name('tipe_cicilan');
Route::get('/master/add-tipe-cicilan', 'MasterController@addCicilan')->name('addcicilan');
Route::post('/master/create-tipe-cicilan', 'MasterController@insertCicilan')->name('insertcicilan');
Route::post('/master/delete-tipe-cicilan/{id}', 'MasterController@deleteCicilan')->name('deletecicilan');
Route::get('/master/edit-tipe-cicilan/{id}', 'MasterController@editCicilan')->name('editcicilan');
Route::post('/master/update-ttipe-cicilan/{id}', 'MasterController@updateCicilan')->name('updatecicilan');
//End Master Tipe Cicilan Route

//Master Tipe User and Task Route
Route::get('/master/tipe_user', 'MasterController@indexTipeUser')->name('tipe_user');
Route::get('/master/tipe_user/add', 'MasterController@addTipeUser')->name('add-tipe-user');
Route::post('/master/tipe_user/store-tipe_user', 'MasterController@storeTipeUser')->name('store-tipe_user');
Route::post('/master/tipeuser/delete/{id}', 'MasterController@deletetipeuser')->name('deletetipeuser');
Route::get('/master/tipe_tugas', 'MasterController@indexTipeTask')->name('tipe_tugas');
//End Master Tipe User and Task Route


//list tugas hari ini
Route::get('/tugashariini', 'TaskTodayCOntroller@indexHariini')->name('tugashariini');
Route::get('/indextugashariini', 'TaskTodayCOntroller@getindextugashariini')->name('indextugashariini');
// Route::get('/tracking', 'TaskTodayCOntroller@tracking')->name('tracking');

//Route List Notifikasi
Route::get('/informasi/list-notification', 'InformasiController@indexNotifikasi')->name('list-notification');
Route::get('/informasi/list-data-notifikasi', 'InformasiController@listNotifData')->name('list-notification-data');
Route::get('/informasi/add-notification', 'InformasiController@addNotifikasi')->name('add-notification');
Route::get('/informasi/add-notification/getuserwithtype/{type}/{kota?}', 'InformasiController@getuserwithtype')->name('getuserwithtype');
//End Route List Notifikasi


// Route::post('/informasi/add-notification/generateInfo', 'InformasiController@generateInfo')->name('genInfo');
Route::post('/informasi/add-notification/storeNotification', 'InformasiController@storeNotification')->name('store-notification');
Route::post('/informasi/delete-notification/deleteNotification/{id}', 'InformasiController@deleteNotification')->name('delete-notification');
Route::post('/notifikasi/delete-multiple', 'InformasiController@deleteMultiple')->name('delete-notifications');
Route::get('/informasi/show/{id}', 'InformasiController@show')->name('show-informasi');

//Route Informasi News
Route::get('/informasi/category_news', 'NewsController@category')->name('category_news');
Route::get('/informasi/category_news/add', 'NewsController@add_category')->name('add-category-news');
Route::post('/informasi/category_news/store', 'NewsController@store_category')->name('store-category-news');
Route::get('/informasi/category_news/edit/{id}', 'NewsController@edit_category')->name('edit-category-news');
Route::post('/informasi/category_news/update/{id}', 'NewsController@update_category')->name('update-category-news');
Route::post('/informasi/category_news/delete/{id}', 'NewsController@delete_category')->name('delete-category-news');
Route::get('/informasi/news', 'NewsController@index')->name('list-news');
Route::get('/informasi/news/add', 'NewsController@add')->name('add-news');
Route::post('/informasi/news/store', 'NewsController@store')->name('store-news');
Route::get('/informasi/news/edit/{id}', 'NewsController@edit')->name('edit-news');
Route::post('/informasi/news/update/{id}', 'NewsController@update')->name('update-news');
Route::post('/informasi/news/delete/{id}', 'NewsController@delete')->name('delete-news');
Route::get('/informasi/news/show/{id}', 'NewsController@show')->name('show-news');
//End Route Informasi News

//Route Tugas
Route::get('/tugas/list-tugas/{unsigned_task}', 'TugasController@listTugas')->name('unsigned-task');
Route::get('/tugas/unsigned-task-count', 'TugasController@unsigned_task_count')->name('unsigned-task-count');

Route::get('/tugas/list-tugas', 'TugasController@listTugas')->name('list-tugas');
Route::get('/tugas/list-tugas-unsigned', 'TugasController@getTaskListUnsigned')->name('list-tugas-unsigned');
Route::get('/tugas/list-tugas-today/', 'TugasController@getTaskListToday')->name('list-tugas-today');
Route::get('/tugas/get-tugas-all/{city?}/{area?}/{sales?}', 'TugasController@getTaskList')->name('getalltask');
Route::post('/tugas/get-tugas-alls', 'TugasController@getTaskLists')->name('getalltasks');

Route::post('/tugas/delete/{id}', 'TugasController@deleteTugas')->name('delete-tugas');
Route::post('/tugas/changestatus/{id}/{nostastus}', 'TugasController@changeStatusTugas')->name('change-status-tugas');
Route::post('/tugas/changestatusapprove/{id}', 'TugasController@changeStatusApprove')->name('change-status-approve');
Route::get('/tugas/downloadtugas/{id}', 'TugasController@downloadtugas')->name('download-tugas');
Route::get('/tugas/add-tugas', 'TugasController@addTugas')->name('add-tugas');
Route::get('/tugas/edit-tugas/{id}', 'TugasController@editTugas')->name('edit-tugas');
Route::post('/tugas/update-tugas', 'TugasController@UpdateTugas')->name('update-tugas');

Route::post('/tugas/add-tugas', 'TugasController@storeTask')->name('store-tugas');
Route::get('/tugas/add-tugas/list-area/{city}', 'TugasController@listArea')->name('list-areass');
Route::get('/tugas/add-tugas/list-sales/{area}', 'TugasController@listSales')->name('list-saless');
Route::get('/tugas/add-tugas/list-kios/{area}', 'TugasController@listKios')->name('list-kioses');
Route::get('/tugas/add-tugas/list-tagihan/{kios}', 'TugasController@listTagihan')->name('list-tagihans');
Route::get('/tugas/add-tugas/list-tenorsid/{idloan}', 'TugasController@noInvoiceTagihan')->name('list-noInv');
Route::get('/tugas/add-tugas/list-transaksi/{kios}', 'TugasController@listTransaksi')->name('list-transaksis');
Route::get('/tugas/add-tugas/list-tagihan-tunggakan/{kios}', 'TugasController@listTagihanTunggakan')->name('list-tagihan-tunggakan');
Route::get('/tugas/add-tugas/list-table-tagihan/{idTenor}', 'TugasController@listTableTagihan')->name('list-table-tagihans');
Route::get('/tugas/add-tugas/list-table-transaksi/{idtran}', 'TugasController@listTableTransaksi')->name('list-table-transaksis');

//report
Route::get('/report', 'ReportController@index')->name('report');
Route::get('/reportsales', 'ReportController@indexsales')->name('report_sales');
Route::get('/listreportsales', 'ReportController@listindexsales')->name('list_report_sales');
Route::get('/listReportByNamaSales/{id}', 'ReportController@listReportByNamaSales')->name('listReportByNamaSales');
Route::get('/listReportByDateSales/{id?}', 'ReportController@listReportByDateSales')->name('listReportByDateSales');
Route::get('/listreport', 'ReportController@listReport')->name('listreport');
Route::get('/listreport-bynamakios/{query}', 'ReportController@listReportByNamaKios')->name('listreport-bynamakios');
Route::get('/listreport-bytgl/{query}', 'ReportController@listReportByTanggal')->name('listreport-bytgl');
Route::get('/reportdetailsales/{i}', 'ReportController@salesdetail')->name('listreport-sales');

Route::get('/potongantipepembayaran','PotonganPembayaranController@index')->name('potongan-tipe-pembayaran');
Route::get('/indexpotongantipepembayaran','PotonganPembayaranController@getindex')->name('getpotongan-tipe-pembayaran');
Route::get('/addpotongantipepembayaran','PotonganPembayaranController@add')->name('addpotongan-tipe-pembayaran');
Route::post('/storepotongantipepembayaran','PotonganPembayaranController@store')->name('storepotongan-tipe-pembayaran');
Route::get('/nominal/{id}','PotonganPembayaranController@nominal')->name('nominal');
Route::post('/updatenominal','PotonganPembayaranController@updatenominal')->name('update-nominal');
Route::post('/deletepotongantipepembayaran/{id}','PotonganPembayaranController@deletepotongan')->name('deletepotongantipe');

Route::get('/tugas/add-tugas/list-table-tagihan-tunggakan/{idtagtung}', 'TugasController@listTableTagihanTunggakan')->name('list-table-tagihan-tunggakan');

//Route::get('/tugas/add-tugas/invoicecount/{noinvoice}', 'TugasController@totalInv')->name('list-invoicecount');
//Route::get('/tugas/add-tugas/trancount/{noinvoice}', 'TugasController@totalTransaction')->name('list-trancounts');
//End Route Tugas

Route::get('/tracking', 'TrackingController@trackingIndex')->name('tracking');
Route::get('/tracking/datatracking', 'TrackingController@TrackingData');


//Master Status Transaksi Reward
Route::get('/master/statustransaksi-reward', 'MasterController@indexStatusReward')->name('statustransaksi-reward');
Route::get('/get-statusreward', 'MasterController@indexListStatusReward')->name('get-statusreward');
Route::get('/master/add-statusreward', 'MasterController@addStatusReward')->name('add-statusreward');
Route::post('/master/store-statusreward', 'MasterController@storeStatusReward')->name('store-statusreward');
Route::get('/master/edit-statusreward/{id}', 'MasterController@editStatusReward')->name('edit-statusreward');
Route::post('/master/update-statusreward/{id}', 'MasterController@updateStatusReward')->name('update-statusreward');
Route::post('/master/delete-statusreward/{id}', 'MasterController@deleteStatusReward')->name('delete-statusreward');
//End Master
