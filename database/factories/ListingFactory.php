<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\User ;
class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition(): array
    {
        // TODO: fill in the gaps
        $name = fake()->sentence(4, true) ;
        $slug = Str::slug($name);

        return [
            'owner_id'         => User::all()->random()->id,
            'name'             => $name,
            'slug'             => $slug,
            'description'      => fake()->sentences(5, true) ,
            'adults'           => fake()->numberBetween(1,8)  ,
            'children'         => fake()->numberBetween(1,8)  ,
            'is_pets_allowed'  => fake()->boolean(),
            'base_price'       => fake()->numberBetween(100000,1000000) ,
            'cleaning_fee'     => fake()->numberBetween(100,1000),
            'weekly_discount'  => fake()->randomFloat(2, 0, 1) ,
            'monthly_discount' => fake()->randomFloat(2, 0, 1) ,
        ];
    }
}
