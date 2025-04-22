<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // Ex: "Ajout", "Suppression", "Modification"
            $table->string('type');   // Ex: "Client", "Utilisateur", "Fournisseur"
            $table->text('description')->nullable(); // Détails de l'action
            $table->unsignedBigInteger('user_id')->nullable(); // ID de l'utilisateur qui a fait l'action
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
