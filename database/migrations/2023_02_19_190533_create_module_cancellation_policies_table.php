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
        Schema::create('module_cancellation_policies', function (Blueprint $table) {
            $table->id();
            $table->integer('academic_year_id');
            $table->integer('study_period_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->decimal('cancellation_percentage', 15,2);
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
        Schema::dropIfExists('module_cancellation_policies');
    }
};
