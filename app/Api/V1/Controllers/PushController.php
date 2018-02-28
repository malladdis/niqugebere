<?php

namespace App\Api\V1\Controllers;

use App\Company;
use App\Push;
use Dingo\Api\Http\Request;

class PushController extends Controller
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
    public function create(Request $request)
    {
        //
        $company= Company::where('tin',$request->tin)->get();


        return response()->json($company);
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
     * @param  \App\Push  $push
     * @return \Illuminate\Http\Response
     */
    public function show(Push $push)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Push  $push
     * @return \Illuminate\Http\Response
     */
    public function edit(Push $push)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Push  $push
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Push $push)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Push  $push
     * @return \Illuminate\Http\Response
     */
    public function destroy(Push $push)
    {
        //
    }
}
