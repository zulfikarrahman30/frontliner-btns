<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'source_id',
        'marketing_id',
        'manager_id',
        'status'
    ];
}
