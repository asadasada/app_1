<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'tag_name',
    ];
     /**
     * 所有しているtagableモデルの全取得
     */
     public function all_counts(){
         return $this->withCount('users','customers')->get();
     }
     public function users(){
        return $this->morphedByMany('App\User','taggable')->withTimestamps();
    }
    public function customers(){
        return $this->morphedByMany('App\Customer','taggable')->withTimestamps();
    }
}
