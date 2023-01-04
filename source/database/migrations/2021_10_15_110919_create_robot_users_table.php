<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRobotUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('robot_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('chat_id');
            $table->string('username');
            $table->boolean('sex')->nullable();
            $table->string('covid_sign')->default('nothing');
            $table->boolean('have_cold')->default(0);
            $table->boolean('have_cough')->default(0);
            $table->boolean('have_headache')->default(0);
            $table->boolean('have_stomachache')->default(0);
            $table->string('other_covid_sign')->nullable();
            $table->tinyInteger('age')->nullable();
            $table->tinyInteger('is_vaccinated')->nullable();
            $table->tinyInteger('covid_test')->nullable();
            $table->boolean('covid_relation')->nullable();
            $table->boolean('respiratory_disease')->nullable();
            $table->string('respiratory_name')->nullable();
            $table->integer('question_counter')->default(1);
            $table->string('deep_breath')->nullable();
            $table->string('breath')->nullable();
            $table->string('slow_cough')->nullable();
            $table->string('cough')->nullable();
            $table->string('slow_numbers')->nullable();
            $table->string('fast_numbers')->nullable();
            $table->string('a_voice')->nullable();
            $table->string('b_voice')->nullable();
            $table->string('c_voice')->nullable();
            $table->tinyInteger('voice_counter')->default(0);
            $table->boolean('is_downloaded')->default(0);
            $table->boolean('is_reported')->default(0);
            $table->boolean('is_completed')->default(0);
            $table->string('tracking_code')->default(0);
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
        Schema::dropIfExists('robot_users');
    }
}
