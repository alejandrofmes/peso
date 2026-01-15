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
        Schema::create('job_preference', function (Blueprint $table) {
            $table->id('job_preference_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->unsignedBigInteger('position_id')->comment('Foreign Key');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('employee_id')->on('employee');
            $table->foreign('position_id')->references('position_id')->on('job_positions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_preference', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('job_preference');
    }
};
