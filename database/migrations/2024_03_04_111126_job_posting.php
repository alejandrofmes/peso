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
        Schema::create('job_posting', function (Blueprint $table) {
            $table->id('job_id');
            $table->unsignedBigInteger('company_id')->comment('Foreign Key');
            $table->unsignedBigInteger('industry_id')->comment('Foreign Key');
            $table->string('job_Title', 255);
            $table->text('job_Description')->nullable();
            $table->text('job_Qualifications')->nullable();
            $table->text('job_Remarks')->nullable();
            $table->decimal('job_MinWage', 10, 2)->nullable();
            $table->decimal('job_MaxWage', 10, 2)->nullable();
            $table->tinyInteger('job_Type');
            $table->tinyInteger('job_Edu')->nullable();
            $table->tinyInteger('job_Disability')->nullable();
            $table->integer('job_Slots')->nullable();
            $table->string('job_Address', 255);
            $table->unsignedBigInteger('barangay_id')->comment('Foreign Key');
            $table->date('job_Duration');
            $table->string('job_Status', 15);
            $table->unsignedBigInteger('peso_accounts_id')->nullable()->comment('Foreign Key');
            $table->unsignedBigInteger('peso_id')->comment('Foreign Key');
            $table->text('peso_Remarks')->nullable();
            $table->datetime('responded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('company_id')->on('company');
            $table->foreign('industry_id')->references('industry_id')->on('job_industry');
            $table->foreign('barangay_id')->references('barangay_id')->on('barangay');
            $table->foreign('peso_id')->references('peso_id')->on('peso');
            $table->foreign('peso_accounts_id')->references('peso_accounts_id')->on('peso_accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_posting', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('job_posting');
    }
};
