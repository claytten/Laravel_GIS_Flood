<?php

namespace App\Models\Maps\Geometries;

use Illuminate\Database\Eloquent\Model;

class Geometry extends Model
{
    protected $table = 'geometries';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'geo_type',
        'coordinates',
        'field_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function fields()
    {
        return $this->belongsToMany('App\Models\Maps\Fields\Field', 'field_id');
    }
}
