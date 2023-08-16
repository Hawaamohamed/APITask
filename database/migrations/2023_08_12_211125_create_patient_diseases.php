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
    { //22.2
        Schema::create('patient_diseases', function (Blueprint $table) {
            $table->id(); 
            
            $table->boolean('cancer')->default(0);
            $table->text('cancer_details')->nullable();

            $table->boolean('heart_diseases')->default(0);
            $table->text('heart_diseases_details')->nullable();

            $table->boolean('disability')->default(0);
            $table->text('disability_details')->nullable();
             
            $table->boolean('endocrine')->default(0);
            $table->text('endocrine_details')->nullable();
             
            $table->boolean('ophthalmology')->default(0);
            $table->text('ophthalmology_details')->nullable();
             
            $table->boolean('digestive')->default(0);
            $table->text('digestive_details')->nullable();
             
            $table->boolean('psychiatric_mental_disorder')->default(0);
            $table->text('psychiatric_mental_disorder_details')->nullable();
             
            $table->boolean('neurological_diseases')->default(0);
            $table->text('neurological_diseases_details')->nullable();
             
            $table->boolean('prosthetics')->default(0);
            $table->text('prosthetics_details')->nullable();
             
            $table->boolean('urinary_tract')->default(0);
            $table->text('urinary_tract_details')->nullable();
            
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
        Schema::dropIfExists('patient_diseases');
    }
};
