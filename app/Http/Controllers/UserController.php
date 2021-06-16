<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Photo;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function register( UserRequest $request){

        $user = User::create([
            'email'=>$request['email'],
            'password'=>Hash::make($request['password']),
            'fullName'=>$request['fullName'],
            'isOnline' => true,
        ]);

        return new UserResource($user);
    }
    public function current()  {
		return new UserResource(auth()->user());
	}

	public function updateEmail(Request $request){
		$newuser = new User();
		$request->validate([
			'email'=>'required|email|unique:users,email,'.auth()->id()
		]);
        $user = User::find(auth()->id());
        $user->email = $request['email'];

        $user->save();

		return new UserResource($user);

    }
    public function changePass(Request $request){

        $request->validate([
            'current_password' => 'required|min:8',
            'new_password' => 'required',
        ]);
        if( Hash::check($request['current_password'], auth()->user()->password)){

        $user = User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return "password changed";
        }{
            return "password doesn't match";
        }
    }


	public function updateUser(Request $request){
		$user = User::find(auth()->id());
		$user->isOnline = $request['isOnline'];
		$user->save();
		return new UserResource($user);

	}


    public function deleteUser(Request $request){
        $id = $request['id'];
        $picture = new Photo();
        $user = new User();
        if(auth()->id() ==  $id){

        $user = User::find(auth()->id());

        if($user->photo!=null)
        {
        if(file_exists(public_path('storage/'. $user->photo->path))){
            unlink(public_path('storage/'. $user->photo->path));
        }
    }
        DB::delete('DELETE FROM users WHERE id = '. $user->id);
        DB::delete('DELETE FROM photos WHERE user_ID = '. $user->id);
        DB::delete('DELETE FROM chat_rooms WHERE userID = '. $user->id);
        DB::delete('DELETE FROM chat_rooms WHERE secondUserID = '. $user->id);
        DB::delete('DELETE FROM messages WHERE user_id = '. $user->id);

        $user->delete();

        return response()->json('User deleted succefuly',200);
        }
        return response()->json("Something went wrong with the server",220);

    }

    public function searchForUser(Request $request){

        $user = new User();
        $user->id = $request['user_id'];
        if(User::find($user->id)){
        $user= User::findOrFail(  $user->id );
        return new UserResource ($user);
        }
        return response()->json('User not found',404);
    }

	public function fcmToken(Request $request){

		$user = User::find(auth()->id());
        $user->update(['fcm_token'=>$request['fcm_token']]);
        $user->fcm_Token = $request['fcm_token'];
        $user->save();

		return response()->json('fcm updated successfully',200);

    }

}
