<?php

namespace Modules\JobOffer\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\JobOffer\Models\JobOffer;

class JobOfferDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = ['pending','new','confirm_interview','rejected','accepted'];
        $faker = Factory::create('fa_IR');
        foreach (range(1,90) as $r) { 
            DB::table('resumes')->insert([
                'name' => $faker->name(),
                'mobile' => $faker->phoneNumber(),
                'job_id' => JobOffer::all()->random()->id,
                'status' => $status[rand(0,2)],
                'created_at'=> now(),
            ]);
        }
    }
}
