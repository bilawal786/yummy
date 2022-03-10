<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddP1ToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->string('p1')->default(1);
           $table->string('p2')->default(1);
           $table->string('p3')->default(1);
           $table->string('p4')->default(1);
           $table->string('p5')->default(1);
           $table->string('p6')->default(1);
           $table->string('p7')->default(1);
           $table->string('p8')->default(1);
           $table->string('p9')->default(1);
           $table->string('p10')->default(1);
           $table->string('p11')->default(1);
           $table->string('p12')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
