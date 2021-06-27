<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChatRoom;


class Message extends Model
{
    use HasFactory;
    protected $fillable = ['body','user_id','id','read','isFile'];

	public function chatRoom(){

		return $this->belongsTo('App\Models\ChatRoom');
	}
}
