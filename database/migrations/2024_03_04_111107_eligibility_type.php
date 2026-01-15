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
        Schema::create('eligibility_type', function (Blueprint $table) {
            $table->id('eligibility_type_id');
            $table->string('eligibility_Name', 255);
            $table->string('eligibility_Code', 10);
            $table->tinyInteger('eligibility_Status')->default(1)->comment('1 - active, 2 - inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eligibility_type', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('eligibility_type');
    }
};
