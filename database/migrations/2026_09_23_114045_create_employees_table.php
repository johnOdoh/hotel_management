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
        Schema::create('employees', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('address');
            $table->string('hometown');
            $table->string('lga');
            $table->string('state');
            $table->string('cv')->nullable();
            $table->string('id_document')->nullable();
            $table->json('emergency_contact_details');
            //employment details
            $table->string('position');
            $table->string('employment_status');
            $table->timestamp('employment_date');
            $table->decimal('salary', 10, 2);
            $table->json('account_details')->nullable();
            //termination details
            $table->timestamp('termination_date')->nullable();
            $table->string('termination_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};