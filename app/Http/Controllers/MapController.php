<?php

namespace App\Http\Controllers;

use App\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MapController extends Controller
{

    function __construct()
    {

        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maps = Map::all()->where('user_id', '=', auth()->user()->id);
        $maps = json_decode($maps);
        return view('maps.index', compact('maps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('maps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(request()->ajax()){

            $mapData = Input::get('mapData');
            $map = new Map;
            $map->user_id = auth()->user()->id;
            $map->data = json_encode($mapData);
            $map->save();

            return response()->json(['status' => 'succes', 'message' => 'saved in database','data' => $mapData]);

        } else {

            return response()->json(['status' => 'fail', 'message' => 'this is not json']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function show(Map $map)
    {
        if(!$map->user_id == auth()->user()->id){
            abort(401, 'Unauthorized action.');
        }

        return view('maps.single',compact('map'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function edit(Map $map)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Map $map)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function destroy(Map $map)
    {
        if(!$map->user_id == auth()->user()->id){
            abort(401, 'Unauthorized action.');
        }
        $map->delete();
        return redirect()->route('map.index')->withMessage('Map successfully deleted');
    }
}
