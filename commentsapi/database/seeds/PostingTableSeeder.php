<?php

use Illuminate\Database\Seeder;
use App\Posting;

class PostingTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Posting::class, 10)->create();
    }
}
