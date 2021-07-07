<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string("blood_group");
            $table->string("blood_rha");
            $table->unsignedBigInteger("donor_id");
            $table->unsignedBigInteger("zone_id");
            $table->dateTime("expire_date");
            $table->boolean("isAvailable")->default(true);
            $table->timestamps();

            $table->index('donor_id');
            $table->index('zone_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
