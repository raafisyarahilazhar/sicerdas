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
        Schema::create('application_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable(); // e.g. SKD (Surat Keterangan Domisili)
            $table->string('name');
            $table->text('requirements')->nullable();
            $table->string('template_file')->nullable()
                  ->comment('Path ke file template Word (.docx)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_types');
    }
};
