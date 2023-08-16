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
    { //24
        Schema::create('visits', function (Blueprint $table) {
            $table->id(); 
      
            $table->date('date_of_visit'); 
            $table->time('time_of_visit')->length(11); 
            $table->string('type_of_disease')->length(255); 
            $table->string('type_of_treatment')->length(255); 
            $table->enum('disease_control_status', ['controlled', 'non controlled']); 
            $table->integer('weight')->length(11); 
            $table->integer('height')->length(11); 
            $table->string('body_mass')->length(255); 
            $table->enum('blood_pressure_measurement', ['low', 'middle', 'high', 'very_high', 'too_high_see_your_doctor'])->nullable(); 
            $table->string('degree_of_glucose_measurement')->length(255)->nullable(); 
            $table->string('fasting_sugar')->length(255)->nullable(); 
            $table->string('cumulative_sugar')->length(255)->nullable(); 
            
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
        Schema::dropIfExists('visits');
    }
};
