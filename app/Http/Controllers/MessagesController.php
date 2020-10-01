<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Ads;
use App\Models\Messages;
use App\Models\Rooms;
use App\Models\User;
use function array_push;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    //
    public function createMessage(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $milliseconds = round(microtime(true) * 1000);

            $message = new Messages();
            $message->messageText = $request->messageText;
            $message->messageType = $request->messageType;
            $message->messageByName = $request->messageByName;
            $message->url = $request->url;
            $message->messageById = $request->messageById;
            $message->roomId = $request->roomId;
            $message->time = $milliseconds;
            $message->mediaTime = $request->mediaTime;
            $message->save();

            $chatRoom = Rooms::find($request->roomId);
            $users = $chatRoom->users;
            $abc = str_replace($request->messageById, '', $users);
            $abc = str_replace(',', '', $abc);
            $user = User::find($abc);

//            $this->sendPushNotification($user->fcmKey,
//                "New Message from " . $request->messageByName,
//                $message->messageText, $request->roomId);
            $messages = DB::table('messages')->where('roomId', $request->roomId)->
            orderBy('id', 'desc')->take(100)->get();

            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'messages' => $messages

                ,
            ], Response::HTTP_OK);
        }
    }

    public function allRoomMessages(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $messages = DB::table('messages')->where('roomId', $request->roomId)->
            orderBy('id', 'desc')->take(100)->get();
            $room = Rooms::find($request->roomId);
            $str_arr = explode(",", $room->users);
            if ($str_arr[0] == $request->userId) {
                $user = User::find($str_arr[1]);
            } else {
                $user = User::find($str_arr[0]);
            }
            $ad=Ads::find($room->adId);


            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false",
                'messages' => $messages,
                'user' => $user,
                'adModel'=>$ad

                ,
            ], Response::HTTP_OK);
        }
    }

    public function userMessages(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $results = DB::select('SELECT * from messages s where roomId In
                                          (Select id from rooms where users
                                           like \'%' . $request->id . '%\' ) and id=(select max(id) from messages p
                                           where p.roomId=s.roomId) ORDER by s.time desc ');

//            $ids = array();
//
//            $rooms = DB::table('rooms') - get();
//            foreach ($rooms as $room) {
//                $str_arr = explode(",", $room->users);
//                if ($str_arr[0] == $request->id) {
//                    array_push($ids, $str_arr[0]);
//                } else {
//                    array_push($ids, $str_arr[1]);
//                }
//            }
//
//            $results=DB::table('messages')->

            $userss = array();
            foreach ($results as $item) {
                $chatRoom = Rooms::find($item->roomId);
                $users = $chatRoom->users;

                $abc = str_replace($request->id, '', $users);
                $abc = str_replace(',', '', $abc);
//            return $abc;

                $us = User::find($abc);

                $item->userName = $us->name;
                $item->picUrl = $us->pic_url;
            }


            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'messages' => $results

                ,
            ], Response::HTTP_OK);
        }
    }
}
