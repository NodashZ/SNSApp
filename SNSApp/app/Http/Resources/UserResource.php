<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class UserResource extends JsonResource
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
        $retList["follows"] = $this->follows()->get();
        $retList["followers"] = $this->followers()->get();

        return  $retList;
    }
}
