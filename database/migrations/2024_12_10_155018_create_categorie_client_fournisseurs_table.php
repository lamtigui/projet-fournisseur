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
        Schema::create('categorie_client_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categorie_id');
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('clientFournisseur_id');
            $table->foreign('clientFournisseur_id')->references('id')->on('fournisseur_clients')->onDelete('cascade');
            $table->unique(['categorie_id','clientFournisseur_id'],'categorie_client_fournisseurs_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie_client_fournisseurs');
    }
};
