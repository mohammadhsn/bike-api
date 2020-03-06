<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bikes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('licence_number')->unique();
            $table->string('type');
            $table->string('color');
            $table->string('owner');
            $table->text('description');
            $table->date('theft_at');
            $table->unsignedBigInteger('officer_id')->nullable();
            $table->foreign('officer_id')
                ->references('id')
                ->on('officers')
                ->onDelete('set null');
            $table->unique('officer_id');
            $table->boolean('found')->default(false);
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
        Schema::dropIfExists('bikes');
    }
}
