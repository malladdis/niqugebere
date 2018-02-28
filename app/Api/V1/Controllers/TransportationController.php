<?php

namespace App\Api\V1\Controllers;

use App\Address;
use App\Company;
use App\Demand;
use App\EzBuilder\EzFormBuilder;
use App\Path;
use App\Transportation;
use App\TransportationCategory;
use App\Vehicle;
use Dingo\Api\Http\Request;
use JWTAuth;


class TransportationController extends Controller
{
    public function transportationToCompany(){
        $currentuser= JWTAuth::parseToken()->authenticate();

        $transporter_woreda=Address::where('company_id',$currentuser->company_id)->get();

        $to=Transportation::join('paths','paths.id','=','transportations.path_id')
                         ->join('vehicles','vehicles.id','=','transportations.vehicle_id')
                         ->join('path_woredas','path_woredas.path_id','=','paths.id')
                         ->join("woredas",'woredas.id','=','path_woredas.woreda_id')
                         ->join('addresses','addresses.woreda_id','=','woredas.id')
                         ->join('companies','companies.id','=','addresses.company_id')
                         ->join("demands",'demands.company_id','companies.id')
                         ->join('demand_aggrements',"demand_aggrements.demand_id",'=','demands.id')
                         ->join('product_sub_categories','product_sub_categories.id','demands.product_sub_category_id')
                         ->join('product_categories','product_categories.id','=','product_sub_categories.product_category_id')
                         ->where('demand_aggrements.win','1')
                         ->where(['transportations.company_id'=>$currentuser->company_id,'path_woredas.woreda_id'=>$transporter_woreda[0]['woreda_id']])
                         ->select('demand_aggrements.id','companies.name as to_company','woredas.name as to_woreda','demands.total_quantity','product_categories.name as product_name','product_sub_categories.name as product_sub_name','demands.title','vehicles.plate_no')
                         ->get();

        return response()->json($to);

    }

    public function transportationFromCompany(Request $request){
        $from= Company::join('demand_aggrements','demand_aggrements.company_id','=','companies.id')
            ->join('addresses','addresses.company_id','=','companies.id')
            ->join('woredas','woredas.id','=','addresses.woreda_id')
            ->where(['demand_aggrements.win'=>'1','demand_aggrements.id'=>$request->id])
            ->select('demand_aggrements.id as from_id','companies.name as from_company','woredas.name as from_woreda')
            ->get();
        return response()->json($from);
    }
}
