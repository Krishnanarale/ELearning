<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('level', 50);
            $table->string('description', 255);
            $table->string('thumbnail', 100);
            $table->enum('status', ['0', '1'])->default('1');
            $table->softDeletes();
            $table->timestamps();
        });
            // $table->enum('deleted', ['0', '1'])->default('0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels');
    }
}
