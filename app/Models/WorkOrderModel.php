<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrderModel extends Model
{
    use SoftDeletes;

    protected $table = 'table_work_orders';

    protected $fillable = [
        'status', 'ref_id', 'customer_id', 
        'division_id', 'work_type_id', 'domain', 'quantity',
        'description', 'file_mou', 'file_work_form',
        'additional_file', 'fast_track', 'date_received',
        'date_queue', 'revision_count',
        'date_completed', 'estimasi_date', 'sales_id', 'production_id'
    ];

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
        // Relasi melalui customer, bukan langsung
        return $this->hasManyThrough(
            AccessCredentialModel::class,
            CustomerModel::class,
            'id', // Foreign key on CustomerModel
            'customer_id', // Foreign key on AccessCredentialModel
            'customer_id', // Local key on WorkOrderModel
            'id' // Local key on CustomerModel
        );
    }

    // Atau alternatif: ambil access credentials melalui customer
    public function getAccessCredentialsAttribute()
    {
        return $this->customer->accessCredentials ?? collect();
    }

     /**
     * Accessor untuk estimasi yang dihitung otomatis
     */
    public function getCalculatedEstimationAttribute()
    {
        return $this->calculateEstimation();
    }

    /**
     * Accessor untuk estimasi dalam hari
     */
    public function getCalculatedEstimationDaysAttribute()
    {
        return $this->calculateEstimationDays();
    }

    /**
     * Hitung estimasi dalam hari
     */
    public function calculateEstimationDays()
    {
        if (!$this->workType) {
            return 0;
        }

        $workType = $this->workType;
        $quantity = $this->quantity ?? 1;
        
        $baseEstimation = $this->fast_track 
            ? $workType->fast_track_estimation_days 
            : $workType->regular_estimation_days;

        $extraDays = ($quantity - 1) * ($workType->extra_days_per_quantity ?? 0);

        return $baseEstimation + $extraDays;
    }

    /**
     * Hitung tanggal estimasi
     */
    public function calculateEstimation()
    {
        if ($this->status !== 'queue' || !$this->date_queue) {
            return $this->estimasi_date;
        }

        $estimationDays = $this->calculateEstimationDays();
        
        if ($estimationDays <= 0) {
            return $this->estimasi_date;
        }

        try {
            $queueDate = \Carbon\Carbon::parse($this->date_queue);
            $estimatedDate = $queueDate->addDays($estimationDays);
            
            return $estimatedDate->format('Y-m-d');
        } catch (\Exception $e) {
            return $this->estimasi_date;
        }
    }
}