<?php

namespace Database\Seeders;
use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run()
    {
        //
        \App\Models\Blog::factory()->count(15)->create(); 
    }
}
