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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->unique(); // e.g. DESA-20250910-0001

            // Relasi ke warga
            $table->foreignId('resident_id')
                ->constrained('residents')
                ->cascadeOnDelete();

            // Relasi ke jenis surat
            $table->foreignId('application_type_id')
                ->constrained('application_types')
                ->cascadeOnDelete();

            $table->json('form_data')->nullable(); // store submitted fields
            $table->string('status')->default('pending_rt')->index(); 
            // status: pending_rt, pending_rw, pending_kades, approved, rejected

            $table->string('qr_token')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
