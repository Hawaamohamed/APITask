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
    { //26.3
        Schema::create('late_complications', function (Blueprint $table) {
            $table->id();
          
            $table->boolean('heart_attack')->nullable(); 
            $table->boolean('congestive_heart_failure')->nullable(); 
            $table->boolean('apoplexy')->nullable(); 
            $table->boolean('renal_failure_in_final_stages')->nullable(); 
            $table->boolean('blindness')->nullable(); 
            $table->boolean('amputation')->nullable();  
            
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
        Schema::dropIfExists('late_complications');
    }
};
