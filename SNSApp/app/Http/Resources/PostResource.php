<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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

        return  $retList;

        // return parent::toArray($request);
    }
}
