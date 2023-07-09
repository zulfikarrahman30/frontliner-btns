<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TellerSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'teller_id',
        'customer_id',
        'date_submit',
        'service',
        'original_account',
        'destination_account',
        'amount',
        'merchant_id',
        'allocation',
        'potential_category',
        'potential_description'
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function teller()
    {
        return $this->hasOne(Teller::class, 'id', 'teller_id');
    }

    public function marketing_assignment()
    {
        return $this->hasOne(MarketingAssignment::class, 'id', 'source_id');
    }
}
