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
        Schema::create('eligibility', function (Blueprint $table) {
            $table->id('eligibility_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->unsignedBigInteger('eligibility_Type')->comment('Foreign Key');
            $table->date('eligibility_Date');
            $table->timestamps();
            $table->softDeletes();

            // Define foreign key constraints
            $table->foreign('employee_id')->references('employee_id')->on('employee');
            $table->foreign('eligibility_Type')->references('eligibility_type_id')->on('eligibility_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eligibility', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('eligibility');
    }
};
