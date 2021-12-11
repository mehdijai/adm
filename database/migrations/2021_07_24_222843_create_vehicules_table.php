<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('agence_id')
                ->constrained('agences')
                ->onDelete('cascade');

            $table->foreignId('marque_id')
                ->constrained('marques')
                ->onDelete('cascade');

            $table->string('type');
            $table->string('matricule')->unique();
            $table->double('prix');
            $table->string('assurance');
            $table->string('carb');
            $table->string('boite_de_vitesse');
            $table->text('description');
            $table->json('options');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicules');
    }
}
