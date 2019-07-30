<?php

namespace App\Http\Controllers;
use App\Tag;
use Illuminate\Http\Request;
class Tmp_Tags extends Controller
{
    protected $tags;
    protected $target_str;
    protected $model;
    public function __construct($tags,$model)
    {
        //中身がnullの場合は[]が入る
        $this->tags= $tags;
        $this->model= $model;
        if($this->tags){
            $this->target_str = htmlspecialchars($this->tags,ENT_QUOTES);
        } else{$this->target_str = "";}
    }
    protected function set($tags,$model){
        $this->tags = $tags;
        $this->model = $model;
    }
    public function trim_tags(Int $tag_count = 6){
        //スキルタグ入力のトリム
        if(!$this->target_str){
            return ["test_str_null"];
        }
        $tmp_tags = str_replace("\r",hash('md5','kai'),$this->target_str);
        $pat = '/#[a-z0-9ぁ-んァ-ヶ一-龠]+#/i';
        preg_match_all($pat,$tmp_tags,$arr);
            //基本タグ数6個まで
        $tmp_ary = array_map(function($item){return $item;},$arr[0]);
        $ret_arr = [];
        foreach($tmp_ary as $val){
            if($tag_count <= 0){ break;}
            $ret_arr[] = $val;
            $tag_count--;
        }
        return $ret_arr;
    }
    /**
    * @param model(User | Customer)
    * @return int $count;
    */
    //タグ名とタグidは1対1で被りがあってはいけない
    public function get_model_then_put_tags(){
        $model = $this->model;
        //modelに配列(タグ)を渡す。
        $arr = $this->trim_tags();
        $count = 0;
        //送信の度にタグを初期化
        if(!$model->tags()->get()->isEmpty() ){
            $model->tags()->detach($model->tags()->get()->pluck("id"));
        }
        //名無しの配列の中のタグの数createを実行する
        foreach($arr as $val){
            //*check the model has this tag and then if that exist in pivot*
            if(!$model->tags()->get()->contains('tag_name',$val)){
                if(!Tag::get()->contains('tag_name',$val) && $model->tags()->create(['tag_name'=>$val])){
                    $count++;
                }elseif($model->tags()->attach(Tag::where('tag_name',$val)->first()->id) ){
                    $count++;
                }
        //elseの場合はカウントしない
            }
        //作成したタグの数を返す(空配列の場合は0なのでif文でも使える)
        }

        return $count;
    }
    /**
    * @param  model(User | Customer)
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function take_tags(){
        $model = $this->model;
        return $model->tags()->orderBy('tag_name')->get();
    }
    public function test_request(Request $request){
        var_dump($this->request);
        var_dump($request);
    }
}
