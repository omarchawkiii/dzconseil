<?php

namespace Database\Factories;

use App\Models\SpecialPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Listing;

class SpecialPriceFactory extends Factory
{
    protected $model = SpecialPrice::class;

    public function definition(): array
    {
        // TODO: fill in the gaps
        $listing = Listing::all()->random() ;

        return [
             'listing_id' => $listing->id,
             'date'       => fake()->dateTime() ,
             'price'      => fake()->numberBetween(10000 , $listing->base_price)  ,
        ];
    }
}
