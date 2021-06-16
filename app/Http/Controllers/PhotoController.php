<?php

namespace App\Http\Controllers;
use App\Models\Photo;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(auth()->id());
		if(auth()->user()->photo!=null)
		{

            $picture= auth()->user()->photo;

            $name =basename ( $picture->path);
            if(file_exists(public_path('storage/'.$picture->path))){
                unlink(public_path('storage/'.$picture->path));
            }else{
                return;
            }
            $picture->path=$request['file']->storeAs('images/users/'.auth()->id(),time() . $request['file']->getClientOriginalName(), 'public');
            $picture->save();
            Photo::where('id', $picture->id)->update(array('path' => $picture->path));
		}else
		{

			$picture= Photo::create([
			'path'=>$request['file']->storeAs('images/users/'.auth()->id(),time(). $request['file']->getClientOriginalName(), 'public'),
			'extension'=>'png',
			'user_id'=> auth()->id()
		]);
    }

    $user->photo = $picture;
		return new UserResource($user);
    }

	function download(){
		$picture = Photo::first();

			return response()->download(storage_path('app/public/'.$picture->path));

	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
