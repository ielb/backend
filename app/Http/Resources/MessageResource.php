<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data['id'] =$this->id;
        $data['body'] = $this->body;
		$data['read'] = $this->read;
        $data['isImage'] = $this->isImage;
		$data['user_id'] = $this->user_id;
		$data['chat_room_id'] = $this->chat_room_id;
        $data['created_at'] = $this->created_at;
        $data['updated']= true;
		return $data;
    }
}
