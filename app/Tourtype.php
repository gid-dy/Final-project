<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tourtype extends Model
{
    protected $fillable = [
        'TourTypeName', 'TourTypeSize','SKU', 'PackagePrice', 'Package_id',
    ];
}
