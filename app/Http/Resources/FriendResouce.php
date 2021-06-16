<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class FriendResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
        $data['userID'] = auth()->user()->id != $this->userID ? new UserResource(User::find($this->userID)) :  new UserResource(User::find($this->secondUserID)) ;
        $data['created_at'] = $this->created_at;
        return $data;
    }
}
