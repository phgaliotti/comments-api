<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("notifications", function(Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();
            $table->text("text");
            $table->dateTime("expiration_date")->nullable(true);
            $table->bigInteger("from_user_id")->unsigned();
            $table->foreign("from_user_id")->references("id")->on("users");
            $table->bigInteger("to_user_id")->unsigned();
            $table->foreign("to_user_id")->references("id")->on("users");
            $table->boolean("read");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_notification');
    }
}
