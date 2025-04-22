<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('fournisseur_clients', function (Blueprint $table) {
            $table->string('GSM1_fournisseurClient');
            $table->string('GSM2_fournisseurClient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fournisseur_clients', function (Blueprint $table) {
            //
        });
    }
};
