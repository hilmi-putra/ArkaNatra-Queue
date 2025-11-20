<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndexingTypeModel extends Model
{
    use SoftDeletes;

    protected $table = 'table_indexing_types';

    protected $fillable = ['indexing_name', 'description'];

    public function workOrderIndexing()
    {
        return $this->hasMany(WorkOrderIndexingModel::class, 'indexing_type_id');
    }
}
