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
    {   //28.1
        Schema::create('pharmaceutical', function (Blueprint $table) {
            $table->id();
            $table->string('medicament_name')->length(255); 
            $table->string('amount_spent')->length(255); 
            $table->string('pharmaceutical_form')->length(255); 
            $table->string('daily_dose')->length(255); 
            $table->date('last_modified_date')->nullable(); 
            $table->text('notes')->nullable(); 
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
        Schema::dropIfExists('pharmaceutical');
    }
};
