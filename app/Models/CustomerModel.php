<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerModel extends Model
{
    use SoftDeletes;

    protected $table = 'table_customer';

    protected $fillable = [
        'token', 'name', 'address', 'phone', 'email'
    ];
    public function workOrders()
    {
        return $this->hasMany(WorkOrderModel::class, 'customer_id');
    }

    public function accessCredentials()
    {
        return $this->hasMany(AccessCredentialModel::class, 'customer_id');
    }
}
