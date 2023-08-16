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
        Schema::create('patient_follow_up', function (Blueprint $table) {
            $table->id();  
            $table->string('type_of_disease')->length(255);
            $table->date('date_of_registration')->nullable();
            $table->date('diagnosis_date')->nullable();
            $table->enum('blood_type', ['A+', 'O+', 'B+', 'AB+', 'A-', 'O-', 'B-', 'AB-'])->nullable();
            $table->boolean('drug_sensitivity')->nullable();
            $table->text('drug_sensitivity_details')->nullable();
            $table->boolean('food_sensitivity')->nullable();
            $table->text('food_sensitivity_details')->nullable();

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
        Schema::dropIfExists('patient_follow_up');
    }
};
