<?php

use App\Models\Department;
use App\Models\LeaveType;
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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->nullOnDelete();
            $table->foreignIdFor(LeaveType::class)->nullable()->nullOnDelete();
            $table->foreignIdFor(Department::class)->constrained('departments');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->integer('qty')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
