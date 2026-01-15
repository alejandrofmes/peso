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
        Schema::create('company', function (Blueprint $table) {
            $table->id('company_id');
            $table->unsignedBigInteger('user_id')->comment('Foreign Key');
            $table->string('business_Name', 255);
            $table->string('trade_Name', 255);
            $table->string('company_TIN', 15)->nullable();
            $table->tinyInteger('company_Type');
            $table->tinyInteger('employer_Type');
            $table->tinyInteger('employer_Type_Desc');
            $table->tinyInteger('company_Total_workforce');
            $table->string('company_Address', 255);
            $table->unsignedBigInteger('barangay_id')->comment('Foreign Key');
            $table->string('contact_Person', 255);
            $table->string('contact_Person_position', 255);
            $table->string('company_Pnum', 15);
            $table->string('company_Tnum', 15)->nullable();
            $table->string('company_Fnum', 20)->nullable();
            $table->string('company_Email', 255);
            $table->string('company_Status', 15);
            $table->string('company_img', 255);
            $table->text('company_Desc')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');;
            $table->foreign('barangay_id')->references('barangay_id')->on('barangay');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('company');
    }
};
