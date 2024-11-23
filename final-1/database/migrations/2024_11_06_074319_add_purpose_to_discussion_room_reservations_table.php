<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurposeToDiscussionRoomReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('discussion_room_reservations', function (Blueprint $table) {
            $table->string('purpose')->nullable(); // Add the 'purpose' column
        });
    }

    public function down()
    {
        Schema::table('discussion_room_reservations', function (Blueprint $table) {
            $table->dropColumn('purpose');
        });
    }
}
