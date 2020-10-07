<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Ads;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentsController extends Controller
{
    //

    public function payForAd(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {


            $payment=new Payments();
            $payment->payment_type=$request->paymentType;
            $payment->payment_id=$request->paymentId;
            $payment->ad_id=$request->adId;
            $payment->promotion_type=$request->promotionType;
            $payment->amount=$request->amount;
            $payment->save();

            $ad=Ads::find($request->adId);
            $ad->promoted=true;
            
            $ad->update();

            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false"
            ], Response::HTTP_OK);
        }
    }

}
