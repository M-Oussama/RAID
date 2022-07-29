<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->date('birthdate')->nullable();
            $table->unsignedBigInteger('birthplace_id')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->smallInteger('gender')->nullable();
            $table->string('family_status')->nullable();
            $table->integer('children_number')->nullable();
            $table->string('wife_name')->nullable();
            $table->string('birthday_number')->nullable();
            $table->string('education_level')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('postal_account_number')->nullable();
            $table->string('social_security_number')->nullable();
            $table->date('recruitment_date')->nullable();
            $table->date('insurance_date')->nullable();
            $table->string('national_service')->nullable();
            $table->string('national_service_rank')->nullable();
            $table->string('phone')->nullable();
            $table->string('national_card')->nullable();
            $table->date('national_card_date')->nullable();
            $table->unsignedBigInteger('national_card_address')->nullable();
            $table->string('driver_license')->nullable();
            $table->date('driver_license_date')->nullable();
            $table->unsignedBigInteger('driver_license_address')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
