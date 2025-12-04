<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('table_work_orders', function (Blueprint $table) {
        $table->id();

        $table->enum('status', [
            'validate', 'queue', 'pending', 'progress',
            'revision', 'migration', 'finish', 'cancelled'
        ])->default('validate');
        // Index frequently filtered column
        $table->index('status');

        $table->boolean('send_access')->default(false);

        $table->string('ref_id')->nullable();
        $table->index('ref_id');
        $table->integer('antrian_ke')->nullable();

        // FK: customer_id
        $table->unsignedBigInteger('customer_id');
        $table->index('customer_id');
        $table->foreign('customer_id')
            ->references('id')
            ->on('table_customer')
            ->onDelete('cascade');

        // FK: sales_id (User Role: Sales)
        $table->unsignedBigInteger('sales_id')->nullable();
        $table->index('sales_id');
        $table->foreign('sales_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

        // FK: production_id (User Role: Production)
        $table->unsignedBigInteger('production_id')->nullable();
        $table->index('production_id');
        $table->foreign('production_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

        // FK: division_id
        $table->unsignedBigInteger('division_id');
        $table->index('division_id');
        $table->foreign('division_id')
            ->references('id')
            ->on('table_division')
            ->onDelete('cascade');

        // FK: work_type_id
        $table->unsignedBigInteger('work_type_id');
        $table->index('work_type_id');
        $table->foreign('work_type_id')
            ->references('id')
            ->on('table_work_types')
            ->onDelete('cascade');

        $table->string('domain')->nullable();
        $table->integer('quantity')->default(1);
        $table->text('description')->nullable();

        $table->string('file_mou')->nullable();
        $table->string('file_work_form')->nullable();
        $table->string('additional_file')->nullable();

        $table->boolean('fast_track')->default(false);

        $table->date('date_received')->nullable();
        $table->date('date_queue')->nullable();
        $table->date('estimasi_date')->nullable();
        $table->date('date_revision')->nullable();
        $table->date('date_migration')->nullable();
        $table->integer('revision_count')->default(0);
        $table->date('date_completed')->nullable();
        $table->date('date_cancelled')->nullable();

        $table->timestamps();
        $table->softDeletes();
    });

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_models');
    }
};
