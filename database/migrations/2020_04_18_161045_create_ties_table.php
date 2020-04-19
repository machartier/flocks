<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ties', function (Blueprint $table) {

            $table->foreignId('src');
            $table->foreignId('dest');
            $table->foreignId('ref')->nullable();
            $table->integer('rank')->nullable();
            $table->timestamps();

            $table->primary(['src', 'dest', 'ref']);

            $table->foreign('src')->references('id')->on('nodes');
            $table->foreign('dest')->references('id')->on('nodes');
            $table->foreign('ref')->references('id')->on('nodes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ties');
    }
}
