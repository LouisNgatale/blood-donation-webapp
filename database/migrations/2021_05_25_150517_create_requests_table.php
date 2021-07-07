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
            $table->string('doctor_status')->default('pending');
            $table->string('admin_status')->default('pending');
            $table->integer('quantity');
            $table->bigInteger('zone_id');
//            $table->string('request_code_id');
            $table->date('required_date');
            $table->boolean('doctor_approved')->default(false);
            $table->boolean('isApproved')->default(false);
            $table->boolean('isDenied')->default(false);
            $table->timestamps();

            $table->index(['zone_id']);
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
