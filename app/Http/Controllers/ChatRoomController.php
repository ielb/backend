<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Http\Resources\ChatRoomResource;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChatRoomController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chatRooms = ChatRoom::where('userID',auth()->user()->id)->orWhere('secondUserID',auth()->user()->id)->orderBy('updated_at', 'desc')->get();
		$count = count($chatRooms);
		// $array = [];
		for ($i = 0; $i < $count; $i++) {
			for ($j = $i + 1; $j < $count; $j++) {
				if (isset($chatRooms[$i]->messages->last()->id) && isset($chatRooms[$j]->messages->last()->id) && $chatRooms[$i]->messages->last()->id < $chatRooms[$j]->messages->last()->id) {
					$temp = $chatRooms[$i];
					$chatRooms[$i] = $chatRooms[$j];
					$chatRooms[$j] = $temp;
				}
			}
		}



		return ChatRoomResource::collection($chatRooms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function get_current_user(Request $request)
    {
        $user = User::FindOrFail($request->id);

        if($user!=null){
            return new UserResource($user);
        }
        return "Can't find this user";

    }
    function makeChatRoomAsReaded(Request $request){
		$request->validate([
			'chat_room_id'=>'required',
		]);

		$chatRoom = ChatRoom::findOrFail($request['chat_room_id']);

		foreach ($chatRoom->messages as $message) {
			$message->update(['read'=>true]);
		}

		return response()->json('success',200);
	}
    /**wgg
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'userID'=>'required',
        ]);
        $chatRoom = ChatRoom::create([
            'userID'=>auth()->user()->id,
            'secondUserID'=>$request['userID'],
        ]);
        return new ChatRoomResource($chatRoom);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Response
     */
    public function show(ChatRoom $chatRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatRoom $chatRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatRoom $chatRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $chatRoom = ChatRoom::find($request->id);
        if($chatRoom!=null){
            $chatRoom->delete();
            $chatRoom2 = ChatRoom::find($request->id);
            if($chatRoom2!=null){
                return "00";
            }
            return "1";
        }
        return "0";

    }
}
