<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_log';
    

    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'type',
        'ip'
    ];  

    public static function log($type,$name,$content,$ip){
        $userlog = UserLog::create([
            'name' => $name,
            'type' => $type,
            'ip'   => $ip,
            'content' => $content
        ]);

    }
}
