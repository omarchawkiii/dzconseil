<?php

namespace App\Models;

use App\Concerns\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialPrice extends Model
{
    use HasFactory;
    use HasUUID;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'special_prices';

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
    protected $fillable = ['listing_id' , 'date' , 'price'];

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

    /*
     * ------------------------------------------
     * Relationships
     * ------------------------------------------
     */
    public function listing():hasOne
    {
        // TODO: implement this relationship
        //      NB: set the method type hint

        return $this->hasOne(Listing::class);
    }
}
