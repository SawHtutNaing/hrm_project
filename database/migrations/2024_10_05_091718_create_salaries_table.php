<?php

use App\Models\EmployeeRole;
use App\Models\User;
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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->nullOnDelete();
            $table->foreignIdFor(EmployeeRole::class)->nullable()->nullOnDelete();
            $table->date('salary_date')->nullable();
            $table->string('basic_pay')->nullable();

            $table->string('overtime_bonus');

            $table->integer('deduction_amount')->nullable();

            $table->integer('deduction_tax')->nullable();
            $table->integer('net_salary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
