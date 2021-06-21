<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_codes', function (Blueprint $table) {
            $table->id();
            $table->string('request_code');
            $table->bigInteger('owner_id');
            $table->bigInteger('generated_by');

            $table->index(['owner_id','generated_by']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_codes');
    }
}
