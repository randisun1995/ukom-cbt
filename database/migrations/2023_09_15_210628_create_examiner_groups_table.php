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
        Schema::create('examiner_groups', function (Blueprint $table) {
            $table->id();
            $table->string('examsession_id')->references('id')->on('examsessions')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('participant_id')->references('id')->on('participants')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('examiner_id')->references('id')->on('examiners')->restrictOnDelete()->restrictOnUpdate();
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
        Schema::dropIfExists('examiner_groups');
    }
};
