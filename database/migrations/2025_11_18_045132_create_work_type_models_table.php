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
        Schema::create('table_work_types', function (Blueprint $table) {
            $table->id();
            $table->string('work_type');
            $table->integer('regular_estimation_days');
            $table->integer('extra_days_per_quantity')->default(0);
            $table->integer('fast_track_estimation_days')->nullable();

            $table->unsignedBigInteger('division_id');
            $table->foreign('division_id')
                ->references('id')
                ->on('table_division')
                ->onDelete('cascade');
                
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_type_models');
    }
};
