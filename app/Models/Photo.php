<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','path','extension'];

	protected $appends = ['full_path'];

	public function getFullPathAttribute() {
        return url(Storage::url($this->path));
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
