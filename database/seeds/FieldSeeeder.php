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
                'color'         => '#cb6962',
                'area_name'     => "pedan",
                'description'   => "zona merah",
                'event_date'    => "2020-04-14",
                'coordinates'   => "[[[110.55335998535156,-7.64702580352807],[110.63850402832033,-7.72664140534998],[110.72158813476562,-7.661997397255226],[110.60005187988283,-7.600746651831765],[110.55335998535156,-7.64702580352807]]]",
                'field_id'      => 1
            ],
            [
                'color'         => '#e2bda1',
                'area_name'     => "bayat",
                'description'   => "zona kuning",
                'event_date'    => "2020-04-07",
                'coordinates'   => "[[[110.53619384765628,-7.652470080257459],[110.61859130859375,-7.725960993491655],[110.72296142578125,-7.663358425148971],[110.61035156250001,-7.591898598013398],[110.53619384765628,-7.652470080257459]]]",
                'field_id'      => 2
            ]
        ];

        foreach ($fields as $item) {
            $db_field = Field::where('area_name','==',$item['area_name'])->first();
            if(empty($db_field)){
                Field::create(
                    [
                        'color'         => $item['color'], 
                        'area_name'     => $item['area_name'],
                        'description'   => $item['description'],
                        'event_date'    => $item['event_date']
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
