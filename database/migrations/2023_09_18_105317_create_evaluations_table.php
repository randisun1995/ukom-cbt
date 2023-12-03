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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examiner_group_id')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('participant_id')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('indicator_id')->restrictOnDelete()->restrictOnUpdate();
            $table->string('score');
            $table->timestamps();

            // $table->foreignId('position_id')->references('id')->on('positions')->restrictOnDelete()->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};
