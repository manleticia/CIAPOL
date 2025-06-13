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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises', 'id');
            $table->foreignId('taxe_entreprise_id')->nullable()->constrained('taxe_entreprises', 'id'); // si id es null c'est un paiement concernant tout
            $table->string('montant')->nullable(); // Montant du paiement
            $table->string('codePaiement')->nullable(); // Code du paiement
            $table->string('referencePaiement')->nullable(); // Référence du paiement
            $table->string('moyenPaiement')->nullable(); // Moyen de paiement
            $table->string('contactPaiement')->nullable(); // Date du paiement
            $table->date('datePaiement')->nullable(); // Date du paiement
            $table->date('HeurePaiement')->nullable(); // Heure du paiement
            $table->string('entite')->nullable();
            $table->enum('status', [1, 2, 3])->default(2); // Statut du paiement (2: En attente, 1: succes, 3: echoue)
            $table->text('message_retour')->nullable(); // Message de retour (optionnel)
            $table->enum('payNature', [1, 2])->default(2); //  Nature du paiement (1: Paiement hub, 2: paiement carte virement)
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
