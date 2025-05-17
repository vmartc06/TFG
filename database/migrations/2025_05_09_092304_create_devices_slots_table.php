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
        Schema::create('devices_slots', function (Blueprint $table) {
            $table->id();
            $table->string('slotID', 255)->nullable();
            $table->string('subscriberID', 255)->nullable();
            $table->string('networkOperator', 255)->nullable();
            $table->string('networkOperatorName', 255)->nullable();
            $table->integer('simState')->default(0);
            $table->integer('phoneType')->default(0);
            $table->string('imei', 255)->nullable();
            $table->string('meid', 255)->nullable();

            $table->foreignId('device_id')->constrained('devices')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices_slots');
    }
};
