<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCoinsPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins_prices', function (Blueprint $table) {
            $table->uuid('id')->primary()->increment();
            $table->uuid('coin_id')->onDelete('cascade')->index();
            $table->decimal('price', 24, 10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins_prices');
    }
}
