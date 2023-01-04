<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwoWeeksReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('two_weeks_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('chat_id');
            $table->string('username');
            $table->string('covid_sign')->default('nothing');
            $table->boolean('have_cold')->default(0);
            $table->boolean('have_cough')->default(0);
            $table->boolean('have_headache')->default(0);
            $table->boolean('have_stomachache')->default(0);
            $table->string('other_covid_sign')->nullable();
            $table->tinyInteger('covid_test')->nullable();
            $table->boolean('is_message_sent')->default(0);
            $table->boolean('is_reported')->default(0);
            $table->boolean('is_completed')->default(0);
            $table->dateTime('send_message_date')->nullable();
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
        Schema::dropIfExists('two_weeks_reports');
    }
}
