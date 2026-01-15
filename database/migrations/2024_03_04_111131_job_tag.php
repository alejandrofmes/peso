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
        Schema::create('job_tags', function (Blueprint $table) {
            $table->id('job_tags_id');
            $table->unsignedBigInteger('job_id')->comment('Foreign Key');
            $table->unsignedBigInteger('position_id')->comment('Foreign Key');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('job_id')->references('job_id')->on('job_posting');
            $table->foreign('position_id')->references('position_id')->on('job_positions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_tag', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('job_tag');
    }
};
