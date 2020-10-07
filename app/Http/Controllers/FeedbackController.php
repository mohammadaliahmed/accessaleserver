<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Feedbacks;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FeedbackController extends Controller
{
    //
    public function submitFeedback(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $milliseconds = round(microtime(true) * 1000);
            $feedback = new Feedbacks();
            $feedback->user_id = $request->userId;
            $feedback->message = $request->message;
            $feedback->category = $request->category;
            $feedback->rating = $request->rating;
            $feedback->save();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false"
            ], Response::HTTP_OK);

        }
    }
}
