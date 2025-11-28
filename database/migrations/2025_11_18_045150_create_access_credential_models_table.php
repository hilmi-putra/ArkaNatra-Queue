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
            // Ubah tipe data status dari boolean ke enum
            $table->enum('status', ['active', 'inactive', 'error', 'suspended', 'expired'])->default('active');
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

            $table->boolean('send_access')->default(false);
            $table->boolean('web')->default(false);
            $table->boolean('ojs')->default(false);
            $table->boolean('cpanel')->default(false);
            $table->boolean('webmail')->default(false);

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
