<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    //

    public function createPost(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $post = new Posts();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = $request->user_id;
            $post->type = $request->type;
            $post->url = $request->url;
            $post->category = $request->category;
            $post->save();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false"
            ], Response::HTTP_OK);
        }
    }

    public function allPosts(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $posts = DB::table('posts')->orderBy('id','desc')->get();

            foreach ($posts as $post) {
                $user = User::find($post->user_id);
                $post->user = $user;
            }
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'posts' => $posts
            ], Response::HTTP_OK);
        }
    }
}
