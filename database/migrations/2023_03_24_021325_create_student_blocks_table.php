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
        Schema::create('student_blocks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_info_id');
            $table->integer('student_number');
            $table->string('reason');
            $table->integer('batch_number');
            $table->integer('blocked_by');
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
        Schema::dropIfExists('student_blocks');
    }
};
