<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, 20)->create()->each(function ($category) {
            $category->products()->save(factory(App\Product::class)->make());
        });
    }
}
