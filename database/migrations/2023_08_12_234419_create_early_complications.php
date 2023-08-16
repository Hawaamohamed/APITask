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
    { //26.2
        Schema::create('early_complications', function (Blueprint $table) {
            $table->id();
      
            $table->boolean('cardiovascular_complications')->nullable(); 
            $table->boolean('apoplexy')->nullable(); 
            $table->boolean('complications_in_urinary_system')->nullable(); 
            $table->boolean('complications_in_nervous_system')->nullable(); 
            $table->boolean('complications_in_eyes')->nullable(); 
            $table->boolean('complications_in_feet')->nullable();  
            
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
        Schema::dropIfExists('early_complications');
    }
};
