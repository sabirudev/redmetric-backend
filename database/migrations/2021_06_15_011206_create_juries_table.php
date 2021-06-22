<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('phone');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('tax_number')->nullable();
            $table->string('address')->nullable();
            $table->string('title')->comment('nama dengan gelar');
            $table->string('position')->comment('jabatan');
            $table->string('company')->nullable();
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
        Schema::dropIfExists('juries');
    }
}
