<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nama Kelurahan');
            $table->date('since')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->string('province');
            $table->string('head')->comment('Kepala Desa');
            $table->string('secretary')->nullable();
            $table->integer('amount_male')->default(0);
            $table->integer('amount_female')->default(0);
            $table->integer('amount_productive_age')->default(0)->comment('Jumlah Usia Produktif');
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
        Schema::dropIfExists('villages');
    }
}
