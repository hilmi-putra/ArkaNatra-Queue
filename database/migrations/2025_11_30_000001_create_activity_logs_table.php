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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // User who performed the action
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->index('user_id');

            // Activity type: created, updated, deleted, restored, login, logout, status_changed
            $table->string('activity_type');
            $table->index('activity_type');

            // Model information
            $table->string('model_type');
            $table->unsignedBigInteger('model_id')->nullable();
            $table->index(['model_type', 'model_id']);

            // Description of the activity
            $table->text('description')->nullable();

            // Old and new values (JSON)
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // IP address for security tracking
            $table->string('ip_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
