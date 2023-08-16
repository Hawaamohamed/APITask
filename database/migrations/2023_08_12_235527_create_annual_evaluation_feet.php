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
    { //27.1
        Schema::create('annual_evaluation_feet', function (Blueprint $table) {
            $table->id();
          
            $table->date('date')->nullable(); 
            $table->time('time')->nullable(); 
            $table->enum('skin_color', ['normal', 'Abnormal', 'see doctor'])->nullable(); 
            $table->enum('deformities_of_foot', ['normal', 'Abnormal', 'see doctor'])->nullable(); 
            
            $table->enum('dropsy', ['normal', 'Abnormal', 'see doctor'])->nullable(); 
            $table->enum('sensation_of_extremities', ['normal', 'Abnormal', 'see doctor'])->nullable(); 
            $table->enum('pulse_in_dorsal_artery_foot', ['normal', 'Abnormal', 'see doctor'])->nullable(); 
            $table->enum('pulsation_in_bronchial_artery', ['normal', 'Abnormal', 'see doctor'])->nullable(); 
            
            $table->enum('sores', ['normal', 'Abnormal', 'see doctor'])->nullable(); 
            $table->enum('amputation', ['normal', 'Abnormal', 'see doctor'])->nullable(); 
            $table->enum('evaluation', ['normal', 'Abnormal', 'see doctor'])->nullable(); 
            $table->string('recommendation')->nullable(); 
            $table->string('degree_of_danger')->nullable(); 
            $table->string('transfer_to_hospital')->nullable();  
            $table->text('notes')->nullable(); 
 
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
        Schema::dropIfExists('annual_evaluation_feet');
    }
};
