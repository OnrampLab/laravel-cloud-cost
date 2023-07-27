<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cloud_costs', function (Blueprint $table) {
            $table->dropUnique(['type', 'year', 'month']);
            $table->dropColumn(['year', 'month']);

            $table->date('date');
            $table->unique(['type', 'date']);
        });
    }

    public function down(): void
    {
        Schema::table('cloud_costs', function (Blueprint $table) {
            $table->dropUnique(['type', 'date']);
            $table->dropColumn('date');

            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->unique(['type', 'year', 'month']);
        });
    }
};
