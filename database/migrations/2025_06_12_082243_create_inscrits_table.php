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
        Schema::create('inscrits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->nullable()->constrained('entreprises', 'id');
             $table->foreignId('administrateur_id')->nullable()->constrained('administrateurs', 'id');
            $table->string('libelle')->nullable();
            $table->string('ancien_libelle')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('codeConfirmation')->nullable()->unique();
            $table->bigInteger('nombre_installation')->nullable();
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
        Schema::dropIfExists('inscrits');
    }
};
