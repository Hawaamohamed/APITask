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
    {   //25.2
        Schema::create('previous_analysis', function (Blueprint $table) {
            $table->id();
            
            $table->enum('fasting_sugar', ['disciplined', 'not disciplined'])->nullable(); 
            $table->date('date')->nullable(); 
            $table->string('glucose_meter')->length(255)->nullable();
            $table->enum('cumulative_sugar', ['low', 'middle', 'high', 'very_high', 'too_high_see_your_doctor'])->nullable(); 
            $table->string('result_of_cumulative_sugar')->length(255)->nullable(); 
            $table->string('sugar_two_hours_after_eating')->length(255)->nullable(); 
            $table->string('random_sugar')->length(255)->nullable();  
            
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

            $table->integer('user_id')->length(11);
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
        Schema::dropIfExists('previous_analysis');
    }
};
