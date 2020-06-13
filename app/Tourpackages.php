<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use DB;

class Tourpackages extends Model
{
    public function tourtypes(){
        return $this->hasMany('App\Tourtype','Package_id');
    }

    public function accommodations(){
        return $this->hasMany('App\Accommodation','Package_id');
    }

    public function tourincludes(){
        return $this->hasMany('App\Tourinclude','Package_id');
    }

    public function tourtransports(){
        return $this->hasMany('App\Tourtransportation','Package_id');
    }

    public function tourlocations(){
        return $this->hasMany('App\Tourlocations','Package_id');
    }
    public function packageimages(){
        return $this->hasMany('App\Packageimages','Package_id');
    }

    public static function cartCount(){
        if(Auth::check()){
            //user is logged in, we will use Auth
            $UserEmail = Auth::user()->UserEmail;
            $cartCount = DB::table('carts')->where('UserEmail',$UserEmail)->count('Session_id');
        }else{
            $Session_id = Session::get('Session_id');
            $cartCount = DB::table('carts')->where('Session_id',$Session_id)->count('Session_id');
        }
        return $cartCount;
    }
    public static function tourpackagesCount($cat_id){
        $catCount = Tourpackages::where(['Category_id'=>$cat_id, 'Status'=>1])->count();
        return $catCount;
    }
    Public static function getCurrencyRates($PackagePrice){
        $getCurrencies = Currency::where('Status', 1)->get();
        foreach($getCurrencies as $currency){
            if($currency->CurrencyCode == "USD"){
                $USD_Rate = round($PackagePrice/$currency->ExchangeRate,2);
            }elseif($currency->CurrencyCode == "GBP"){
                $GBP_Rate = round($PackagePrice/$currency->ExchangeRate,2);
            }elseif($currency->CurrencyCode == "EUR"){
                $EUR_Rate = round($PackagePrice/$currency->ExchangeRate,2);
            }elseif($currency->CurrencyCode == "FRF"){
                $FRF_Rate = round($PackagePrice/$currency->ExchangeRate,2);
            }elseif($currency->CurrencyCode == "BRL"){
                $BRL_Rate = round($PackagePrice/$currency->ExchangeRate,2);
            }
        }
        $currenciesArr = array('USD_Rate'=>$USD_Rate,'GBP_Rate'=>$GBP_Rate,'EUR_Rate'=>$EUR_Rate,'FRF_Rate'=>$FRF_Rate,'BRL_Rate'=>$BRL_Rate);
        return $currenciesArr;
    }
    public static function getTourSize($Package_id, $TourTypeName){
        $getTourSize = Tourtype::select('TourTypeSize')->where(['Package_id'=>$Package_id, 'TourTypeName'=>$TourTypeName])->first();
        return $getTourSize->TourTypeSize;
    }

    public static function getPackagePrice($Package_id,$TourTypeName){
        $getPackagePrice = Tourtype::select('PackagePrice')->where(['Package_id'=>$Package_id,'TourTypeName'=>$TourTypeName])->first();
        return $getPackagePrice->PackagePrice;
    }

    public static function deleteCartPackage($Package_id, $UserEmail){
        DB::table('carts')->where(['Package_id'=>$Package_id,'UserEmail'=>$UserEmail])->delete();
    }

    public static function getPackageStatus($Package_id){
        $getPackageStatus = Tourpackages::select('Status')->where('id', $Package_id)->first();
        return $getPackageStatus->Status;
    }

    public static function getCategoryStatus($Category_id){
        $getCategoryStatus = Tourpackagecategory::select('CategoryStatus')->where('id', $Category_id)->first();
        return $getCategoryStatus->CategoryStatus;
    }

    public static function getTourTypeCount($Package_id,$TourTypeName){
        $getTourTypeCount = Tourtype::where(['Package_id'=>$Package_id,'TourTypeName'=>$TourTypeName])->count();
        return $getTourTypeCount;
    }

    public static function getCart($PackagePrice){
        $getCart = DB::table('carts')->where(['PackagePrice'=>$PackagePrice])->count();
        return $getCart;
    }

    public static function getGrandTotal(){
        $getGrandTotal = "";
        $SurName = Auth::user()->UserEmail;
        $userCart = DB::table('carts')->where('UserEmail',$SurName)->get();
        $userCart = json_decode(json_encode($userCart),true);
        // echo "<pre>"; print_r($userCart); die;
        foreach($userCart as $tour){
            $tourPrice = Tourtype::where(['Package_id'=>$tour['Package_id'],'TourTypeName'=>$tour['TourTypeName']])->first();
            $PackagePriceArray[] = $tourPrice->PackagePrice;
        }
        //echo print_r($PackagePriceArray);die;
        $GrandTotal = array_sum($PackagePriceArray) - Session::get('CouponAmount');
        return $GrandTotal;
    }
}
