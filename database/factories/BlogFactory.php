<?php

namespace Database\Factories;

use App\Models\Blog;
use Faker\Generator as Faker;
// use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
// class BlogFactory extends Factory
// {
//     /**
//      * Define the model's default state.
//      *
//      * @return array<string, mixed>
//      */
//     protected $model = Blog::class;

//     public function definition()
//     {
//         return [
//             'title' => $this->faker->word,
//             'content' => $this->faker->realText,
//         ];
//     }
//     // public function definition(): array
//     // {
//     //     return [
//     //         //
//     //     ];
//     // }
// }

// class BlogFactory extends Factory
// {
//     protected $model = Blog::class;

//     public function definition()
//     {
//         return [
//             'title' => $this->faker->word,
//             'content' => $this->faker->realText,
//         ];
//     }
// }


# laravel7以前の表現方法は以下の通り。
$factory->define(Blog::class, function
(Faker $faker) {
    return [
        'title' => $faker->word,
        'content' => $faker->realText,
    ];
});
