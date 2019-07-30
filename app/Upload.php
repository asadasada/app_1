<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JD\Cloudder\Facades\Cloudder;

class Upload extends Model
{
    public function saveImages(Request $request, $image_url) {
        //customerのUploadは"customers"
        $image = new Upload();
        $image->image_name = $request->file('pic')->getClientOriginalName();
        $image->image_url = $image_url;
        $image->user_name = auth()->user()->name;
        $image->save();
    }
    //return $imagename;
    public function put_image(Request $request){
        if ($request->hasFile("pic") && $request->file("pic")->isValid()) {
            $image = $request->file('pic');
            $name = $request->file('pic')->getClientOriginalName();
            $image_name = $request->file('pic')->getRealPath();
            Cloudder::upload($image_name, null);
            $image_url = Cloudder::show(Cloudder::getPublicId());
            $image_url = substr($image_url,0,strlen($image_url)-4);
            $image->move(public_path("uploads"), $name);
            $this->saveImages($request, $image_url);
            if(!$image_name){
                $image_name = "nurupo";
            }
            return $image_name;
        }else {
            return 0;
        }
    }
}
