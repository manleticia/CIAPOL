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
            $table->foreignId('administrateur_id')->nullable()->constrained('administrateurs', 'id');
            $table->string('raison_sociale')->nullable();
            $table->string('inspection')->nullable();
            $table->string('telephone')->nullable();
            $table->string('telephone_2')->nullable();
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
