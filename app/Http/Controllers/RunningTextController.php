<?php

namespace App\Http\Controllers;

use App\RunningText;
use Illuminate\Http\Request;

class RunningTextController extends Controller
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
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        return view('running_text.running_text', $data);
    }

    public function getRunningText()
    {
        $data = RunningText::all();
        return datatables()->of($data)
        ->addColumn('action',function ($data){ //m
            $button ='<a href="running_text/edit/'.$data->id.'">
            <button class="btn btn-xs btn-primary " type="button">
            <span class="btn-label"><i class="fa fa-file"></i></span>
            </button>
            </a>';
           return $button;
           })
           ->escapeColumns('text',function ($data){
            $button ="&nbsp";
            return $button;
           })
           ->rawColumns(['action','text'])->make(true);

    }

    public function edit($id)
    {
        $controller = new Controller;
        $data['menus'] = $controller->menus();

        $data['data'] = RunningText::find($id);

        return view('running_text.edit_running_text',$data);
    }

    public function update(Request $request, $id)
    {
        $running_text=new RunningText();
        $running_text=RunningText::find($id);
        $running_text->text=$request->text;
        $running_text->save();
        return redirect()->route('running_text');
    }
}
