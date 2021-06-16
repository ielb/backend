<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','chat_id','path','extantion'];

    public function chatRoom(){

		return $this->belongsTo('App\Models\chatRoom');
	}
}
