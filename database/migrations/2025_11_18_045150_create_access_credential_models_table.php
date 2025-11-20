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
        Schema::create('table_access_credentials', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')
                ->references('id')
                ->on('table_customer')
                ->onDelete('cascade');

            $table->enum('server', ['rumahweb', 'webhostingallinone', 'niaga', 'nohosting'])
                ->nullable();

            $table->text('note')->nullable();
            $table->boolean('status')->default(true);
            $table->date('expiration_date')->nullable();

            // ➕ Tambahan

            $table->string('access_web')->nullable();
            $table->string('username_web')->nullable();
            $table->string('password_web')->nullable();

            $table->string('akses_ojs')->nullable();
            $table->string('username_ojs')->nullable();
            $table->string('password_ojs')->nullable();

            $table->string('akses_cpanel')->nullable();
            $table->string('username_cpanel')->nullable();
            $table->string('password_cpanel')->nullable();

            $table->string('akses_webmail')->nullable();
            $table->string('username_webmail')->nullable();
            $table->string('password_webmail')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_credential_models');
    }
};
