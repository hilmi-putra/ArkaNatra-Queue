<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log activity with details
     */
    public static function log(
        string $activityType,
        string $modelType,
        mixed $modelId = null,
        string $description = null,
        array $oldValues = null,
        array $newValues = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => $activityType,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
        ]);
    }

    /**
     * Log model creation
     */
    public static function logCreated(string $modelType, mixed $modelId, array $data = []): ActivityLog
    {
        return self::log(
            'created',
            $modelType,
            $modelId,
            sprintf('%s has been created', $modelType),
            null,
            $data
        );
    }

    /**
     * Log model update with differences
     */
    public static function logUpdated(
        string $modelType,
        mixed $modelId,
        array $oldValues,
        array $newValues
    ): ActivityLog {
        $changes = [];
        foreach ($newValues as $key => $value) {
            if (isset($oldValues[$key]) && $oldValues[$key] !== $value) {
                $changes[] = "{$key}: '{$oldValues[$key]}' → '{$value}'";
            }
        }

        $description = sprintf('%s has been updated: %s', $modelType, implode(', ', $changes));

        return self::log(
            'updated',
            $modelType,
            $modelId,
            $description,
            $oldValues,
            $newValues
        );
    }

    /**
     * Log model deletion
     */
    public static function logDeleted(string $modelType, mixed $modelId, array $data = []): ActivityLog
    {
        return self::log(
            'deleted',
            $modelType,
            $modelId,
            sprintf('%s has been deleted', $modelType),
            $data,
            null
        );
    }

    /**
     * Log model restoration
     */
    public static function logRestored(string $modelType, mixed $modelId): ActivityLog
    {
        return self::log(
            'restored',
            $modelType,
            $modelId,
            sprintf('%s has been restored', $modelType),
            null,
            null
        );
    }

    /**
     * Log status change
     */
    public static function logStatusChanged(
        string $modelType,
        mixed $modelId,
        string $oldStatus,
        string $newStatus
    ): ActivityLog {
        return self::log(
            'status_changed',
            $modelType,
            $modelId,
            sprintf('Status changed from %s to %s', $oldStatus, $newStatus),
            ['status' => $oldStatus],
            ['status' => $newStatus]
        );
    }

    /**
     * Log user login
     */
    public static function logLogin(int $userId): ActivityLog
    {
        return ActivityLog::create([
            'user_id' => $userId,
            'activity_type' => 'login',
            'model_type' => 'User',
            'model_id' => $userId,
            'description' => 'User has logged in',
            'ip_address' => Request::ip(),
        ]);
    }

    /**
     * Log user logout
     */
    public static function logLogout(int $userId): ActivityLog
    {
        return ActivityLog::create([
            'user_id' => $userId,
            'activity_type' => 'logout',
            'model_type' => 'User',
            'model_id' => $userId,
            'description' => 'User has logged out',
            'ip_address' => Request::ip(),
        ]);
    }
}
