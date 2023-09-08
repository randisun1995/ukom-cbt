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
        Schema::create('appraiser_groups', function (Blueprint $table) {
            $table->id();
            $table->string('participant_id')->references('id')->on('participants')->cascadeOnDelete();
            $table->string('appraiser_id')->references('id')->on('appraisers')->cascadeOnDelete();
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
        Schema::dropIfExists('appraiser_groups');
    }
};
