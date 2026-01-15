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
        Schema::create('industry_preference', function (Blueprint $table) {
            $table->id('industry_pref_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->unsignedBigInteger('industry_id')->comment('Foreign Key');
            $table->timestamps();
            $table->softDeletes();

            // Assuming you have an 'industry' table with an 'industry_id' column
            $table->foreign('employee_id')->references('employee_id')->on('employee');
            $table->foreign('industry_id')->references('industry_id')->on('job_industry');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_preference', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('industry_preference');
    }
};
