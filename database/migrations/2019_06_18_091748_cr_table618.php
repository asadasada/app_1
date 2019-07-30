<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrTable318 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test318', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('text');
            //強制的にcreated_at.update_at 明示するならtimestamp("name");
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
Schema::drop("test318");
    }
}
