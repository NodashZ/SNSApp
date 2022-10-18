<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Post;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //自分の投稿
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //いいねした投稿
    public function likePosts()
    {
        //Userモデルから中間テーブルのLike先のPostデータを取得
        //belongsToMany('取得するモデル', '中間テーブルのテーブル名', '中間テーブル内でのこのモデルのID名', '中間テーブル内での取得するモデルのID名');
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withTimestamps();
    }
    public function isLike($postId)
    {
        return $this->likePosts()->where('post_id', $postId)->exists();
    }

    public function like($postId)
    {
        if ($this->isLike($postId)) {
            //もし既に「いいね」していたら何もしない
        } else {
            $this->likePosts()->attach($postId);
        }
    }

    public function unlike($postId)
    {
        if ($this->isLike($postId)) {
            //もし既に「いいね」していたら消す
            $this->likePosts()->detach($postId);
        } else {
        }
    }

    //フォロー・フォロワー
    public function follows()
    {
        //belongsToMany('取得するモデル', '中間テーブルのテーブル名', '中間テーブル内でのこのモデルのID名', '中間テーブル内での取得するモデルのID名');
        return $this->belongsToMany(User::class, 'follower_user', 'follower_id', 'user_id');
    }
    public function isFollow($userID)
    {
        return $this->follows()->where('user_id', $userID)->exists();
    }

    public function follow($userID)
    {
        if (!$this->isFollow($userID)) {
            $this->follows()->attach($userID);
        }
    }

    public function unfollow($userID)
    {
        if ($this->isFollow($userID)) {
            $this->follows()->detach($userID);
        } 
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follower_user', 'user_id', 'follower_id');
    }
    public function isFollower($userID)
    {
        return $this->followers()->where('follower_id', $userID)->exists();
    }

}
