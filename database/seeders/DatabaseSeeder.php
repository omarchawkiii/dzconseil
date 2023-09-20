<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Listing;
use App\Models\SpecialPrice;

use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::factory(10)->create();
        $faker = Faker::create();
        $listings = Listing::factory(2)->create() ;
        $imageUrl = $faker->imageUrl(640,480, null, false);
        foreach($listings  as $listing)
        {
            $listing->addMediaFromUrl($imageUrl)->toMediaCollection('default');
        }

        SpecialPrice::factory(1)->create() ;
    }
}
