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
        Schema::create('peso_accounts', function (Blueprint $table) {
            $table->id('peso_accounts_id');
            $table->unsignedBigInteger('peso_id');
            $table->unsignedBigInteger('user_id');
            $table->string('peso_accounts_Fname', 255);
            $table->string('peso_accounts_Mname', 255)->nullable();
            $table->string('peso_accounts_Lname', 255);
            $table->string('peso_accounts_Pnumber', 255);
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes();

            $table->foreign('peso_id')->references('peso_id')->on('peso');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peso_accounts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('peso');
    }
};
