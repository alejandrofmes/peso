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
        Schema::create('job_industry', function (Blueprint $table) {
            $table->id('industry_id');
            $table->string('industry_Title', 255);
            $table->string('industry_Code', 10);
            $table->tinyInteger('industry_Status')->default(1)->comment('1 - active, 2 - inactive');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_industry', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('job_industry');
    }
};
