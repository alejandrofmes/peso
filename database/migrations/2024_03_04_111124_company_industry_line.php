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
        Schema::create('company_industry_line', function (Blueprint $table) {
            $table->id('company_industry_line_id');
            $table->unsignedBigInteger('company_id')->comment('Foreign Key');
            $table->unsignedBigInteger('industry_id')->comment('Foreign Key');
            $table->timestamps();
            $table->softDeletes();

            // Define foreign key constraints
            $table->foreign('company_id')->references('company_id')->on('company');
            $table->foreign('industry_id')->references('industry_id')->on('job_industry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_industry_line', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('company_industry_line');
    }
};
