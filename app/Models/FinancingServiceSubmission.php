<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancingServiceSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'financing_service_id',
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

    public function financing_service()
    {
        return $this->hasOne(FinancingService::class, 'id', 'financing_service_id');
    }

    public function marketing_assignment()
    {
        return $this->hasOne(MarketingAssignment::class, 'id', 'source_id');
    }
}
