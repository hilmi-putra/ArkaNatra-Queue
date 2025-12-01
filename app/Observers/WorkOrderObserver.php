<?php

namespace App\Observers;

use App\Models\WorkOrderModel;
use App\Models\WorkTypeModel;
use App\Services\ActivityLogger;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class WorkOrderObserver
{
    /**
     * Daftar hari libur nasional Indonesia (contoh - bisa disimpan di database/config)
     * Format: 'Y-m-d'
     */
    private function getHolidays($year = null)
    {
        $year = $year ?? Carbon::now()->year;
        
        return Cache::remember("indonesia_holidays_{$year}", 3600, function () use ($year) {
            // Contoh hari libur nasional Indonesia 2024
            $holidays = [
                $year . '-01-01', // Tahun Baru Masehi
                $year . '-03-11', // Isra Mikraj
                $year . '-03-29', // Jumat Agung
                $year . '-04-10', // Hari Raya Idul Fitri 1445 H
                $year . '-04-11', // Hari Raya Idul Fitri 1445 H
                $year . '-05-01', // Hari Buruh Internasional
                $year . '-05-09', // Kenaikan Isa Almasih
                $year . '-05-23', // Hari Raya Waisak
                $year . '-06-01', // Hari Lahir Pancasila
                $year . '-06-17', // Hari Raya Idul Adha 1445 H
                $year . '-07-07', // Tahun Baru Islam 1446 H
                $year . '-08-17', // Hari Kemerdekaan RI
                $year . '-09-16', // Maulid Nabi Muhammad SAW
                $year . '-12-25', // Hari Raya Natal
                $year . '-12-26', // Cuti Bersama Natal
            ];
            
            return $holidays;
        });
    }

    /**
     * Cek apakah tanggal adalah hari kerja (Senin-Jumat dan bukan hari libur)
     */
    private function isWorkingDay(Carbon $date)
    {
        // Cek weekend (Sabtu = 6, Minggu = 0)
        if ($date->dayOfWeek === Carbon::SATURDAY || $date->dayOfWeek === Carbon::SUNDAY) {
            return false;
        }

        // Cek hari libur nasional
        $holidays = $this->getHolidays($date->year);
        return !in_array($date->format('Y-m-d'), $holidays);
    }

    /**
     * Menambahkan hari kerja ke tanggal tertentu
     */
    private function addWorkingDays(Carbon $startDate, $workingDaysToAdd)
    {
        $currentDate = $startDate->copy();
        $daysAdded = 0;

        while ($daysAdded < $workingDaysToAdd) {
            $currentDate->addDay();
            
            if ($this->isWorkingDay($currentDate)) {
                $daysAdded++;
            }
        }

        return $currentDate;
    }

    /**
     * Mendapatkan nomor antrian berikutnya untuk production_id tertentu
     */
    private function getNextQueueNumber($productionId)
    {
        $maxAntrian = WorkOrderModel::where('status', 'queue')
            ->where('production_id', $productionId)
            ->max('antrian_ke');
            
        return ($maxAntrian ?? 0) + 1;
    }

    /**
     * Handle the WorkOrderModel "updating" event.
     *
     * @param  \App\Models\WorkOrderModel  $workOrderModel
     * @return void
     */
    public function updating(WorkOrderModel $workOrderModel): void
    {
        // Check if the 'status' field is being changed
        if ($workOrderModel->isDirty('status')) {
            $originalStatus = $workOrderModel->getOriginal('status');
            $newStatus = $workOrderModel->status;

            // Log status change
            if ($originalStatus !== $newStatus) {
                ActivityLogger::logStatusChanged(
                    'WorkOrderModel',
                    $workOrderModel->id,
                    $originalStatus,
                    $newStatus
                );
            }

            // This logic triggers when a work order moves INTO the queue
            if ($newStatus === 'queue' && $originalStatus !== 'queue') {
                // 1. Set queue date using a variable to avoid accessor issues
                $queueDate = Carbon::now('Asia/Jakarta');
                $workOrderModel->date_queue = $queueDate;

                // 2. Set queue number ('antrian_ke') berdasarkan production_id
                $workOrderModel->antrian_ke = $this->getNextQueueNumber($workOrderModel->production_id);

                // 3. Calculate and set estimation date based on working days
                $workType = WorkTypeModel::find($workOrderModel->work_type_id);

                if ($workType) {
                    $baseEstimation = $workOrderModel->fast_track
                        ? $workType->fast_track_estimation_days
                        : $workType->regular_estimation_days;

                    $extraDays = ($workOrderModel->quantity - 1) * ($workType->extra_days_per_quantity ?? 0);

                    $totalEstimationDays = $baseEstimation + $extraDays;

                    // Calculate estimation date based on working days only
                    $workOrderModel->estimasi_date = $this->addWorkingDays(
                        $queueDate->copy(), 
                        $totalEstimationDays
                    );
                }

            // This logic triggers when a work order moves OUT of the queue
            } elseif ($originalStatus === 'queue' && $newStatus !== 'queue') {
                $oldQueueNumber = $workOrderModel->getOriginal('antrian_ke');
                $productionId = $workOrderModel->getOriginal('production_id');

                // If it was in the queue, decrement the queue number of all subsequent items in the same production
                if ($oldQueueNumber && $productionId) {
                    WorkOrderModel::where('status', 'queue')
                                  ->where('production_id', $productionId)
                                  ->where('antrian_ke', '>', $oldQueueNumber)
                                  ->decrement('antrian_ke');
                }

                // Remove the queue number from the work order that is no longer in the queue
                $workOrderModel->antrian_ke = null;
            }
        }

        // Handle perubahan production_id untuk item yang sedang dalam antrian
        if ($workOrderModel->isDirty('production_id') && $workOrderModel->status === 'queue') {
            $oldProductionId = $workOrderModel->getOriginal('production_id');
            $newProductionId = $workOrderModel->production_id;
            $oldQueueNumber = $workOrderModel->getOriginal('antrian_ke');

            // Hapus dari antrian production lama
            if ($oldProductionId && $oldQueueNumber) {
                WorkOrderModel::where('status', 'queue')
                              ->where('production_id', $oldProductionId)
                              ->where('antrian_ke', '>', $oldQueueNumber)
                              ->decrement('antrian_ke');
            }

            // Tambahkan ke antrian production baru
            $workOrderModel->antrian_ke = $this->getNextQueueNumber($newProductionId);
        }

        // Log other updates
        $oldValues = $workOrderModel->getOriginal();
        $newValues = $workOrderModel->getAttributes();
        $changes = [];
        
        foreach ($newValues as $key => $value) {
            if ($key !== 'status' && isset($oldValues[$key]) && $oldValues[$key] !== $value) {
                $changes[$key] = [
                    'old' => $oldValues[$key],
                    'new' => $value
                ];
            }
        }

        if (!empty($changes)) {
            ActivityLogger::logUpdated(
                'WorkOrderModel',
                $workOrderModel->id,
                $oldValues,
                $newValues
            );
        }
    }

    /**
     * Handle the WorkOrderModel "created" event.
     * Untuk menangani kasus ketika work order langsung dibuat dengan status queue
     */
    public function created(WorkOrderModel $workOrderModel): void
    {
        // Log activity
        ActivityLogger::logCreated(
            'WorkOrderModel',
            $workOrderModel->id,
            $workOrderModel->toArray()
        );

        if ($workOrderModel->status === 'queue') {
            $workOrderModel->antrian_ke = $this->getNextQueueNumber($workOrderModel->production_id);
            $workOrderModel->saveQuietly(); // Gunakan saveQuietly untuk menghindari loop observer
        }
    }

    /**
     * Handle the WorkOrderModel "deleted" event (soft delete).
     */
    public function deleted(WorkOrderModel $workOrderModel): void
    {
        ActivityLogger::logDeleted(
            'WorkOrderModel',
            $workOrderModel->id,
            $workOrderModel->getAttributes()
        );
    }

    /**
     * Handle the WorkOrderModel "restored" event.
     */
    public function restored(WorkOrderModel $workOrderModel): void
    {
        ActivityLogger::logRestored(
            'WorkOrderModel',
            $workOrderModel->id
        );
    }

    /**
     * Handle the WorkOrderModel "force deleted" event.
     */
    public function forceDeleted(WorkOrderModel $workOrderModel): void
    {
        ActivityLogger::log(
            'deleted',
            'WorkOrderModel',
            $workOrderModel->id,
            'Work Order has been permanently deleted',
            $workOrderModel->getAttributes(),
            null
        );
    }
}