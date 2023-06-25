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
        Schema::table('ibge}', function (Blueprint $table) {
            Schema::create('ibge', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('ibge_id');
                $table->string('ibge_name');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ibge');
    }
};
