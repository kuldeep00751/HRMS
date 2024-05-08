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
        Schema::create('user_info_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_info_id');
            $table->integer('qualification_id');
            $table->integer('academic_intake_id');
            $table->integer('campus_id');
            $table->integer('study_mode_id');
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
        Schema::dropIfExists('user_info_applications');
    }
};
