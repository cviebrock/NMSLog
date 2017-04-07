<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorColorAndClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('star_systems', function(Blueprint $table) {
            $table->dropColumn('color');
            $table->string('class', 8)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('star_systems', function(Blueprint $table) {
            $table->string('class', 8)->change();
            $table->string('color', 16)->after('class');
        });
    }
}
