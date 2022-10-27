<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //この投稿にいいねしているユーザー一覧
    public function likes()
    {
        //belongsToMany('取得するモデル', '中間テーブルのテーブル名', '中間テーブル内でのこのモデルのID名', '中間テーブル内での取得するモデルのID名');
        return $this->belongsToMany(User::class,'likes','post_id','user_id')->withTimestamps();
    }
    
    public function likesCount()
    {
        $likes = $this->likes();

        if ( $likes){
            return $likes->count();
        }

        return 0;
    }

    //ログインユーザーがいいねしているか
    public function isLiked()
    {
        return $this->likes()->where('user_id',Auth::user()->id)->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
