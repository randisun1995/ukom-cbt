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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->references('id')->on('exams')->cascadeOnDelete();
            $table->foreignId('exam_session_id')->references('id')->on('exam_sessions')->cascadeOnDelete();
            $table->foreignId('participant_id')->references('id')->on('participants')->cascadeOnDelete();
            $table->integer('duration');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->integer('total_correct');
            $table->decimal('grade', 5, 2);
            $table->string('status')->nullable();
            $table->dateTime('start_point')->nullable();
            $table->dateTime('end_point')->nullable();
            $table->integer('counter')->nullable();
            $table->integer('summary')->nullable();
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
        Schema::dropIfExists('grades');
    }
};
