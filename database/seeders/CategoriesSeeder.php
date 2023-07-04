<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = 'Programming';
        $category->slug = 'programing';
        $category->save();

        $category = new Category();
        $category->name = 'Laravel';
        $category->slug = 'laravel';
        $category->save();

        $category = new Category();
        $category->name = 'Personal';
        $category->slug = 'personal';
        $category->save();

        $category = new Category();
        $category->name = 'Laravel 9';
        $category->slug = 'laravel_9';
        $category->save();

        $category = new Category();
        $category->name = 'Laravel 10';
        $category->slug = 'laravel_10';
        $category->save();
    }
}
