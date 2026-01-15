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
        Schema::create('program_reg', function (Blueprint $table) {
            $table->id('program_reg_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->unsignedBigInteger('program_id')->comment('Foreign Key');
            $table->string('program_reg_Status', 15);
            $table->datetime('responded_at')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes();

            $table->foreign('program_id')->references('program_id')->on('programs');
            $table->foreign('employee_id')->references('employee_id')->on('employee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_reg', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('program_reg');
    }
};
