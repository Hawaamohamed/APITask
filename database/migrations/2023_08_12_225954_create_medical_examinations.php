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
    { //25.1
        Schema::create('medical_examinations', function (Blueprint $table) {
            $table->id();
            
            $table->date('date_of_visit'); 
            $table->time('time_of_visit'); 
            $table->enum('type_of_visit', ['follow-up', 'periodic']); 
            $table->integer('weight')->length(11); 
            $table->integer('height')->length(11); 
            $table->string('body_mass')->length(255); 
            $table->enum('waistline', ['normal', 'Abnormal'])->nullable(); 
            $table->enum('blood_pressure_measurement', ['low', 'middle', 'high', 'very_high', 'too_high_see_your_doctor'])->nullable(); 
            
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
        Schema::dropIfExists('medical_examinations');
    }
};
