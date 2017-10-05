<?php

use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert(
            [
                [
                    'path' => '/1',
                    'parent' => null,
                    'name' => 'Electronics',
                    'description' => 'Electronics',
                    'icon' => 'devices'
                ],
                [
                    'path' => '/2',
                    'parent' => null,
                    'name' => 'Cosmetics',
                    'description' => 'Cosmetics',
                    'icon' => 'cosmetics'
                ],

                [
                    'path' => '/1/3',
                    'parent' => 1,
                    'name' => 'SmartPhones',
                    'description' => 'SmartPhones',
                    'icon' => 'phone'
                ],


            ]

        );
    }
}
