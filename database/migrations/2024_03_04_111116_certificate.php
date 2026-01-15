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
        Schema::create('certificate', function (Blueprint $table) {
            $table->id('cert_id');
            $table->unsignedBigInteger('employee_id')->comment('Foreign Key');
            $table->unsignedBigInteger('cert_Type_id')->comment('Foreign Key');
            $table->string('cert_From', 255);
            $table->date('cert_Date_Issued');
            $table->string('cert_Rating', 10);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('employee_id')->references('employee_id')->on('employee');
            $table->foreign('cert_Type_id')->references('cert_type_id')->on('certificate_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificate', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('certificate');
    }
};
