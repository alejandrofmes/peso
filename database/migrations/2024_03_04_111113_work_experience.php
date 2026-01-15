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
        Schema::create('work_experience', function (Blueprint $table) {
            $table->id('workexp_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->string('work_Name', 255);
            $table->text('work_Address');
            $table->unsignedBigInteger('position_id')->comment('Foreign Key');
            $table->date('work_Start');
            $table->date('work_End')->nullable();
            $table->string('work_Status', 255);
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
        Schema::table('work_experience', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('work_experience');
    }
};
