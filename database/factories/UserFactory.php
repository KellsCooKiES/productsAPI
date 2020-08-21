<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description'=> $faker->sentence,
        'price'=> 12.00,
        'quantity'=> $faker->randomNumber(),
        'external_id'=>$faker->numberBetween()
    ];
});
$factory->define(\App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'parent_id' => $faker->numberBetween(0,1000),
        'external_id'=>$faker->numberBetween(1,20000)
    ];
});

