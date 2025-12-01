<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndexingTypeModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'table_indexing_types';

    protected $fillable = ['indexing_name', 'description'];

    public function workOrderIndexing()
    {
        return $this->hasMany(WorkOrderIndexingModel::class, 'indexing_type_id');
    }
}
