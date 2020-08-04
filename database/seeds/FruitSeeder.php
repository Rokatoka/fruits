<?php

use Illuminate\Database\Seeder;

class FruitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fruits = ['apple', 'banana', 'pear', 'grapefruit', 'mandarin', 'orange', 'watermelon'];
        foreach ($fruits as $fruit){
            \App\Fruit::create([
                'name' => $fruit
            ]);
        }
    }
}
