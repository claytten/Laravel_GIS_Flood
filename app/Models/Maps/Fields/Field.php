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
        'color',
        'area_name',
        'description',
        'event_date'
        
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
