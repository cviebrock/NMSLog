<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStarSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('star_systems', function (Blueprint $table) {
            $table->bigIncrements('star_system_id');
            $table->string('name');
            $table->string('class', 8);
            $table->string('color', 16);
            $table->string('coordinates');
            $table->unsignedInteger('pos_w');
            $table->unsignedInteger('pos_x');
            $table->unsignedInteger('pos_y');
            $table->unsignedInteger('pos_z');
            $table->decimal('gc_distance', 12, 1);
            $table->unsignedTinyInteger('planets')->default(0);
            $table->unsignedTinyInteger('moons')->default(0);
            $table->boolean('black_hole')->default(false);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('discovered_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('star_systems');
    }
}
