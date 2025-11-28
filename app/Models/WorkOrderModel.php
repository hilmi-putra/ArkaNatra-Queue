<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkOrderModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'table_work_orders';

    protected $fillable = [
        'status', 'send_access', 'ref_id', 'antrian_ke', 'customer_id', 
        'division_id', 'work_type_id', 'domain', 'quantity',
        'description', 'file_mou', 'file_work_form',
        'additional_file', 'fast_track', 'date_received',
        'date_queue', 'revision_count',
        'date_completed', 'estimasi_date', 'sales_id', 'production_id', 'date_revision', 'date_migration'
    ];

    protected $dates = [
        'estimasi_date',
        'date_received',
        'date_queue',
        'date_completed',
        'date_revision',
        'date_migration',   
        'created_at',
        'updated_at',
    ];

    /**
     * Scope untuk mendapatkan work orders berdasarkan production_id
     */
    public function scopeByProduction($query, $productionId)
    {
        return $query->where('production_id', $productionId);
    }

    /**
     * Scope untuk work orders dalam antrian
     */
    public function scopeInQueue($query)
    {
        return $query->where('status', 'queue');
    }

    /**
     * Mendapatkan jumlah antrian untuk production_id tertentu
     */
    public static function getQueueCount($productionId)
    {
        return self::where('status', 'queue')
            ->where('production_id', $productionId)
            ->count();
    }

    /**
     * Mendapatkan daftar antrian untuk production_id tertentu
     */
    public static function getQueueList($productionId)
    {
        return self::where('status', 'queue')
            ->where('production_id', $productionId)
            ->orderBy('antrian_ke', 'asc')
            ->get();
    }

    /**
     * Format a date to Indonesian format (Day, dd Month YYYY).
     */
    private function formatIndonesianDate($date)
    {
        if (is_null($date)) {
            return null;
        }
        return Carbon::parse($date)->translatedFormat('l, d F Y');
    }

    // ... (getter methods yang sudah ada tetap dipertahankan)

    public function getDateRevisionAttribute($value)
    {
        return $this->formatIndonesianDate($value);
    }

    public function getDateMigrationAttribute($value)
    {
        return $this->formatIndonesianDate($value);
    }

    public function getEstimasiDateAttribute($value)
    {
        return $this->formatIndonesianDate($value);
    }
    
    public function getDateReceivedAttribute($value)
    {
        return $this->formatIndonesianDate($value);
    }

    public function getDateQueueAttribute($value)
    {
        return $this->formatIndonesianDate($value);
    }

    public function getDateCompletedAttribute($value)
    {
        return $this->formatIndonesianDate($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return $this->formatIndonesianDate($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->formatIndonesianDate($value);
    }

    // ... (relationship methods yang sudah ada)

    public function customer() 
    { 
        return $this->belongsTo(CustomerModel::class); 
    }
    
    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }

    public function salesUser()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function productionUser()
    {
        return $this->belongsTo(User::class, 'production_id');
    }
    
    public function division() 
    { 
        return $this->belongsTo(DivisionModel::class); 
    }
    
    public function workType() 
    { 
        return $this->belongsTo(WorkTypeModel::class); 
    }

    public function accessCredentials()
    {
        return $this->hasManyThrough(
            AccessCredentialModel::class,
            CustomerModel::class,
            'id',
            'customer_id',
            'customer_id',
            'id'
        );
    }

    public function getAccessCredentialsAttribute()
    {
        return $this->customer->accessCredentials ?? collect();
    }

    public function accessCredential()
    {
        return $this->hasOne(AccessCredentialModel::class, 'customer_id', 'customer_id');
    }       
}