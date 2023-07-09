<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Illuminate\Support\Facades\Hash;
//use App\Models\Admin;
class User extends Authenticatable
{
    protected $fillable = [
        'role',
        'name',
        'email',
        'password'
    ];

    public function getPhotoBasedRole($role,$id)
    {
        $roles = [
            'admin'=>'App\Models\Admin',
            'customer_service'=>'App\Models\CustomerService',
            'financing_service'=>'App\Models\FinancingService',
            'teller'=>'App\Models\Teller',
            'manager'=>'App\Models\Manager',
            'marketing'=>'App\Models\Marketing'
        ];
        $model = $roles[$role]::where('user_id',$id)->select('photo')->first();
        $photo = '';
        if($model)
        {
            $photo = $model->photo;
        }
        return $photo;
    }

}
