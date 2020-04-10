<?php

namespace App\Models\Maps\Fields;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'field';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area_name',
        'color',
        'event_start',
        'event_end',
        'water_level',
        'flood_type',
        'damage',
        'civilians',
        'description',
        'status'
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function geometries()
    {
        return $this->belongsTo('App\Models\Maps\Geometries\Geometry', 'id');
    }
}
