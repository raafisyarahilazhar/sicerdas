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
        Schema::table('residents', function (Blueprint $table) {
            $table->string('occupation')->nullable();
            $table->string('education_level')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('income_bracket')->nullable();
            $table->boolean('disability_status')->default(false);
            $table->string('blood_type',3)->nullable();
            $table->string('citizenship',3)->nullable(); // WNI/WNA
            $table->decimal('lat',10,7)->nullable();
            $table->decimal('lng',10,7)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            //
        });
    }
};
