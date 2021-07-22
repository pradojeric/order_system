<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToCustomDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_dishes', function (Blueprint $table) {
            //
            $table->enum('type', ['foods', 'drinks'])->after('description');
            $table->boolean('printed')->default(0)->after('description');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_dishes', function (Blueprint $table) {
            //
            $table->dropColumn('type');
            $table->dropColumn('printed');
        });
    }
}
