<?php

namespace App\Api\V1\Controllers;

use App\Address;
use App\Company;
use App\Cover;
use App\Logo;
use App\Searchable;
use App\Slide;
use App\TransportationBid;
use App\User;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Http\Request;
use JWTAuth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function identify(Request $request){
        $result= Company::join('users','users.company_id','=','companies.id')
                  ->where(['companies.tin'=>$request->tin,'users.permission_id'=>'1'])->get();
        if(count($result)>0){
            return response()->json(['token'=>'ok','status'=>'ok'],201);
        }else{
            return response()->json(['token'=>'ok','status'=>'no'],201);
        }
    }
    public function getName(Request $request)
    {
        //
        $company=Company::where("id",$request->id)
            ->get();

        return response()->json($company);
    }

    public function aboutUs(Request $request){
        $about_us=Company::where('id',$request->id)
                  ->select("description")->get();
        return response()->json($about_us);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $currentuser= JWTAuth::parseToken()->authenticate();

        $profile=Company::join('covers','covers.company_id','companies.id')
                       ->where("companies.id","=",$currentuser->company_id)
                       ->select("name","covers.photo_path as logo","companies.description")
                       ->get();
        return response()->json($profile);

    }

    public function uploadProfile(Request $request){
        $currentuser= JWTAuth::parseToken()->authenticate();

        $file_name = time().'.'.$request->photo->getClientOriginalExtension();
        $ocvers=new Cover();
        $ocvers->company_id=$currentuser->company_id;
        $ocvers->photo_path="public/uploads/".$file_name;
        if ($ocvers->save()){
            $request->photo->move(public_path('uploads'), $file_name);
            return response()->json([
                'status' =>'ok',
                'token' => "ok"
            ], 201);

        }
    }

    public function description(Request $request){
        $currentuser= JWTAuth::parseToken()->authenticate();
        $company=Company::find($currentuser->company_id);
        $company->description=$request->description;
        if ($company->save()){
            return response()->json([
                'status' =>'ok',
                'token' => "ok"
            ], 201);
        }
    }

    public function show()
    {
        $companies= Company::join('covers','covers.company_id','=','companies.id')
                       ->where('companies.category_id','=','1')
                      ->select('companies.id','companies.name','covers.photo_path')->get();

        return response()->json($companies);

    }

    public function company_detail(Request $request){
        $company= Company::join('covers','covers.company_id','=','companies.id')
                 ->where('companies.id',$request->id)
                 ->select('companies.name','covers.photo_path as photo')->get();

        return response()->json($company);
    }

    public function approval(){

        $companies= Company::join('users','users.company_id','=','companies.id')
                   ->where('users.permission_id','0')
                   ->select("users.id","companies.name as company_name","users.first_name as owner_name","users.phone")->get();
        return response()->json($companies);
    }

    public function getTransporters(Request $request){
        $currentuser= JWTAuth::parseToken()->authenticate();

        $transportationsBid=TransportationBid::join('demand_aggrements','demand_aggrements.id','=',"transportation_bids.demand_agreement_id")
                            ->join("companies","companies.id","=","transportation_bids.company_id")
                            ->join("covers","covers.company_id",'companies.id')
                            ->select('companies.name as company_name','covers.photo_path as company_photo',"transportation_bids.price as capacity")
                            ->where(["transportation_bids.company_id"=>$currentuser->company_id,"transportation_bids.demand_agreement_id"=>$request->id])->get();

        /*$my_woreda=Address::where('company_id',$currentuser->company_id)->get();
        $transporters=Company::join('transportations','transportations.company_id','=','companies.id')
            ->join("paths","paths.id","transportations.path_id")
            ->join('path_woredas','path_woredas.path_id','=','paths.id')
            ->join('vehicles','vehicles.id','transportations.vehicle_id')
            ->join("covers","covers.company_id",'companies.id')
            ->where(['companies.category_id'=>'4','path_woredas.woreda_id'=>$my_woreda[0]->woreda_id])
            ->select('companies.name as company_name','covers.photo_path as company_photo','vehicles.plate_no','vehicles.capacity')
            ->get();*/

        return response()->json($transportationsBid);

    }


}
