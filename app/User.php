<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','active',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
     /**
     * 全User->Tagの取得
     */
     public function tags()
     {
        return $this->morphToMany('App\Tag', 'taggable');
    }
    /**
    */
    public function get_txt(){
    // $id = DB::table('users')->where('name',Auth::user()->name)->value('id');
    //put判定(編集されてないのでそもそもディレクトリが作成されない)
    //モデルにデータの取得は任せる
        if (!Storage::disk('dropbox')->exists("user_file/".$this->id."/mix_box/utxt/")) {
            $count = 1;
            while ($count <= 4) {
                ${'txt'.$count} = "なす";
                $count++;
            }
        } else{
            $txt1 = Storage::disk('dropbox')->get("user_file/".$this->id."/mix_box/utxt/Utxt1.txt");
            $txt2 = Storage::disk('dropbox')->get("user_file/".$this->id."/mix_box/utxt/Utxt2.txt");
            $txt3 = Storage::disk('dropbox')->get("user_file/".$this->id."/mix_box/utxt/Utxt3.txt");
            $txt4 = Storage::disk('dropbox')->get("user_file/".$this->id."/mix_box/utxt/Utxt4.txt");
        //$pic_name = User::find($id)->pic_file_name;
        //cloudder使用
        //$pic_path = '/storage/'.sha1($id).'/pic/'.$pic_name;
        }
        return ["txt1"=>$txt1,"txt2"=>$txt2,"txt3"=>$txt3,"txt4"=>$txt4];
    }
    public function use_dir(){
        if(!Storage::disk('dropbox')->exists("/user_file/".$this->id."/mix_box")){
            if(Storage::disk('dropbox')->makeDirectory("/user_file/".$this->id."/mix_box")){
                return 1;
            } else{
                return 0;
            }
        }
    }
    /**
    *
    */
    public function put_txt($request){
        $count=1;
        while ($count <= 4) {
            if(!$request->{'utxt'.$count})
            {
                $request->{'utxt'.$count} = "nullpo";
            }
            $count++;
        }
        $flg = 1;
        $flg &= Storage::disk('dropbox')->put("/user_file/".$this->id."/mix_box/utxt/Utxt1.txt", $request->utxt1);
        $flg &= Storage::disk('dropbox')->put("/user_file/".$this->id."/mix_box/utxt/Utxt2.txt", $request->utxt2);
        $flg &= Storage::disk('dropbox')->put("/user_file/".$this->id."/mix_box/utxt/Utxt3.txt", $request->utxt3);
        $flg &= Storage::disk('dropbox')->put("/user_file/".$this->id."/mix_box/utxt/Utxt4.txt", $request->utxt4);
        return $flg;
    }
}