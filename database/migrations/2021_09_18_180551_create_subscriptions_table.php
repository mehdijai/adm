<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('plan_id')
                ->constrained('plans')
                ->onDelete('cascade');

            $table->boolean('active');
            $table->datetime('activation_date')->nullable();
            $table->boolean('expired');
            $table->datetime('expiration_date')->nullable();
            $table->json('vehicules_ids');
            $table->integer('periode');
            $table->double('montant');
            $table->string('reciept')->nullable();
            $table->string('invoice')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
}
