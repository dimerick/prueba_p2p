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
            $table->increments('id');
            $table->timestamps();
            $table->string('description');
            $table->double('total', 10, 2);
            $table->time('expiracion');
            $table->string('url_return');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->string('request_id')->nullable();
            $table->string('process_url')->nullable();
            $table->string('person');
            $table->foreign('person')->references('email')->on('users');
            $table->string('currency');
            $table->foreign('currency')->references('cod')->on('currencies');
            $table->string('payment_status');
            $table->foreign('payment_status')->references('cod')->on('payments_satus');
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
