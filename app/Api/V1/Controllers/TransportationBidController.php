<?php

namespace App\Api\V1\Controllers;

use App\TransportationBid;
use Dingo\Api\Http\Request;
use JWTAuth;

class TransportationBidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bids = TransportationBid::join('demand_aggrements','demand_aggrements.id','=','transportation_bids.demand_agreement_id')
                                    ->join('demands','demands.id','=','demand_aggrements.demand_id')
                                    ->join('companies','companies.id','=','transportation_bids.company_id')
                                    ->join('addresses','addresses.company_id','=','companies.id')
                                    ->join('woredas','addresses.woreda_id','=','woredas.id')
                                    ->Select(['companies.name','addresses.phone','woredas.name as woreda','demands.id','demands.title','transportation_bids.price','transportation_bids.id as tid'])
                                    ->where(["demands.company_id"=>auth()->user()->company_id,"transportation_bids.win"=>0])->get();
        return view('cfc.bids',compact('bids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $currentuser= JWTAuth::parseToken()->authenticate();


        $transportations=new TransportationBid();
        $transportations->company_id=$currentuser->company_id;
        $transportations->demand_agreement_id=$request->id;
        $transportations->price=$request->price;
        $transportations->win='0';
        if($transportations->save()){
            return response()->json(['token'=>"ok","status"=>"ok"],201);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        TransportationBid::create([
           'company_id'=> auth()->user()->company_id,
           'demand_agreement_id'=>$id,
           'price'=>$request->bid
        ]);
        $message = "you have successfully submitted your bid";
        session()->regenerate();
        session()->flash('saved',$message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TransportationBid  $transportationBid
     * @return \Illuminate\Http\Response
     */
    public function show(TransportationBid $transportationBid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransportationBid  $transportationBid
     * @return \Illuminate\Http\Response
     */
    public function edit(TransportationBid $transportationBid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\TransportationBid  $transportationBid
     * @return \Illuminate\Http\Response
     */
    public function update(TransportationBid $transportationBid)
    {
        $transportationBid->win = 1;
        $transportationBid->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransportationBid  $transportationBid
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransportationBid $transportationBid)
    {
        //
    }
}
