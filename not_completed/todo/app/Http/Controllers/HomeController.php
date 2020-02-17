<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ListDetail;
// use App\ListItem;
//use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = ListDetail::all();
        // $list_item = ListItem::all();
        //$data = DB::table('lists')->join('list_items','list_items.list_id','=','lists.id')->select('lists.id AS list_id','lists.name AS list_name','list_items.id AS item_id','list_items.name AS item_name')->get();
        return view('home',['data'=>$data]);
    }
}
