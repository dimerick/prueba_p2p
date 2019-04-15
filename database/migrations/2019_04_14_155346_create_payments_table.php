<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('description');
            $table->string('person');
            $table->double('total', 10, 2);
            $table->string('currency');
            $table->string('expiration');
            #$table->string('return_url');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->string('payment_status')->default('PENDING');
            $table->string('payment_date')->nullable();
            $table->string('cus')->nullable();
            $table->string('request_id')->nullable();
            $table->string('process_url')->nullable();
            $table->foreign('person')->references('email')->on('users');
            $table->foreign('currency')->references('cod')->on('currencies');
            $table->foreign('payment_status')->references('cod')->on('payments_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
