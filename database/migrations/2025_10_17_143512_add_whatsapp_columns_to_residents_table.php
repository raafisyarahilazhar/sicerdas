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
            $table->string('wa_number_e164', 15)->nullable()->after('phone')->index();
            $table->boolean('whatsapp_opt_in')->default(true)->after('wa_number_e164');
            $table->timestamp('whatsapp_verified_at')->nullable()->after('whatsapp_opt_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn('wa_number_e164', 'whatsapp_opt_in', 'whatsapp_verified_at');
        });
    }
};
