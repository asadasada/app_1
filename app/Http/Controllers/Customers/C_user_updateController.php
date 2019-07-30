<?php
namespace App\Http\Controllers\hogeta408;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class user_updateController extends Controller
{
    //profile用Controller
    public function __construct()
    {
        $this->middleware('guest:customers');
    }
    //redirect用
    protected function redirectTo()
    {
        $hoge = Auth::user();
        return $hoge->name.'/profile';
    }
    //profile()
    public function profile(){
        return view("user_profile");
    }
    public function update(){
        //ここでpathを作成
        $id = DB::table('users')->where('name',Auth::user()->name)->value('id');
        if($id && Storage::makeDirectory("user_file/".$id."/pic") && Storage::makeDirectory("user_file/".$id."/mix_box")){
        } else{
            return redirect($this->redirectTo());
        }
        return view("profile_update");
    }
}
