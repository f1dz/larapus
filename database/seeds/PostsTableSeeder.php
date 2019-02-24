<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            [
                'title' => 'Tips cepat nikah',
                'content' => 'Ayo nikah'
            ],
            [
                'title' => 'Haruskah menunda nikah?',
                'content' => 'test post'
            ],
            [
                'title' => 'Haruskah menunda makan?',
                'content' => 'test post'
            ]
        ];

        DB::table('posts')->insert($posts);
    }
}
