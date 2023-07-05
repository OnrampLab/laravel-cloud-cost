<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_costs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 60);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->unsignedDecimal('amount', 14, 6);
            $table->string('currency', 3);

            $table->unique(['type', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cloud_costs');
    }
};
