<?php

namespace App\Http\Controllers\Api\Home;

use Illuminate\Http\Request;
use App\Models\Api\Home;

class HomeController extends Controller
{
	public function __construct()
    {
       $this->middleware('api-key');
    }

    public function getDataHome(Request $request)
    {
    	$data = Home::getDataHome($request);
    	return response()->json($data, $data['code']);
    }

    public function getAllAssigment(Request $request)
    {
        $data = Home::getAllAssigment($request);
        return response()->json($data, $data['code']);
    }

    public function getAllAssigmentByCategory(Request $request)
    {
    	$data = Home::getAllAssigmentByCategory($request);
    	return response()->json($data, $data['code']);
    }

    public function getDetailAssigment(Request $request)
    {
    	$data = Home::getDetailAssigment($request);
    	return response()->json($data, $data['code']);
    }

    public function getAllRiwayat(Request $request)
    {
        $data = Home::getAllRiwayat($request);
        return response()->json($data, $data['code']);
    }

    public function getNumberAdmin()
    {
        $data = Home::getNumberAdmin();
        return response()->json($data, $data['code']);
    }
}