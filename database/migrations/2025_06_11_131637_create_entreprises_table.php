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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id');
            $table->string('secteur_numero_rapport')->nullable();
            $table->string('agent_programme')->nullable();
            $table->string('numero_ligne')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string('inspection')->nullable();
            $table->string('lieu_de_depot')->nullable();
            $table->string('telephone')->nullable();
            $table->string('telephone_2')->nullable();
            // $table->string('semestre_depose')->nullable();
            $table->bigInteger('nb_taxes_deposees')->default(0);
            $table->bigInteger('nb_taxes_deposees_payees')->default(0);
            $table->bigInteger('nb_taxes_deposees_non_payees')->default(0);
            // $table->string('annee')->nullable();
            // $table->bigInteger('montant')->nullable();
            $table->enum('status', [1, 2])->default(2);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
