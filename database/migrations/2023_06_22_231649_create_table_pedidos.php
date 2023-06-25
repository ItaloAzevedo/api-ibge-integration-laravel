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
        Schema::table('pedidos}', function (Blueprint $table) {
            Schema::create('pedidos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('category');
                $table->enum('status', array('ACTIVE', 'INACTIVE'))->default('ACTIVE');
                $table->decimal('quantity');
                $table->timestamps();
                $table->softDeletes();
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
        Schema::table('pedidos}', function (Blueprint $table) {
            //
        });
    }
};
