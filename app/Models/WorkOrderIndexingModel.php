<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrderIndexingModel extends Model
{
    use SoftDeletes;

    protected $table = 'table_work_order_indexing';

    protected $fillable = [
        'work_order_id', 'indexing_type_id', 'finished'
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrderModel::class, 'work_order_id');
    }

    public function indexingType()
    {
        return $this->belongsTo(IndexingTypeModel::class, 'indexing_type_id');
    }
}
