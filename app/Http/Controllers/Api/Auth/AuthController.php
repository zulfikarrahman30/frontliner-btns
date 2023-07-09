<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Models\Api\User;

class AuthController extends Controller
{
	public function __construct()
    {
       $this->middleware('api-key');
    }

    public function login(Request $request)
    {
    	$loginCheck = User::loginApi($request);
    	return response()->json($loginCheck, $loginCheck['code']);
    }
}