<?php

namespace App\Observers;

use App\Models\WorkOrderModel;
use App\Services\ActivityLogger;

class WorkOrderObserverNew
{
    /**
     * Handle the WorkOrderModel "created" event.
     */
    public function created(WorkOrderModel $workOrder): void
    {
        ActivityLogger::logCreated(
            'WorkOrderModel',
            $workOrder->id,
            $workOrder->toArray()
        );
    }

    /**
     * Handle the WorkOrderModel "updated" event.
     */
    public function updated(WorkOrderModel $workOrder): void
    {
        $oldValues = $workOrder->getOriginal();
        $newValues = $workOrder->getAttributes();

        // Only log if there are actual changes
        $changes = [];
        foreach ($newValues as $key => $value) {
            if (isset($oldValues[$key]) && $oldValues[$key] !== $value) {
                $changes[$key] = [
                    'old' => $oldValues[$key],
                    'new' => $value
                ];
            }
        }

        if (!empty($changes)) {
            ActivityLogger::logUpdated(
                'WorkOrderModel',
                $workOrder->id,
                $oldValues,
                $newValues
            );
        }
    }

    /**
     * Handle the WorkOrderModel "deleted" event.
     */
    public function deleted(WorkOrderModel $workOrder): void
    {
        ActivityLogger::logDeleted(
            'WorkOrderModel',
            $workOrder->id,
            $workOrder->getAttributes()
        );
    }

    /**
     * Handle the WorkOrderModel "restored" event.
     */
    public function restored(WorkOrderModel $workOrder): void
    {
        ActivityLogger::logRestored(
            'WorkOrderModel',
            $workOrder->id
        );
    }

    /**
     * Handle the WorkOrderModel "force deleted" event.
     */
    public function forceDeleted(WorkOrderModel $workOrder): void
    {
        ActivityLogger::log(
            'deleted',
            'WorkOrderModel',
            $workOrder->id,
            'Work Order has been permanently deleted',
            $workOrder->getAttributes(),
            null
        );
    }
}
