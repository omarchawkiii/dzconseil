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

        return ListingResource::collection(Listing::get()) ;
    }

    public function show(Listing $listing)
    {

        return new ListingResource($listing::with('specialPrices')->first()) ;
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


        if($request->hasFile('image') && $request->image != null)
        {
            $listing->addMediaFromRequest('image')->toMediaCollection('default');
        }

        //$listing = $listing->get(["owner_id","slug","image_url"]) ;

        return response(['data' => new ListingResource($listing)], 201);

    }

    public function update(ListingRequest $request , Listing $listing)
    {

        $listing->update([
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


        if($request->hasFile('image') && $request->image != null )
        {

            $listing->addMediaFromRequest('image')->toMediaCollection('default');
        }



        return response(['data' => new ListingResource($listing)], 200);

     //   return response(['data' => new ListingResource($listing->get())], 201);


    }

    public function destroy(Listing $listing)
    {
        $listing_id = $listing->id;
        $listing->delete() ;
        return response(['id' => $listing_id], 200);
    }


}
