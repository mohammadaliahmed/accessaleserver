<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use function md5;
use function sizeof;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $user = DB::table('users')
                ->where('email', $request->email)
                ->first();


            if ($user != null) {
                return response()->json([
                    'code' => 302, 'message' => 'Account already exist',
                ], 302);
            } else {

                if ($request->email == null) {
                    return response()->json([
                        'code' => 302, 'message' => 'Empty params',
                    ], Response::HTTP_OK);
                } else {
                    $milliseconds = round(microtime(true) * 1000);

                    $user = new User();
                    $user->name = 'name';
                    $user->email = $request->email;
                    $user->username = $request->username;
                    $user->password = md5($request->password);
                    $user->time = $milliseconds;
                    $user->save();
                    return response()->json([
                        'code' => Response::HTTP_OK, 'message' => "false", 'user' => $user
                        ,
                    ], Response::HTTP_OK);
                }

            }

        }
    }

    public function completeProfile(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->pic_url = $request->picUrl;
            $user->update();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'user' => $user
                ,
            ], Response::HTTP_OK);


        }
    }

    public function login(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $user = DB::table('users')->where('email', $request->email)
                ->where('password', md5($request->password))->first();

            if ($user == null) {
                return response()->json([
                    'code' => Response::HTTP_NOT_FOUND, 'message' => "Please check your Email and password "
                    ,
                ], Response::HTTP_OK);
            } else {

                return response()->json([
                    'code' => Response::HTTP_OK, 'message' => "false", 'user' => $user
                    ,
                ], Response::HTTP_OK);


            }
        }
    }

    public function updateFcmKey(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $user = User::find($request->id);
            $user->fcm_key = $request->fcmKey;
            $user->update();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'user' => $user
            ], Response::HTTP_OK);
        }
    }


}
