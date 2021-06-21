<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipient_id');
            $table->string('blood_type');
            $table->integer('quantity');
            $table->bigInteger('zone_id');
            $table->string('blood_rha');
            $table->string('request_code_id');
            $table->date('required_date');
            $table->boolean('isApproved')->default(false);
            $table->timestamps();

            $table->index(['request_code_id','zone_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
