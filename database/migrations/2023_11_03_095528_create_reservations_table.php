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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('voiture_id')->constrained('voitures');
            $table->date('date_debut');
            $table->time('heure_depart');
            $table->string('lieu_depart');
            $table->date('date_fin');
            $table->time('heure_fin');
            $table->string('destination');
            $table->decimal('montant_reservation', 10, 2);
            $table->decimal('montant_total', 10, 2)->default(0.0);
            $table->softDeletes();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
