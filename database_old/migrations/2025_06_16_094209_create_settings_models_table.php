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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('logo')->nullable();         // Store path to logo file
            $table->string('favicon')->nullable();      // Store path to favicon file
            $table->string('contact_email')->nullable();
            $table->boolean('maintenance_mode')->default(false);
            // SMTP settings
            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable(); // You may want to encrypt this
            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
            // API keys
            $table->text('connecteam_api_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
