<?php
namespace App\Http\Controllers\Customers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\User;
use App\Tag;
use App\Upload;
use App\Http\Controllers\Tmp_Tags;
use App\Http\Requests\Custom_Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use JD\Cloudder\Facades\Cloudder;
class C_hoge618con extends Controller
{
    protected $tag_con = null;
    public function __construct()
    {
        //userのprofileはこちらから取得することとする
        $this->middleware('auth:customers');
    }
    //redirect用
    protected function redirectTo()
    {
        return route('customers.home');
    }
    //userのprofile()
    public function fromC_u_profile(string $name,String $tag_id=null){
        $page_user = User::where("name",$name)->first();
        if($page_user && ($id = $page_user->id)){
        }else{
          return redirect(route('customers.home'));
      }
      $page_txt = $page_user->get_txt();
      if($image = Upload::where('user_name',User::where('name',$name)->first()->name)->get()->last())
      {
        $image_url=$image->image_url;
        $image_name=$image->image_name;
    }else{
        $image_url="hoge";
        $image_name="";
    }
    if($tag_id){
        $tag_id = preg_replace('/^&tags=/','',"$tag_id");
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
            //array_walkにするかforeachにするか迷う
        array_walk($tmp_ary,function($data,$id) use(&$tmp_tag_ary){$tmp_tag_ary[hash("md5",$id)] = $data;});
        if(array_key_exists($tag_id,$tmp_tag_ary) ){
            $tmp_name = $tmp_tag_ary[$tag_id];
            $tag = Tag::where("tag_name",$tmp_name)->first();
            $user_ary = $tag->users()->get();
        }
    }
    return view("user_profile",["txt1"=>$page_txt["txt1"],"txt2"=>$page_txt["txt2"],"txt3"=>$page_txt["txt3"],"txt4"=>$page_txt["txt4"],"image_url"=>$image_url,"image_name"=>$image_name,"name"=>$name,"tags"=>$tags_ary,"userss"=>$user_ary]);
}
public function profile(string $name,String $tag_id=null){
   $customer = Customer::where("name",$name)->first();
   if (!($id = $customer->id)) {
    return redirect(route('customers.home'));
}
    if($tag_id){
        $tag_id = preg_replace('/^&tags=/','',"$tag_id");
    }
//Array
if($image = Upload::where('user_name',Customer::where('name',$name)->first()->name)->get()->last())
{
    $image_url=$image->image_url;
    $image_name=$image->image_name;
}else{
           // $image = new \stdClass();
    $image_url="hoge";
    $image_name="";
}
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
public function updateDir(Request $prev_input){
        //ここでpathを作成
    $customer = Auth::guard('customers')->user();
    if(!$customer){
        return redirect($this->redirectTo())->withErrors(array("aho"=>"ログインなし"));
    }
    //ディレクトリが使用できない場合は...
    if(!$customer->use_dir()){
        redirect($this->redirectTo());
    }
    if(!$prev_input){
        $txt2 = "";
        $txt3 = "";
        $txt4 = "";
    } else{
        $txt2 = $prev_input->txt2;
        $txt3 = $prev_input->txt3;
        $txt4 = $prev_input->txt4;
    }
    return view("customers.c_profile_update",["txt2"=>"$txt2","txt3"=>"$txt3","txt4"=>"$txt4"]);
}
public function edit(Custom_Request $request){
    $customer = Auth::guard('customers')->user();
    $count = 0;
    /*
    tag_con
    */
    if($this->tag_con != null){
        $this->tag_con->set($request->utxt3,$customer);
    }else{
        $this->tag_con = app()->make(Tmp_Tags::class,["tags"=>$request->utxt3,"model"=>$customer]);
    }
     $count = $this->tag_con->get_model_then_put_tags();
     //
    $customer->put_txt($request);
    $image = new Upload();
    $customer->pic_file_name = "";
    if ($customer->pic_file_name = $image->put_image($request)) {
    //image_urlが保存される(ただUpload側でもuser_nameを保存したので必要はない)
        $customer->save();
        return redirect(route("customers.profile",Auth::guard('customers')->user()->name));
    }else {
        return redirect(route("customers.profile",Auth::guard('customers')->user()->name));
    }
}
}