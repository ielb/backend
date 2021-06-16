<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Http\Resources\FriendResouce;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friends = Friend::where('userID',auth()->user()->id)->orWhere('secondUserID',auth()->user()->id)->orderBy('updated_at', 'desc')->get();
		return FriendResouce::collection($friends );
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
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
        ]);
        $friend = Friend::create([
            'userID'=>auth()->user()->id,
            'secondUserID'=>$request['user_id'],
        ]);
        return new FriendResouce($friend);
    }

}
