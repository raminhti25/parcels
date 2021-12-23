<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->string('pick_up_address');
            $table->string('drop_off_address');
            $table->tinyInteger('status')->default(0);
            $table->integer('biker_id')->default(0);
            $table->integer('sender_id')->default(0);
            $table->string('code', 8);
            $table->double('price', 20, 2)->default(0);
            $table->timestamp('pick_up_date')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->string('recipient_mobile', 21);
            $table->json('details')->nullable();
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
        Schema::dropIfExists('parcels');
    }
}
