<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddAtlasToStarSystems extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('star_systems', function(Blueprint $table) {
            $table->boolean('atlas_interface')->default(false);
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
            $table->dropColumn('atlas_interface');
        });
    }
}
