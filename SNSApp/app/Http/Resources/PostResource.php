<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\Http\Resources\UserResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $retList = parent::toArray($request);
        $retList["isLiked"] = $this->isLiked();
        $retList["likesCount"] = $this->likesCount();

        $user = User::findOrFail($this->user_id);
        $retList["userName"] = $user->name;

        return  $retList;
    }
}
