<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function login(Request $request)
	{


        try {
			$http = new \GuzzleHttp\Client;

			$response = $http->post('http://localhost:8012/backend/public/oauth/token', [
				'form_params' => [
					'grant_type' => 'password',
					'client_id' => '2',
					'client_secret' => 'GO0gL4L121OWXfoxMuV0uqoCEhYh0xPKtRUU3Tof',
					'username' => $request->email,
					'password' => $request->password,
					'scope' => '*',
				],
			]);

			return  $response->getBody();
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			if ($e->getCode() === 400) {
                return response()->json(['ok'=>'0', 'error'=> 'Your credentials are incorrect. Please try again or create an accounts'], $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json(['error'=>'Something went wrong on the server.'], $e->getCode());
		}
	}




	function logout(){

    auth()->user()->tokens->each(function($token){

			$token->delete();
		});
		return response()->json('logout successfully',200);
	}

}
