<?php

namespace App\Http\Resources;

use App\Models\SpecialPrice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SpecialPrice */
class SpecialPriceResource extends JsonResource
{
    /**
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        // TODO: fill in the gaps

        return [
             'id'    => $this->id,
             'date'  => $this->date,
             'price' => $this->price,
        ];
    }
}
