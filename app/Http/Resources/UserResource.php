<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        $data['id']= $this->id;
		$data['fullName']= $this->fullName;
        $data['email']= $this->email;
        $data['isOnline'] = $this->isOnline;
        $data['fcm_token'] = $this->fcm_token;
        $data['image_url']= isset($this->photo)? $this->photo->full_path: null ;
        $data['updated']= true;
        return $data;
    }
}
