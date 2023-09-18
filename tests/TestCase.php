<?php

namespace Tests;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\UploadedFile;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // create a new user to authenticate
        $this->user = User::factory()->create();
    }

    protected function authenticated(): TestCase
    {
        return $this->actingAs($this->user);
    }

    protected function createMyListing(): Listing
    {
        // create a new listing
        /** @var Listing $listing */
        $listing = Listing::create([
            'id' => '7febb356-78db-4e3f-9c36-562251e0de6c',
            'owner_id' => $this->user->id,
            'name' => 'my listing',
            'description' => 'my listing description',
            'adults' => 2,
            'children' => 1,
            'is_pets_allowed' => true,
            'base_price' => 14,
            'cleaning_fee' => 12,
            'weekly_discount' => 0.2,
            'monthly_discount' => 0.4,
        ]);

        // attach an image
        $image = UploadedFile::fake()->image('my-listing.jpg', 2, 2);
        $listing->addMedia($image)->toMediaCollection();

        // add some special prices
        $listing->specialPrices()->createMany([
            [
                'id' => 'fb015be6-eb8b-464e-bd04-a4804eeea451',
                'date' => '2022-08-27',
                'price' => 13,
            ],
            [
                'id' => '5286a1d9-577b-4880-ab63-6e8beeb726fb',
                'date' => '2022-08-26',
                'price' => 12,
            ],
        ]);

        return $listing;
    }
}
