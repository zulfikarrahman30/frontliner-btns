<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingAssignmentActivities extends Model
{
    use HasFactory;

    protected $fillable = [
        'assigment_id',
        'tittle',
        'date_submit',
        'note',
        'attachment',
        'status'
    ];
}
