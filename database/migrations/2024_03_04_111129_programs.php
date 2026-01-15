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
        Schema::create('programs', function (Blueprint $table) {
            $table->id('program_id');
            $table->string('program_Title', 255);
            $table->string('program_Modality', 20);
            $table->string('program_Type', 20);
            $table->string('program_Host', 255);
            $table->integer('program_Slots')->nullable();
            $table->unsignedBigInteger('industry_id')->comment('Foreign Key');
            $table->dateTime('program_Datetime')->nullable();
            $table->dateTime('program_Deadline');
            $table->text('program_Location');
            $table->text('program_Description')->nullable();
            $table->text('program_Qualification')->nullable();
            $table->text('program_Remarks')->nullable();
            $table->string('program_Status', 15);
            $table->string('program_pubmat', 255)->nullable();
            $table->unsignedBigInteger('peso_id')->comment('Foreign Key');
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes();

            $table->foreign('industry_id')->references('industry_id')->on('job_industry');
            $table->foreign('peso_id')->references('peso_id')->on('peso');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('programs');
    }
};
