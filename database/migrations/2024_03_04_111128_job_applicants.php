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
        Schema::create('job_applicants', function (Blueprint $table) {
            $table->id('applicant_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->unsignedBigInteger('job_id')->comment('Foreign Key');
            $table->tinyInteger('applicant_Resume');
            $table->string('applicant_Status', 15);
            $table->string('peso_Status', 15);
            $table->text('company_Remarks')->nullable();
            $table->text('peso_Remarks')->nullable();
            $table->string('peso_Letter', 255)->nullable();
            $table->tinyInteger('applicant_Notif')->default(2);
            $table->unsignedBigInteger('peso_accounts_id')->nullable()->comment('Foreign Key');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('employee_id')->on('employee');
            $table->foreign('job_id')->references('job_id')->on('job_posting');
            $table->foreign('peso_accounts_id')->references('peso_accounts_id')->on('peso_accounts');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applicants', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('job_applicants');
    }
};
