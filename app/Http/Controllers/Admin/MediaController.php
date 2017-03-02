<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $upload_path = '/product-images/';
        try {
            $img = Image::make($request->file);
            $image_name = uniqid();
            $img_o = $img->encode('jpg', 100);
            Storage::disk('local')->put($upload_path.$image_name.'.jpg', (string)$img_o);
            $img_t = $img->fit(100, 100, null, 'top')->encode('jpg', 100);
            Storage::disk('local')->put($upload_path.$image_name.'_100x100'.'.jpg', (string)$img_t);

            $success = true;
            $message = 'Successfully uploaded new file!';
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }


        return response()->json(compact('success', 'message', 'image_name'));
    }

}
