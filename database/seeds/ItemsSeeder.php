<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 20; $i++) {
            Item::create([
                'item_name' => $faker->name,
                'item_code' => $faker->numberBetween($min = 1000, $max = 9000),
                'item_price' => $faker->randomNumber(2),
                'user_id' => 1,
            ]);
        }
    }
}
