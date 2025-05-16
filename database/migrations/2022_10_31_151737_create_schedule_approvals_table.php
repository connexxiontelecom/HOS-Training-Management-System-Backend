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
        Schema::create('schedule_approvals', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id');//schedule_id
            $table->integer('approver_id');//approver user id
            $table->tinyInteger('status');//approved/declined
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
        Schema::dropIfExists('schedule_approvals');
    }
};
