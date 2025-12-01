<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DivisionModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'table_division';

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_divisi');
    }

    public function workTypes()
    {
        return $this->hasMany(WorkTypeModel::class, 'division_id');
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrderModel::class, 'division_id');
    }
}
