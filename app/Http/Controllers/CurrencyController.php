<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
{
    public function addCurrency(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['Status'])){
                $Status=0;
            }else{
                $Status=1;
            }
            $currency = new Currency;
            $currency->CurrencyCode = $data['CurrencyCode'];
            $currency->ExchangeRate = $data['ExchangeRate'];
            $currency->Status = $Status;
            $currency->save();
            return redirect()->back()->with('flash_message_success', 'Currency added Successfully');

        }
        return view('admin.currency.add_currency');
    }

    public function editCurrency(Request $request, $id){
        $currencyDetails = Currency::where('id', $id)->first();
        if ($request->isMethod('post')) {
            $data = $request->all();
            if(empty($data['Status'])){
                $Status=0;
            }else{
                $Status=1;
            }
            Currency::where('id', $id)->update([
                'CurrencyCode'=>$data['CurrencyCode'],
                'ExchangeRate'=>$data['ExchangeRate'],
                'Status'=>$Status
            ]);
            return redirect()->back()->with('flash_message_success', 'Currency has been updated Successfully');

        }
        return view('admin.currency.edit_currency')->with(compact('currencyDetails'));
    }

    public function viewCurrency(){
        $currencies = Currency::get();
        return view('admin.currency.view_currencies')->with(compact('currencies'));
    }

    public function deleteCurrency($id){
        Currency::where('id' ,$id)->delete();
        return redirect()->back()->with('flash_message_success', 'Currency has been deleted successfully!');
    }
}
