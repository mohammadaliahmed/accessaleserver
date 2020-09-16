<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    //
    public function uploadFile(Request $request)
    {
        $milliseconds = round(microtime(true) * 1000);
        if ($request->has('photo')) {
            $file_name = $milliseconds . '.jpg';
            $path = $request->file('photo')->move(public_path("/images"), $file_name);
            $photo_url = url('/images/' . $file_name);
            echo $file_name;
//            return response()->json([
//                'code' => Response::HTTP_OK, 'message' => "false", 'url' => $file_name
//                ,
//            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'code' => 401, 'message' => "false", 'url' => "sdfsdfsd"
                ,
            ], 401);

        }

    }
}
