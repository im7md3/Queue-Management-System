<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->uuid('cookie_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services','id')->cascadeOnDelete();
            $table->integer('number');
            $table->time('called_at')->nullable();
            $table->time('served_at')->nullable();
            
            $table->timestamps();

            $table->unique(['cookie_id','service_id','number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queues');
    }
}
