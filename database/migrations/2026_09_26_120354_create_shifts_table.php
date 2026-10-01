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
        Schema::create('shifts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('position');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('role_or_notes')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
