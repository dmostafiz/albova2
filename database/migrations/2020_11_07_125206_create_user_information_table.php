<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdat('cascade')->oneDelete('cascade');

            $table->string('type')->nullable();
            //IP Info
            $table->string('ip')->nullable();
            $table->string('ip_type')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('continent')->nullable();
            $table->string('postal')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('time_zone')->nullable();

            $table->string('org_name')->nullable();
            $table->string('org_domain')->nullable();
            $table->string('org_route')->nullable();
            $table->string('org_type')->nullable();

            //Agent Info
            $table->string('device')->nullable();

            $table->string('platform')->nullable();
            $table->string('platform_version')->nullable();

            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();

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
        Schema::dropIfExists('user_information');
    }
}
