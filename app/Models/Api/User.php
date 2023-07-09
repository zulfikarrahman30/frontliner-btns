<?php

namespace App\Models\Api;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    public static function loginApi($request)
    {
    	$result = [];
    	$url = url('admin/image/profile/marketing');
    	$data = DB::table('users as us')
    	->join('marketings as mks','mks.user_id','=','us.id')
    	->select('us.*','mks.type','mks.id as marketing_id','mks.phone'
                ,DB::raw("CONCAT('$url/', mks.photo) as photo"))
    	->where('us.email',$request->email)
    	->first();
    	if($data)
    	{
    		if(!Hash::check($request->password, $data->password))
    		{
    			$result['status'] = 'error';
    			$result['message'] = 'Password yang anda masukkan salah!';
    			$result['code'] = 400;
    			$result['data'] = null;
    		}else{
    			$result['status'] = 'success';
    			$result['message'] = 'Anda berhasil login!';
    			$result['code'] = 200;
    			$result['data'] = $data;
    		}
    	}else{
    		$result['status'] = 'error';
    		$result['message'] = 'Email tidak dapat ditemukan!';
    		$result['code'] = 400;
    		$result['data'] = null;
    	}

    	return $result;
    }
}
