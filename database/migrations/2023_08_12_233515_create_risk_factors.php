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
    { //26.1
        Schema::create('risk_factors', function (Blueprint $table) {
            $table->id();
           
            $table->boolean('obesity')->nullable(); 
            $table->boolean('smoking'); 
            $table->string('level_cholesterol_in_blood')->length(255)->nullable(); 
            $table->boolean('lack_of_physical_activity')->nullable(); 
            $table->string('family_history_of_vascular_injuries')->length(255)->nullable(); 
            $table->integer('age')->length(11); 
            $table->enum('degree_of_risk', ['low', 'middle', 'high', 'very_high', 'too_high_see_your_doctor']); 
           
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
        Schema::dropIfExists('risk_factors');
    }
};
