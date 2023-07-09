<?php
 
namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
class ApiKey
{
	public function handle($request, Closure $next,...$roles)
    {
        // $apiKey = $request->headers->has('api-key');
        // $keyApi = 'KKND4S5K4R4N8PL0SO^^**&&';
        // if($apiKey){
        //     if($apiKey == $keyApi)
        //     {
        //         return $next($request);
        //     }else{
        //         return response()->json([
        //           'status' => 'error',
        //           'result' => 'Api Key Not Invalid!',
        //         ], 400);
        //     }
        // }else{
        //     return response()->json([
        //           'status' => 'error',
        //           'result' => 'Api Key Is Required!',
        //         ], 400);
        // }
        return $next($request);
    }
}