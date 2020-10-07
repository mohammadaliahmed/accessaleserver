<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Ads;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    //
    public function createAd(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $milliseconds = round(microtime(true) * 1000);
//
            $ad = new Ads();
            $ad->title = $request->title;
            $ad->description = $request->description;
            $ad->price = $request->price;
            $ad->user_id = $request->userId;
            $ad->time = $milliseconds;
            $ad->city = 'Lahore';
            $ad->area = $request->area;
            $ad->category = $request->category;
            $ad->images = $request->images;
            $ad->promoted = 0;
            $ad->promotion_end_time = 0;
            $ad->latitude = $request->lat;
            $ad->longitude = $request->lon;
            $ad->status = 'pending';

            $ad->save();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false",'adModel'=>$ad
            ], Response::HTTP_OK);
        }
    }

    public function allAds(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $ads = DB::table('ads')
                ->where('category', 'LIKE', '%' . $request->category . '%')
                ->where('price', '>=', $request->startPrice)
                ->where('price', '<=', $request->endPrice)
                ->where('city', 'LIKE', '%' . $request->location . '%')
                ->orderBy('id', 'desc')->get();

            foreach ($ads as $ad) {
                $user = User::find($ad->user_id);
                $ad->user = $user;
            }
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'ads' => $ads
            ], Response::HTTP_OK);
        }
    }

    public function search(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $ads = DB::table('ads')
                ->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                ->orderBy('id', 'desc')->get();

            foreach ($ads as $ad) {
                $user = User::find($ad->user_id);
                $ad->user = $user;
            }
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'ads' => $ads
            ], Response::HTTP_OK);
        }
    }

    public function getMyAds(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $ads = DB::table('ads')->where('user_id', $request->userId)
                ->orderBy('id', 'desc')->get();

            foreach ($ads as $ad) {
                $user = User::find($ad->user_id);
                $ad->user = $user;
            }
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'ads' => $ads
            ], Response::HTTP_OK);
        }
    }

    public function adDetails(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $add = Ads::find($request->id);
            $add->user = User::find($add->user_id);

            $ads = DB::table('ads')->whereNotIn('id', [$request->id])->orderBy('id', 'desc')->get();
            foreach ($ads as $ad) {
                $user = User::find($ad->user_id);
                $ad->user = $user;
            }

            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'ads' => $ads, 'adModel' => $add
            ], Response::HTTP_OK);
        }
    }
}

