<?php

use Illuminate\Database\Seeder;
use App\Models\Maps\Fields\Field;
use App\Models\Maps\Geometries\Geometry;

class FieldSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = [
            [
                'color'         => '#4caf50',
                'area_name'     => "pedan",
                'event_start'   => '2020-04-05',
                'event_end'     => '2020-04-05',
                'water_level'   => "0",
                'flood_type'    => 'air',
                'damage'        => "0",
                'civilians'     => "0",
                'status'        => "aman",
                'description'   => "nihil",
                'coordinates'   => "[[[110.55335998535156,-7.64702580352807],[110.63850402832033,-7.72664140534998],[110.72158813476562,-7.661997397255226],[110.60005187988283,-7.600746651831765],[110.55335998535156,-7.64702580352807]]]",
                'field_id'      => 1,
                'image'         => null
            ],
            [
                'color'         => '#fafb00',
                'area_name'     => "ceper",
                'event_start'   => '2020-04-05',
                'event_end'     => '2020-04-06',
                'water_level'   => "0",
                'flood_type'    => 'air',
                'damage'        => "0",
                'civilians'     => "0",
                'description'   => "nihil",
                'status'        => "sedang",
                'coordinates'   => "[[[110.53619384765628,-7.652470080257459],[110.61859130859375,-7.725960993491655],[110.72296142578125,-7.663358425148971],[110.61035156250001,-7.591898598013398],[110.53619384765628,-7.652470080257459]]]",
                'field_id'      => 2,
                'image'         => null
            ]
        ];

        foreach ($fields as $item) {
            $db_field = Field::where('area_name','==',$item['area_name'])->first();
            if(empty($db_field)){
                Field::create(
                    [
                        "color"         => $item['color'],
                        "area_name"     => $item['area_name'],
                        "event_start"   => $item['event_start'],
                        "event_end"     => $item['event_end'],
                        "water_level"   => $item['water_level'],
                        "flood_type"    => $item['flood_type'],
                        "damage"        => $item['damage'],
                        "civilians"     => $item['civilians'],
                        "description"   => $item['description'],
                        "status"        => $item['status'],
                        "image"         => $item['image']
                    ]
                );
                Geometry::create(
                    [
                        'geo_type'      => "Polygon",
                        'coordinates'   => $item['coordinates'],
                        'field_id'      => $item['field_id']
                    ]
                );
            }
        }
        
    }
}
