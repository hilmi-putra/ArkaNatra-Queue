<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'activity_type',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who performed the activity
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Filter by activity type
     */
    public function scopeByActivityType($query, $activityType)
    {
        return $query->where('activity_type', $activityType);
    }

    /**
     * Scope: Filter by model type
     */
    public function scopeByModelType($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope: Filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope: Latest first
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get human-readable activity type
     */
    public function getActivityTypeLabel()
    {
        $labels = [
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'restored' => 'Restored',
            'login' => 'Login',
            'logout' => 'Logout',
            'status_changed' => 'Status Changed',
        ];

        return $labels[$this->activity_type] ?? ucfirst($this->activity_type);
    }

    /**
     * Get human-readable model type
     */
    public function getModelTypeLabel()
    {
        $labels = [
            'WorkOrderModel' => 'Work Order',
            'CustomerModel' => 'Customer',
            'UserModel' => 'User',
            'DivisionModel' => 'Division',
            'WorkTypeModel' => 'Work Type',
            'AccessCredentialModel' => 'Access Credential',
            'IndexingTypeModel' => 'Indexing Type',
        ];

        return $labels[$this->model_type] ?? str_replace('Model', '', $this->model_type);
    }

    /**
     * Get CSS badge color based on activity type
     */
    public function getActivityTypeBadgeColor()
    {
        $colors = [
            'created' => 'bg-green-500',
            'updated' => 'bg-blue-500',
            'deleted' => 'bg-red-500',
            'restored' => 'bg-purple-500',
            'login' => 'bg-indigo-500',
            'logout' => 'bg-gray-500',
            'status_changed' => 'bg-yellow-500',
        ];

        return $colors[$this->activity_type] ?? 'bg-gray-500';
    }
}
