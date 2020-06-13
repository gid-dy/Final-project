<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Validator;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCoupon(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status = 1;
            }

            $coupon = new Coupon;
            $coupon->CouponCode = $data['CouponCode'];
            $coupon->Amount = $data['Amount'];
            $coupon->AmountType = $data['AmountType'];
            $coupon->ExpiryDate = $data['ExpiryDate'];
            $coupon->Status = $Status;
            $coupon->save();
            return redirect()->action('CouponsController@viewCoupons')->with('flash_message_success', 'Coupon has been added Successfully');
        }
        return view('admin.coupons.add_coupon');
    }

     public function editCoupon(Request $request, $id=null)
     {
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status = 1;
            }

            Coupon::where(['id'=>$id])->update([
                'CouponCode'=>$data['CouponCode'],
                'Amount'=>$data['Amount'],
                'AmountType'=>$data['AmountType'],
                'ExpiryDate'=>$data['ExpiryDate'],
                'Status'=>$Status
            ]);
            return redirect()->back()->with('flash_message_success', 'Coupon has been updated Successfully');
        }
        $couponDetails = Coupon::where(['id'=>$id])->first();
        return view('admin.coupons.edit_coupon')->with(compact('couponDetails'));

        }



        public function viewCoupons()
    {
        $coupons = Coupon::get();
        return view('admin.coupons.view_coupons')->with(compact('coupons'));
    }


    public function deleteCoupon($id)
    {
        Coupon::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Coupon has been deleted successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
