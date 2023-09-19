<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\SpecialPrice;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ListingsTest extends TestCase
{
    use WithFaker;

    protected string $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        $this->endpoint = 'api/listings';
    }

    public function test_index()
    {
        Listing::factory()
            ->has(SpecialPrice::factory())
            ->count(3)
            ->create();

        $this->authenticated()
            ->json('get', $this->endpoint)
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'owner_id',
                        'name',
                        'slug',
                        'description',
                        'adults',
                        'children',
                        'is_pets_allowed',
                        'base_price',
                        'cleaning_fee',
                        'image_url',
                        'weekly_discount',
                        'monthly_discount',
                    ],
                ],
            ])
            ->assertJsonStructureMissing([
                'data' => [
                    [
                        'special_prices',
                    ],
                ],
            ]);
    }

    public function test_show()
    {
        Storage::fake('media');

        $listing = $this->createMyListing();

        $this->authenticated()
            ->json('get', "$this->endpoint/$listing->id")
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => '7febb356-78db-4e3f-9c36-562251e0de6c',
                    'owner_id' => $this->user->id,
                    'name' => 'my listing',
                    'slug' => 'my-listing',
                    'description' => 'my listing description',
                    'adults' => 2,
                    'children' => 1,
                    'is_pets_allowed' => true,
                    'base_price' => 14,
                    'cleaning_fee' => 12,
                    'image_url' => '/storage/1/my-listing.jpg',
                    'weekly_discount' => 0.2,
                    'monthly_discount' => 0.4,
                    'special_prices' => [
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
                    ],
                ],
            ]);
    }

    public function test_create()
    {
        Storage::fake('media');

        $payload = [
            'name' => 'my listing',
            'description' => $this->faker->randomElement([null, 'my listing description']),
            'adults' => 2,
            'children' => 1,
            'is_pets_allowed' => true,
            'base_price' => 14,
            'cleaning_fee' => 12,
            'image' => $image = $this->faker->randomElement([null, UploadedFile::fake()->image('my-listing.jpg', 2, 2)]),
            'weekly_discount' => 0.2,
            'monthly_discount' => 0.4,
        ];

        $this->authenticated()
            ->json('post', $this->endpoint, $payload)
            ->assertCreated()
            ->assertJson([
                'data' => [
                    'owner_id' => $this->user->id,
                    'slug' => 'my-listing',
                    'image_url' => filled($image) ? '/storage/1/my-listing.jpg' : null,
                ],
            ])
            ->assertJsonStructureMissing([
                'data' => [
                    'special_prices',
                ],
            ]);

        if (filled($image)) {
            Storage::disk('media')->assertExists("1/my-listing.jpg");
        }
    }

    public function test_update()
    {
        Storage::fake('media');

        $listing = $this->createMyListing();

        $payload = [
            // NB: the owner_id will never be changed.
            'owner_id' => User::factory()->create()->id,
            'name' => 'my new listing',
            'description' => $this->faker->randomElement([null, 'my listing description']),
            'adults' => 3,
            'children' => 2,
            'is_pets_allowed' => true,
            'base_price' => 16,
            'cleaning_fee' => 11,
            // NB: when the image attribute is filled, the new image will be uploaded and overwrite the old one
            'image' => $image = $this->faker->randomElement([null, UploadedFile::fake()->image('my-listing-2.jpg', 2, 2)]),
            'weekly_discount' => 0.1,
            'monthly_discount' => 0.2,
        ];

        $this->authenticated()
            ->json('put', "$this->endpoint/$listing->id", $payload)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'owner_id' => $this->user->id,
                    'name' => 'my new listing',
                    'slug' => 'my-new-listing',
                    'image_url' => filled($image) ? '/storage/2/my-listing-2.jpg' : '/storage/1/my-listing.jpg',
                    'adults' => 3,
                ],
            ])
            ->assertJsonStructureMissing([
                'data' => [
                    'special_prices',
                ],
            ]);

        filled($image) ? Storage::disk('media')->assertExists('2/my-listing-2.jpg') : Storage::disk('media')->assertExists('1/my-listing.jpg');
    }

    public function test_delete()
    {
        Storage::fake('media');

        $listing = $this->createMyListing();

        $this->authenticated()
            ->json('delete', "$this->endpoint/{$listing->id}")
            ->assertOk()
            ->assertJson(['id' => $listing->id]);

        $this->assertSoftDeleted($listing);

        Storage::disk('media')->assertExists('1/my-listing.jpg');
    }
}
