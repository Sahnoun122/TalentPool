<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidaturesTable extends Migration
{
    public function up()
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained('annonces');
            $table->foreignId('candidat_id')->constrained('users');
            $table->string('cv_path');
            $table->string('lettre_motivation');
            $table->string('statut')->default('en_attente' , 'terminee' , 'annulee');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidatures');
    }
}
