<?php

namespace App\Http\Controllers;


// TODO: Implement the controller and its methods
//      NB: don't forget to set the return type for each method !


use App\Models\Listing ;

use App\Http\Requests\ListingRequest ;
use App\Http\Resources\ListingResource ;


class ListingsController
{

    public function index()
    {

        return response()->json(Listing::with('owner')->get()) ;
    }

    public function show(Listing $listing)
    {
        return ListingResource::collection($listing::with('specialPrices')->get()) ;
    }

    public function store(ListingRequest $request)
    {



        $listing = Listing::create([
            'name'             => $request->name ,
            'description'      => $request->description ,
            'adults'           => $request->adults ,
            'children'         => $request->children ,
            'is_pets_allowed'  => $request->is_pets_allowed ,
            'base_price'       => $request->base_price ,
            'cleaning_fee'     => $request->cleaning_fee ,
            'weekly_discount'  => $request->weekly_discount ,
            'monthly_discount' => $request->monthly_discount ,
        ]) ;

        if($request->image_url)
        {
            info('testt22');
            $listing->addMedia($request->image_url)->toMediaCollection();
        }

        //$listing = $listing->get(["owner_id","slug"]) ;
        info('testt');
        info($listing->getFirstMediaUrl());

        return response(['data' => new ListingResource($listing)], 201);


    }

    public function update(ListingRequest $request , Listing $listing)
    {
        $listing = Listing::find($listing->id)->update([
            'name'             => $request->name ,
            'description'      => $request->description ,
            'adults'           => $request->adults ,
            'children'         => $request->children ,
            'is_pets_allowed'  => $request->is_pets_allowed ,
            'base_price'       => $request->base_price ,
            'cleaning_fee'     => $request->cleaning_fee ,
            'image'            => $request->image ,
            'weekly_discount'  => $request->weekly_discount ,
            'monthly_discount' => $request->monthly_discount ,
        ]) ;


     //   $listing = $listing->get(["owner_id","slug"]) ;
        return response(['data' => new ListingResource($listing)], 200);


    }

    public function destroy(Listing $listing)
    {
        $listing_id = $listing->id;
        $listing->delete() ;
        return response(['id' => $listing_id], 200);
    }


}
