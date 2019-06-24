<?php

use Illuminate\Database\Seeder;
use App\Models\PostType;

class PostTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('post_types')->insert(['type' => 'Vídeo']);
        \DB::table('post_types')->insert(['type' => 'Picture']);
        \DB::table('post_types')->insert(['type' => 'Text']);
    }
}
