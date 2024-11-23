<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiscussionRoomSeeder extends Seeder
{
    public function run()
    {
        DB::table('discussion_rooms')->insert([
            [
                'name' => 'Discussion Room 1',
                'capacity' => 10,
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Discussion Room 2',
                'capacity' => 15,
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
