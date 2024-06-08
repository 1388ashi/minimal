<?php

namespace Modules\Comment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use faker\Factory;
use Modules\Product\Models\Product;

class CommentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = ['pending','rejected','accepted'];
        $faker = Factory::create('fa_IR');
        foreach (range(1,90) as $r) { 
            DB::table('comments')->insert([
                'name' => $faker->name(),
                'text' => $faker->realText(rand(150,350)),
                'star' => random_int(1,5),
                'product_id' => Product::all()->random()->id,
                'mobile' => $faker->phoneNumber(),
                'status' => $status[rand(0,2)],
                'created_at'=> now(),
            ]);
        }
    }
}
