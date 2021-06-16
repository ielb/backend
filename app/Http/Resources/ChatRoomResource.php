<?php

namespace App\Http\Resources;
use APP\Models\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data ['id'] = $this->id;
        $data ['created_at'] = $this->created_at;
        $data['user'] = auth()->user()->id == $this->userID ? new UserResource(User::find($this->secondUserID)) :  new UserResource(User::find($this->userID)) ;
        $data['messages'] = MessageResource::collection($this->messages);
        return $data;
    }
}
