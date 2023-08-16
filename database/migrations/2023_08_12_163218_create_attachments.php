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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            //$table->string('file_original_name')->nullable();
            $table->string('file_name');
            // $table->integer('file_size')->nullable();
            // $table->string('extension',10)->nullable();
            $table->string('type')->nullable();
            //$table->integer('user_id')->nullable(); 
            
            $table->unsignedBigInteger('staff_salary_id');
            $table->foreign('staff_salary_id')->references('id')->on('staff_salaries')->onDelete('cascade');

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
        Schema::dropIfExists('attachments');
    }
};
