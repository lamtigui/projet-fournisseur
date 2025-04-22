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
        Schema::create('fournisseur_clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('groupId_fournisseurClient')->nullable();
            $table->string('nomSociete_fournisseurClient');
            $table->string('nom_fournisseurClient');
            $table->string('tele_fournisseurClient');
            $table->string('email_fournisseurClient');
            $table->string('ville_fournisseurClient');
            $table->integer('version_fournisseurClient')->default(1);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade');
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisseur_clients');
    }
};
