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
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises', 'id');
             $table->foreignId('administrateur_id')->nullable()->constrained('administrateurs', 'id');
            $table->foreignId('taxe_entreprise_id')->nullable()->constrained('taxe_entreprises', 'id');  // si id es null c'est un paiement concernant tout
            $table->string('montant')->nullable(); // Montant du paiement
            $table->string('numero_cheque')->nullable(); // Code du paiement
            $table->string('banque')->nullable(); // Référence du paiement
            $table->string('autre_banque')->nullable(); // Moyen de paie
            $table->date('date_emission')->nullable(); // Date du paie
            $table->string('titulaire')->nullable();
            $table->string('NaturePaiement')->nullable();
            $table->text('motif_rejet')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', [1, 2, 3,4,5])->default(2); // Statut du paiement (2: En attente, 1: succes, 3: echoue ,4 desactiver, 5 Annuel Apres Validation )
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
