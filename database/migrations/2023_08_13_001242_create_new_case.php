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
    {  //29
        Schema::create('new_case', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->length(255); 
            $table->string('color')->length(255); 
            $table->enum('option', ['installed', 'requires_review'])->nullable(); 
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
        Schema::dropIfExists('new_case');
    }
};
