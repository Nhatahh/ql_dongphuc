<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone_users',10);
            $table->string('id_card_users',12);
            $table->string('email_users',255);
            $table->string('password',255);
            $table->integer('active_users')->default(1);
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
        //
    }
}
