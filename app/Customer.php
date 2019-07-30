<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Customer extends Authenticatable
{
 protected $fillable = [
   'name', 'email', 'password','active',
 ];

 protected $hidden = [
   'password', 'remember_token',
 ];
   //全Customer->Tagの取得
 public function tags()
 {
  return $this->morphToMany('App\Tag', 'taggable');
}
public function get_txt() {
          // $id = DB::table('users')->where('name',Auth::user()->name)->value('id');
    //put判定(編集されてないのでそもそもディレクトリが作成されない)
  if (!Storage::disk('dropbox')->exists("customers_file/".$this->id."/mix_box/utxt/Ctxt1.txt")) {
    $count = 1;
    while ($count <= 4) {
      ${'txt'.$count} = "なす";
      $count++;
    }

  } else{
    $txt1 = Storage::disk('dropbox')->get("customers_file/".$this->id."/mix_box/utxt/Ctxt1.txt");
    $txt2 = Storage::disk('dropbox')->get("customers_file/".$this->id."/mix_box/utxt/Ctxt2.txt");
    $txt3 = Storage::disk('dropbox')->get("customers_file/".$this->id."/mix_box/utxt/Ctxt3.txt");
    $txt4 = Storage::disk('dropbox')->get("customers_file/".$this->id."/mix_box/utxt/Ctxt4.txt");
        //cloudder使用
        //$pic_path = '/storage/'.sha1($id).'/pic/'.$pic_name;
        //最新の画像を反映させる
  }
  return ["txt1"=>$txt1,"txt2"=>$txt2,"txt3"=>$txt3,"txt4"=>$txt4];
}
public function use_dir(){
  if(!Storage::disk('dropbox')->exists("/customers_file/".$this->id."/mix_box")){
    if(Storage::disk('dropbox')->makeDirectory("/customers_file/".$this->id."/mix_box")){
      return 1;
    } else{
      return 0;
    }
  }
}
public function put_txt(Request $request){
  $count=1;
  while ($count <= 4) {
    if(!$request->{'utxt'.$count})
    {
      $request->{'utxt'.$count} = "nullpo";
    }
    $count++;
  }
  $flg = 1;
  $flg &= Storage::disk('dropbox')->put("customers_file/".$this->id."/mix_box/utxt/Ctxt1.txt", $request->utxt1);
  $flg &= Storage::disk('dropbox')->put("customers_file/".$this->id."/mix_box/utxt/Ctxt2.txt", $request->utxt2);
  $flg &= Storage::disk('dropbox')->put("customers_file/".$this->id."/mix_box/utxt/Ctxt3.txt", $request->utxt3);
  $flg &= Storage::disk('dropbox')->put("customers_file/".$this->id."/mix_box/utxt/Ctxt4.txt", $request->utxt4);
}
}