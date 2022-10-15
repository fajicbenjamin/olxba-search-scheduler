<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->boolean('active');

            $table->foreignId('user_id')->constrained();
            $table->foreignId('search_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_users');
    }
}
