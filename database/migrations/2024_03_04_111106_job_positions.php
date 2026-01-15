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
        Schema::create('job_positions', function (Blueprint $table) {
            $table->id('position_id');
            $table->string('position_Title', 255);
            $table->string('position_Code', 10);
            $table->tinyInteger('position_Status')->default(1)->comment('1 - active, 2 - inactive');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('job_positions');
    }
};
