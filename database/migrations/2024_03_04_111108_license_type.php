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
        Schema::create('license_type', function (Blueprint $table) {
            $table->id('license_type_id');
            $table->string('license_Name', 255);
            $table->string('license_Code', 10);
            $table->tinyInteger('license_Status')->default(1)->comment('1 - active, 2 - inactive');
            $table->timestamps();
            $table->softDeletes(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('license_type', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('license_type');
    }
};
