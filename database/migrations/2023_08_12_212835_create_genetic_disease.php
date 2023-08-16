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
    { //23
        Schema::create('genetic_disease', function (Blueprint $table) {
            $table->id();
          
            $table->boolean('hypertension')->default(0);
            $table->boolean('diabetes')->default(0);
            $table->boolean('cancer')->default(0);
            $table->boolean('psychological_disorders')->default(0);
            $table->boolean('family_genetic_diseases')->default(0); 
            
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
        Schema::dropIfExists('genetic_disease');
    }
};
