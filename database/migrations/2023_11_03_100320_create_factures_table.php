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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('facture_id');
            $table->string('reservation_id')->unique();
            $table->string('nom')->unique();
            $table->timestamp('date_emission');
            $table->timestamps();
    
            // Clé étrangère
            $table->foreign('reservation_id')
                  ->references('reservation_id')
                  ->on('reservations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
