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
        Schema::create('table_work_order_indexing', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('work_order_id');
            $table->index('work_order_id');
            $table->foreign('work_order_id')
                ->references('id')
                ->on('table_work_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('indexing_type_id');
            $table->index('indexing_type_id');
            $table->foreign('indexing_type_id')
                ->references('id')
                ->on('table_indexing_types')
                ->onDelete('cascade');

            $table->boolean('finished')->default(false);
            $table->index('finished');

            $table->timestamps();
            $table->softDeletes();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_indexing_models');
    }
};
