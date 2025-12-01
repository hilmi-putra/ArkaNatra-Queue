<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkTypeModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'table_work_types';

    protected $fillable = [
        'work_type',
        'regular_estimation_days',
        'extra_days_per_quantity',
        'fast_track_estimation_days',
        'division_id'
    ];

    public function division()
    {
        return $this->belongsTo(DivisionModel::class, 'division_id');
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrderModel::class, 'work_type_id');
    }
}
