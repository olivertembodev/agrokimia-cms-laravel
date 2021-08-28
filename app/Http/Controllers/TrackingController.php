<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class TrackingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function trackingIndex(){

        $controller = new Controller;
        $data['menus'] = $controller->menus();

        return view('tracking.index_tracking', $data);
    }

    public function TrackingData()
    {
        // $data['maps'] = DB::table('kios')
        // ->select('latitude','longitude','nama_Kios')
        // ->get();
        // // dd($data['maps']);

        // foreach ($data['maps'] as $key => $value) {       
        //     $locations[] = [
        //         'name' => $value->nama_Kios,
        //         'latitude' => $value->latitude,
        //         'longitude' => $value->longitude,
        //     ];
        // }
        // return response()
        //     ->json($locations);
        
    }

    private function execute($url, array $data)
    {
        $client = new  Client();
        $query['query']['key'] = env('FIREBASE_CREDENTIALS');
        $query['json'] = $data;
        try {
            $res = $client->post($url, $query);
            if ($res->getStatusCode() == 200) {
                $response = $res->getBody()->getContents();
                return \GuzzleHttp\json_decode($response, true);
            }
        } catch (ClientException $ce) {
            logger($ce);
        } catch (\Exception $e) {
            logger($e);
        }

        return null;
    }
}
