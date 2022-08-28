<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id')->nullable();
            $table->unsignedInteger('paper_id')->nullable();
            $table->date('recruitment_date')->nullable();
            $table->date('insurance_date')->nullable();
            $table->string('post')->nullable();
            $table->string('contract_length')->nullable();
            $table->string('exp_contract_length')->nullable();
            $table->string('post_location')->nullable();
            $table->unsignedInteger('work_address')->nullable();
            $table->string('salary')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('exp_end_date')->nullable();
            $table->boolean('extension')->default(1)->nullable();
            $table->boolean('cancel')->default(0)->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
