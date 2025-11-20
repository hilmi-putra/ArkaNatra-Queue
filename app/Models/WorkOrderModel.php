<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrderModel extends Model
{
    use SoftDeletes;

    protected $table = 'table_work_orders';

    protected $fillable = [
        'status', 'ref_id', 'customer_id', 'user_id',
        'division_id', 'work_type_id', 'domain', 'quantity',
        'description', 'file_mou', 'file_work_form',
        'additional_file', 'fast_track', 'date_received',
        'date_queue', 'date_revision', 'revision_count',
        'date_completed'
    ];

    public function customer() { return $this->belongsTo(CustomerModel::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function division() { return $this->belongsTo(DivisionModel::class); }
    public function workType() { return $this->belongsTo(WorkTypeModel::class); }

    public function indexing()
    {
        return $this->hasMany(WorkOrderIndexingModel::class, 'work_order_id');
    }
}
