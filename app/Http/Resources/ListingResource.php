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
    public static $wrap = 'data';
    public function toArray($request): array
    {
        // TODO: fill in the gaps

        return  parent::toArray($request);
        return [

        ];
    }
}
