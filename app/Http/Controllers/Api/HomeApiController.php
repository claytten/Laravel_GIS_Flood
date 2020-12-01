<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maps\Fields\Repositories\Interfaces\FieldRepositoryInterface;
use Illuminate\Support\Facades\URL;

class HomeApiController extends Controller
{

    /**
     * @var FieldRepositoryInterface
     */
    private $fieldRepo;

    /**
     * Fields Controller Constructor
     *
     * @param FieldRepositoryInterface $fieldRepository
     * @return void
     */
    public function __construct(FieldRepositoryInterface $fieldRepository)
    {
        $this->fieldRepo = $fieldRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'index' => route('api.index'),
            'maps'      => route('api.maps'),
            'source'    => 'https://github.com/claytten/sig_kab.git'      
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function maps()
    {
        $fields = $this->fieldRepo->listFields()->sortBy('name');

        $field_response = array(
            "type" => "FeatureCollection",
            "features" => array()
        );
        foreach($fields as $item){
            $temp = array(
            "type" => "Feature",
            "properties" => array(
                "color" => $item->color,
                "popupContent" => array(
                "aName"   => $item->area_name,
                "eStart"  => $item->event_start,
                "eEnd"    => $item->event_end,
                "wLevel"  => $item->water_level,
                "fType"   => $item->flood_type,
                "damage"  => $item->damage,
                "civil"   => $item->civilians,
                "desc"    => $item->description,
                "status"  => $item->status,
                "image"   => $item->image
                )
            ),
            "geometry" => array(
                "type" => $item->markers->geo_type,
                "coordinates" => json_decode($item->markers->coordinates)
            )
            );

            $field_response["features"][] = $temp;
        }

        return response()->json([
            'url'           => route('api.maps'),
            'data'          => $field_response
        ]);
    }
}
