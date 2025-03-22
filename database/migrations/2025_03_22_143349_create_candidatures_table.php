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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained('annonces');
            $table->foreignId('candidat_id')->constrained('users');
            $table->string('cv_path');
            $table->string('lettre_motivation_path')->nullable(); 
            $table->string('statut')->default('en_attente' , 'entretien ' , 'annule', 'terminie');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
