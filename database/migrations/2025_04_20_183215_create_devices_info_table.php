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
        Schema::create('devices_info', function (Blueprint $table) {
            $table->id();
            $table->string('board_name', 255)->nullable();
            $table->string('bootloader', 255)->nullable();
            $table->string('brand', 255)->nullable();
            $table->string('device', 255)->nullable();

            $table->string('android_build_sdk', 255)->nullable();
            $table->longText('android_build_display')->nullable();
            $table->longText('android_build_fingerprint')->nullable();
            $table->unsignedBigInteger('android_build_timestamp_ms')->nullable();
            $table->string('android_build_type', 255)->nullable();
            $table->string('android_build_user', 255)->nullable();
            $table->string('android_build_tags', 255)->nullable();

            $table->string('hardware_name', 255)->nullable();
            $table->string('host', 255)->nullable();
            $table->string('device_identifier', 255)->nullable();
            $table->string('manufacturer', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('odm_sku', 255)->nullable();
            $table->string('product_name', 255)->nullable();
            $table->string('serial', 255)->nullable();
            $table->string('sku', 255)->nullable();
            $table->string('soc_manufacturer', 255)->nullable();
            $table->string('soc_model', 255)->nullable();
            $table->json('supported_32_bit_abis')->nullable();
            $table->json('supported_64_bit_abis')->nullable();
            $table->json('supported_abis')->nullable();

            $table->foreignId('device_id')->unique()
                ->constrained('devices')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices_info');
    }
};
