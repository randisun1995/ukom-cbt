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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->references('id')->on('positions')->cascadeOnDelete();
            $table->foreignId('level_id')->references('id')->on('levels')->cascadeOnDelete();
            $table->string('nip')->unique();
            $table->string('name');
            $table->string('password');
            $table->string('instansi_id')->references('id')->on('instansis')->cascadeOnDelete();;
            $table->string('type');
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
        Schema::dropIfExists('participants');
    }
};
