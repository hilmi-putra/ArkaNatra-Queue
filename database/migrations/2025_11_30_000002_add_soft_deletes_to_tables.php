<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add soft deletes to customer table
        Schema::table('table_customer', function (Blueprint $table) {
            if (!Schema::hasColumn('table_customer', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Add soft deletes to division table
        Schema::table('table_division', function (Blueprint $table) {
            if (!Schema::hasColumn('table_division', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Add soft deletes to work types table
        Schema::table('table_work_types', function (Blueprint $table) {
            if (!Schema::hasColumn('table_work_types', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Add soft deletes to indexing types table
        Schema::table('table_indexing_types', function (Blueprint $table) {
            if (!Schema::hasColumn('table_indexing_types', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Add soft deletes to access credentials table
        Schema::table('table_access_credentials', function (Blueprint $table) {
            if (!Schema::hasColumn('table_access_credentials', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Add soft deletes to work order indexing table
        Schema::table('table_work_order_indexing', function (Blueprint $table) {
            if (!Schema::hasColumn('table_work_order_indexing', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_customer', function (Blueprint $table) {
            if (Schema::hasColumn('table_customer', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('table_division', function (Blueprint $table) {
            if (Schema::hasColumn('table_division', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('table_work_types', function (Blueprint $table) {
            if (Schema::hasColumn('table_work_types', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('table_indexing_types', function (Blueprint $table) {
            if (Schema::hasColumn('table_indexing_types', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('table_access_credentials', function (Blueprint $table) {
            if (Schema::hasColumn('table_access_credentials', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('table_work_order_indexing', function (Blueprint $table) {
            if (Schema::hasColumn('table_work_order_indexing', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
