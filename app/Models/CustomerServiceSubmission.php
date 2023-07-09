<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerServiceSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_service_id',
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

    public function customer_service()
    {
        return $this->hasOne(CustomerService::class, 'id', 'customer_service_id');
    }

    public function marketing_assignment()
    {
        return $this->hasOne(MarketingAssignment::class, 'id', 'source_id');
    }

}
