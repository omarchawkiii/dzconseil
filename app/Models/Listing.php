<?php

namespace App\Models;

use App\Concerns\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Listing extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use HasUUID;
    use HasSlug;
    use InteractsWithMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'listings';

    /**
     * model primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['owner_id' , 'name' , 'slug' , 'description' , 'adults' , 'children' , 'is_pets_allowed' , 'base_price' , 'cleaning_fee' ,'weekly_discount' , 'monthly_discount' ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    protected static function booted()
    {
        static::creating(function (self $listing) {
            $listing->owner_id ??= Auth::id();
        });
    }

    /*
     * ------------------------------------------
     * Relationships
     * ------------------------------------------
     */
    public function owner()
    {
        // TODO: implement this relationship
        //      NB: set the method type hint
        return $this->beLongsTo(User::class) ;
    }

    public function specialPrices()
    {
        return $this->hasMany(SpecialPrice::class) ;
    }

    /*
     * ------------------------------------------
     * Accessors
     * ------------------------------------------
     */
    public function getImageUrlAttribute()
    {
        // TODO: implement this accessor to return the image url using media library collection (ex: storage/1/my-listing.jpg)
        //      Docs: https://spatie.be/docs/laravel-medialibrary/v10/basic-usage/retrieving-media
        //      NB: - the listing may not have an image
        //          - set the method type hint
        //return 'test' ;
        //return $this?->getFirstMediaUrl() ?? null;
        return $this->getFirstMediaUrl('default');

    }

    /*
     * ------------------------------------------
     * Functions
     * ------------------------------------------
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->singleFile();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // TODO: implement this method
        public function calculateCost(Carbon $checkin, Carbon $checkout): array
        {


            $cost['nights_count'] = $checkin->diff($checkout)->days;
            $cost['nights_cost'] = $cost['nights_count'] * $this->base_price ;
            $cost['discount'] =$this->calculateDiscount( $cost['nights_count'] , $cost['nights_cost'] );
            $cost['cleaning_fee'] = $this->cleaning_fee ;
            $cost['total'] = $cost['nights_cost'] + $cost['discount'] + $cost['cleaning_fee'];

            return $cost;



        }

    // TODO: complete the implementation of this method
    //      NB: - the return value must always be negative
    //          - you should implement the unit test for this method without changing the method visibility
    private function calculateDiscount(int $nights_count, float $nights_cost): float
    {
        return match (true) {
            // case 1: if the number of nights is less than 7, no discount will be applied
            $nights_count < 7 => 0,

            // case 2: if the number of nights is greater than or equal to 7 and lower than 28, apply the weekly discount percentage
            $nights_count>=7 && $nights_count <28 =>( $nights_cost * $this->weekly_discount) * -1 ,

            // case 3: if the number of nights is greater than or equal to 28, apply the monthly discount percentage
            $nights_count>=28 => ($nights_cost * $this->monthly_discount ) * -1 ,
        };
    }
}
