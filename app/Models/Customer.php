<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date_birth',
        'address',
        'phone',
        'whatsapp',
        'email',
        'profession',
        'job_status',
        'company_name',
        'position',
        'income_per_month',
        'category',
        'type'

    ];
}
