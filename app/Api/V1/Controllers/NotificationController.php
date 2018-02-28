<?php

namespace App\Api\V1\Controllers;

use App\Demand;
use App\Notification;
use Dingo\Api\Http\Request;
use JWTAuth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currentuser= JWTAuth::parseToken()->authenticate();

        $notification =Notification::where(['company_id'=>$currentuser->company_id,'seen'=>'0'])->get();
        return response()->json($notification);
    }

    public function notificationCount(){
        $currentuser= JWTAuth::parseToken()->authenticate();
        $notification =Notification::where(['company_id'=>$currentuser->company_id,'seen'=>'0'])->get();
        $total_notification=count($notification);
        return response()->json(['token'=>'ok','status'=>$total_notification]);
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
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        if($request->category_id==1){
          $demand_notifications=Demand::join('demand_aggrements','demand_aggrements.demand_id','=','demands.id')
              ->join("companies","companies.id","=","demands.company_id")
              ->where(["demand_aggrements.id"=>$request->id,"demand_aggrements.win"=>"1"])
              ->select("companies.name as company_name","demands.title","demands.total_quantity")->get();

          return response()->json($demand_notifications);
        }else if($request->category_id==2){

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
        $currentuser= JWTAuth::parseToken()->authenticate();

        $updates= Notification::where('company_id',$currentuser->company_id)
                  ->update(['seen'=>'1']);

        return response()->json(['token'=>'ok','status'=>'ok'],201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
