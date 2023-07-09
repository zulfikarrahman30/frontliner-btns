<?php

namespace App\Http\Controllers\Api\Marketing;

use Illuminate\Http\Request;
use App\Models\Api\Marketing;
use DB;
class ActivityController extends Controller
{
	public function __construct()
    {
       $this->middleware('api-key');
    }

    public function submitActivity(Request $request)
    {
        $data = Marketing::submitActivity($request);
        return response()->json($data, $data['code']);
    }

    public function bookmarOrUnBookmarkkActivity(Request $request)
    {
        $data = Marketing::bookmarOrUnBookmarkkActivity($request);
        return response()->json($data, $data['code']);
    }

    public function getBookmarkAssignment(Request $request)
    {
        $data = Marketing::getBookmarkAssignment($request);
        return response()->json($data, $data['code']);
    }

    public function updateProfile(Request $request)
    {
        $data = Marketing::updateProfile($request);
        return response()->json($data, $data['code']);
    }

    public function updatePhotoProfile(Request $request)
    {
        $data = Marketing::updatePhotoProfile($request);
        return response()->json($data, $data['code']);
    }

    public function changePassword(Request $request)
    {
        $data = Marketing::changePassword($request);
        return response()->json($data, $data['code']);
    }

    public function searchByCategoryName(Request $request)
    {
        $data = Marketing::searchByCategoryName($request);
        return response()->json($data, $data['code']);
    }

    public function searchByBookmarkName(Request $request)
    {
        $data = Marketing::searchByBookmarkName($request);
        return response()->json($data, $data['code']);
    }

    public function searchByNewsName(Request $request)
    {
        $data = Marketing::searchByNewsName($request);
        return response()->json($data, $data['code']);
    }
    
}