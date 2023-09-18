<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        // TODO: implement the migration schema

        Schema::create('listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->integer('adults');
            $table->integer('children');
            $table->boolean('is_pets_allowed')->default(0);
            $table->double('base_price');
            $table->double('cleaning_fee');
            $table->double('weekly_discount');
            $table->double('monthly_discount');

            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            // soft delete
        });
    }

    public function down()
    {
        Schema::dropIfExists('listings');
    }
};
