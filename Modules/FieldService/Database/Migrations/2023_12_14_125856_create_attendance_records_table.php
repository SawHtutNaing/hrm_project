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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('location_name');
            $table->string('gps_location');
            $table->enum('status', ['checkIn', 'checkOut']);
            $table->json('photo')->nullable();
            $table->dateTime('checkin_datetime')->nullable();
            $table->dateTime('checkout_datetime')->nullable();
            $table->decimal('hours_worked', 22, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
