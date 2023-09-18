<?php

namespace Tests\Unit\Models;

use App\Models\Listing;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ListingTest extends TestCase
{
    protected Listing $listing;

    protected function setUp(): void
    {
        parent::setUp();

        $this->listing = $this->createMyListing();
    }

    /*
    |---------------------------------
    |     calculateCost() method
    |---------------------------------
    |
    | NB :
    |    these unit tests must be passed without any change in their implementations
    |
    */
    public function test_calculateCost_method__case_1() // with base price and 0 discount
    {
        $checkin = Carbon::parse('2019-12-01');
        $checkout = Carbon::parse('2019-12-03');

        $cost = $this->listing->calculateCost($checkin, $checkout);

        $this->assertEquals([
            'nights_count' => 2,
            'nights_cost' => 28,
            'discount' => 0,
            'cleaning_fee' => 12,
            'total' => 40,
        ], $cost);
    }

    public function test_calculateCost_method__case_2() // with base price and weekly discount
    {
        $checkin = Carbon::parse('2019-12-01');
        $checkout = Carbon::parse('2019-12-10');

        $cost = $this->listing->calculateCost($checkin, $checkout);

        $this->assertEquals([
            'nights_count' => 9,
            'nights_cost' => 126,
            'discount' => -25.2,
            'cleaning_fee' => 12,
            'total' => 112.8,
        ], $cost);
    }

    public function test_calculateCost_method__case_3() // with base price and monthly discount
    {
        $checkin = Carbon::parse('2019-12-01');
        $checkout = Carbon::parse('2019-12-29');

        $cost = $this->listing->calculateCost($checkin, $checkout);

        $this->assertEquals([
            'nights_count' => 28,
            'nights_cost' => 392,
            'discount' => -156.8,
            'cleaning_fee' => 12,
            'total' => 247.2,
        ], $cost);
    }

    public function test_calculateCost_method__case_4() // with special prices and weekly discount
    {
        $this->listing->specialPrices()->createMany([
            [
                'date' => '2019-12-02',
                'price' => 8,
            ],
            [
                'date' => '2019-12-03',
                'price' => 7,
            ],
        ]);

        $checkin = Carbon::parse('2019-12-01');
        $checkout = Carbon::parse('2019-12-10');

        $cost = $this->listing->calculateCost($checkin, $checkout);

        $this->assertEquals([
            'nights_count' => 9,
            'nights_cost' => 113,
            'discount' => -22.6,
            'cleaning_fee' => 12,
            'total' => 102.4,
        ], $cost);
    }

    /*
    |---------------------------------
    |   calculateDiscount() method
    |---------------------------------
    |
    | TODO: implement unit test for the method calculateDiscount()
    |     NB :
    |       this method should be tested without changing it to public ou protected
    |
    */
    public function test_calculateDiscount_method__case_1() // nights_count < 7
    {
        // inputs
        $nights_count = 5;
        $nights_cost = 100;

        // output
        // $discount = ...

        // assertion must check that $discount is 0
    }

    public function test_calculateDiscount_method__case_2() // 7 <= nights_count < 28
    {
        // inputs
        $nights_count = 10;
        $nights_cost = 100;

        // output
        // $discount = ...

        // assertion must check that $discount is -20
    }

    public function test_calculateDiscount_method__case_3() // nights_count >= 28
    {
        // inputs
        $nights_count = 30;
        $nights_cost = 100;

        // output
        // $discount = ...

        // assertion must check that $discount is -40
    }
}
