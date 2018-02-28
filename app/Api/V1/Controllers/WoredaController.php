<?php

namespace App\Http\Controllers;

use App\Woreda;
use Illuminate\Http\Request;

class WoredaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function show(Woreda $woreda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function edit(Woreda $woreda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Woreda $woreda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Woreda $woreda)
    {
        //
    }

    public function getWoreda(Request $request){
        $zones = Woreda::where('zone_id','=',$request->id)->get();
        return response()->json($zones);
    }
}
