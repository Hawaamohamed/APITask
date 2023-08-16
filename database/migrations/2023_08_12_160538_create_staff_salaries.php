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
        Schema::create('staff_salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('salary_no')->length(11)->nullable();
            $table->string('logo')->length(255)->nullable(); 
            $table->string('salary_address')->length(255)->nullable();
            $table->date('sending_date');
            $table->string('salary')->length(255);
            $table->integer('extra')->length(11)->nullable();
            $table->integer('discount')->length(11)->nullable();
            $table->integer('tax')->length(11)->nullable();
            $table->text('message')->nullable();
            $table->enum('salary_status', ['in_progress', 'close', 'disapproval']);
             
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
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
        Schema::dropIfExists('staff_salaries');
    }
};
