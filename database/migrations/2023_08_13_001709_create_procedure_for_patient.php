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
        Schema::create('procedure_for_patient', function (Blueprint $table) {
            $table->id();
            $table->string('name')->length(255); 
            $table->enum('procedures', ['consultation', 'operations', 'detection', 'follow-up', 'Payment received', 'reimbursement_request', 'login', 'logout']); 
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
        Schema::dropIfExists('procedure_for_patient');
    }
};
