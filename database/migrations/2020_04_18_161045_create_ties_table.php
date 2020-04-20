<?php

use App\Models\Tie;
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

            $table->foreignId(Tie::SRC_COLUMN);
            $table->foreignId(Tie::DEST_COLUMN);
            $table->foreignId(Tie::REF_COLUMN)->default(0);
            $table->integer('rank')->nullable();
            $table->timestamps();

            $table->primary([Tie::REF_COLUMN, Tie::SRC_COLUMN, Tie::DEST_COLUMN]);

            $table->foreign(Tie::SRC_COLUMN)->references('id')->on('nodes');
            $table->foreign(Tie::DEST_COLUMN)->references('id')->on('nodes');

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
