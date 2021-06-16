<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'email',
        'password',
        'fullName',
        'isOnline',
        'fcm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function photo(){
        return $this->hasOne(Photo::class);
    }
    public function friends(){
        return $this->hasMany(Friend::class);
    }

    // public function pushNotification($token,$message,$body){
    //     try{

    //     $server_key = "AAAAA9mVhf8:APA91bFmcU82cncG6x9GpDPygTJ1J9LC7L9rIZwUY7UshV3PjRRwxw-H8FnoxqWo5cDKsxzuCwzS9ybvJBDXvOpYEwG6biT8oIVMLxEnFuXuIWJlsQg0yCdmm07IGBAkYxqSFlDUn9u-";
	// 	if($token == null) return;
    //     $data = [
    //     "to"=> $token,
    //     "notification"=> [
    //         "title"=> auth()->user()->id." Send you a message",
    //         "body" =>$body,
    //     ],

    //     "data"=>[
    //         "message" =>$message,
    //         "click.action"=>'FLUTTER_NOTIFICATION_CLICK'
    //     ]
    //     ];

    //     $jsonData = json_encode($data);

    //     $url = 'https://fcm.googleapis.com/fcm/send';

    //     $headers = array(
    //         'Content-Type:application/json',
    //         'Authorization:key='.$server_key
    //     );
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    //     $result = curl_exec($ch);
    //     if ($result === FALSE) {
    //         die('Oops! FCM Send Error: ' . curl_error($ch));
    //     }
    //     curl_close($ch);
    //     } catch (\GuzzleHttp\Exception\BadResponseException $e) {
	// 		// return $e->getCode();
    //         if ($e->getCode() === 400) {
    //             return response()->json(['ok'=>'0', 'error'=> 'Invalid Request.'], $e->getCode());
    //         } else if ($e->getCode() === 401) {
    //             return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
    //         }
    //         return response()->json('Something went wrong on the server.', $e->getCode());
    //     }

	// }

}
