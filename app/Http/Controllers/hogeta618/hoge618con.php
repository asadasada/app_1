<?php
namespace App\Http\Controllers\hogeta618;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Tag;
use App\Customer;
use App\Upload;
use App\Http\Controllers\Tmp_Tags;
use App\Http\Requests\Custom_Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use JD\Cloudder\Facades\Cloudder;
class hoge618con extends Controller
{
    protected $tag_con = null;
    //user_profile用Controller
    public function __construct()
    {
        //guestなら'/'そうでないなら続行
        //customer側からのuser_profileの参照はcustomer側のコントローラに記述
      $this->middleware('auth');
  }
    //redirect用
  protected function redirectTo()
  {
    return '/';
}
//customer側のページ
public function fromu_C_profile(string $name,String $tag_id=null){
    $customer = Customer::where("name",$name)->first();
    if(Customer::where("name",$name)->first() && ($id = $customer->id)){
    }else{
        //customersテーブルに無かったらリダイレクト
      return redirect(route('home'));
  }
   if($tag_id){
        $tag_id = preg_replace('/^&tags=/','',"$tag_id");
    }
  //
  if($image = Upload::where('user_name',Customer::where('name',$name)->first()->name)->get()->last())
  {
    $image_url=$image->image_url;
    $image_name=$image->image_name;
}else{
    $image_url="null";
    $image_name="";
}
//tags
//tags
    if(!$customer->tags()->get()->isEmpty()){
        $tags_id_ary = $customer->tags()->get()->pluck("id")->toArray();
        $tags_ary = $customer->tags()->get()->pluck("tag_name")->toArray();
    }else{
        $tags_ary = [];
    }
    if($tags_ary != null){
        $tags_ary = array_combine($tags_id_ary, $tags_ary);
    }
        //use tag
    $c_user_ary = [$customer];
        //hashで得たidから元のtag_nameを取得してるだけ
    if($tag_id != null){
        $tmp_name = "";
        $tag = "";
        $tmp_tag_ary = [];
        $tmp_ary = Tag::get()->pluck("tag_name","id")->toArray();
            //array_walkにするかforeachにするか
        array_walk($tmp_ary,function($data,$id) use(&$tmp_tag_ary){$tmp_tag_ary[hash("md5",$id)] = $data;});
        if(array_key_exists($tag_id,$tmp_tag_ary) ){
            $tmp_name = $tmp_tag_ary[$tag_id];
            $tag = Tag::where("tag_name",$tmp_name)->first();
            $c_user_ary = $tag->customers()->get();
        }
    }
$arr = $customer->get_txt();
$txt1 = $arr["txt1"];
$txt2 = $arr["txt2"];
$txt3 = $arr["txt3"];
$txt4 = $arr["txt4"];
return view("customers.customer_profile",["txt1"=>$txt1,"txt2"=>$txt2,"txt3"=>$txt3,"txt4"=>$txt4,"image_url"=>$image_url,"image_name"=>$image_name,"name"=>$name,
    "tags"=>$tags_ary,"customers"=>$c_user_ary]);
}

public function profile(String $name,String $tag_id=null){
    $page_user = User::where("name",$name)->first();
    if (!$page_user->id) {
        return redirect(route('home'));
    }
    if($tag_id){
        $tag_id = preg_replace('/^&tags=/','',"$tag_id");
    }
    //Array
    $page_txt = $page_user->get_txt();
    if($image = Upload::where('user_name',User::where('name',$name)->first()->name)->get()->last())
    {
        $image_url=$image->image_url;
        $image_name=$image->image_name;
    }else{
        $image_url="null";
        $image_name="";
    }
    if(!$page_user->tags()->get()->isEmpty()){
        $tags_id_ary = $page_user->tags()->get()->pluck("id")->toArray();
        $tags_ary = $page_user->tags()->get()->pluck("tag_name")->toArray();
    }else{
        $tags_ary = [];
    }
    if($tags_ary != null){
        $tags_ary = array_combine($tags_id_ary, $tags_ary);
    }
        //use tag
    $user_ary = [$page_user];
        //hashで得たidから元のtag_nameを取得してるだけ
    if($tag_id != null){
        $tmp_name = "";
        $tag = "";
        $tmp_tag_ary = [];
        $tmp_ary = Tag::get()->pluck("tag_name","id")->toArray();
            //array_walkにするかforeachにするか
        array_walk($tmp_ary,function($data,$id) use(&$tmp_tag_ary){$tmp_tag_ary[hash("md5",$id)] = $data;});
        if(array_key_exists($tag_id,$tmp_tag_ary) ){
            $tmp_name = $tmp_tag_ary[$tag_id];
            $tag = Tag::where("tag_name",$tmp_name)->first();
            $user_ary = $tag->users()->get();
        }
    }
        //user_profile
    return view("user_profile",["txt1"=>$page_txt["txt1"],"txt2"=>$page_txt["txt2"],"txt3"=>$page_txt["txt3"],"txt4"=>$page_txt["txt4"],"image_url"=>$image_url,"image_name"=>$image_name,"name"=>$name,"tags"=>$tags_ary,"userss"=>$user_ary]);
}
public function updateDir(Request $prev_input){
    $user = Auth::user();
        //ここでpathを作成
    if(!$user){
        return redirect($this->redirectTo())->withErrors(array("aho"=>"今居ません"));
    }
    if($user->use_dir()){
     return redirect($this->redirectTo());
 }
    /*
    ここでviewのデータをフォームに注入
    */
    if(!$prev_input){
        $txt1 = "";
        $txt2 = "";
        $txt3 = "";
        $txt4 = "";
    } else{
        $txt1 = $prev_input->txt1;
        $txt2 = $prev_input->txt2;
        $txt3 = $prev_input->txt3;
        $txt4 = $prev_input->txt4;
    }
    return view("profile_update",["txt1"=>"$txt1","txt2"=>"$txt2","txt3"=>"$txt3","txt4"=>"$txt4"]);
}
public function edit(Custom_Request $request,$prev_input){
    $user = Auth::user();
    $id = $user->id;
    $count = 0;
    /*
        ここでTmp_Tagsコントローラを呼び出してapp()->make("::class")
    */
    if($this->tag_con != null){
        $this->tag_con->set($request->utxt3,$user);
    }else{
        $this->tag_con = app()->make(Tmp_Tags::class,["tags"=>$request->utxt3,"model"=>$user]);
    }
        $count = $this->tag_con->get_model_then_put_tags();
     //ここで0を出力する場合?(何もしない)
        $user->put_txt($request);
        $image = new Upload();
        if($user->pic_file_name = $image->put_image($request)){
            $user->save();
        }
        return redirect(route("profile",$user->name))->with(["test"=>"$count"]);
    }
    public function test(Request $request){
       $tag_con = app()->make(Tmp_Tags::class);
       $tag_con->test_request($request);
   }
}