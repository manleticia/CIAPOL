<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taxe_entreprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises', 'id');
            $table->string('annee')->nullable();
            $table->string('semestre_depose')->nullable(); /// agent cle 
            $table->string('localisation')->nullable();
            $table->string('annee_depot_taxe')->nullable();
            $table->date('date_depot')->nullable();
            $table->date('date_limite_payement')->nullable();
            $table->bigInteger('montant')->nullable();
            $table->enum('status', [1, 2])->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxe_entreprises');
    }
};
