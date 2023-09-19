<?php

namespace App\Http\Resources;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Listing */
class ListingResource extends JsonResource
{
    /**
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        // TODO: fill in the gaps

        return [
             'id'               =>$this->id ,
             'owner_id'         =>$this->owner_id ,
             'name'             =>$this->name ,
             'slug'             =>$this->slug ,
             'description'      =>$this->description ,
             'adults'           =>$this->adults ,
             'children'         =>$this->children ,
             'is_pets_allowed'  =>$this->is_pets_allowed ,
             'base_price'       =>$this->base_price ,
             'cleaning_fee'     =>$this->cleaning_fee ,
             'image_url'        =>$this->image_url ,
             'weekly_discount'  =>$this->weekly_discount ,
             'monthly_discount' =>$this->monthly_discount ,
             'special_prices'   =>$this->special_prices ,
        ];
    }
}


