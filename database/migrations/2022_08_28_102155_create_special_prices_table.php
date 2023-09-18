<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        // TODO: implement the migration schema

        Schema::create('special_prices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('listing_id');
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->timestamp('date') ;
            $table->double('price');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('special_prices');
    }
};
