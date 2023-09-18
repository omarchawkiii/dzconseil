<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
{
    public function rules(): array
    {


        // TODO: Implement request validation
        //      NB: The validation rules for any field should stop after the first validation failure

        return [
            'name'             => 'required|string|max:255'     ,    //this attribute should be a required string with max length of 255 chars
            'description'      => 'max:65535'            ,   //this attribute should be an optional string with max length of 65535 chars
            'adults'           => 'required|integer|between:1,4',    // this attribute should be a required integer value between 1 and 4
            'children'         => 'required|integer|between:0,5',    //this attribute should be a required integer value between 0 and 5
            'is_pets_allowed'  => 'required|boolean'            ,    //this attribute should be a required boolean
            'base_price'       => 'required|numeric'            ,    //this attribute should be a required floating point number (ex: 10.5)
            'cleaning_fee'     => 'required|numeric'            ,    //this attribute should be a required floating point number (ex: 10.5)
            'image_url'            => ''                            ,    //this attribute should be an optional image (NOT A LINK)
            'weekly_discount'  => 'required|numeric|between:0,1',    //this attribute should be a required number between 0 and 1 (ex: 0.2)
            'monthly_discount' => 'required|numeric|between:0,1',    //this attribute should be a required number between 0 and 1 (ex: 0.2)
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
