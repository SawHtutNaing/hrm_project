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
        Schema::create('fscampaign', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('campaign_start_date')->nullable();
            $table->dateTime('campaign_end_date')->nullable();
            $table->unsignedBigInteger('campaign_leader')->nullable();
            $table->json('campaign_member')->nullable();
            $table->string('business_location_id')->nullable();
            $table->enum('status', ['start', 'close', 'ready'])->default('ready');
            $table->unsignedBigInteger('start_by')->nullable();
            $table->unsignedBigInteger('end_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fscampaign');
    }
};
