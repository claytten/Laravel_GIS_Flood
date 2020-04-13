<?php

namespace App\Http\Controllers\Front;

use App\Models\Maps\Fields\Repositories\Interfaces\FieldRepositoryInterface;

use App\Http\Controllers\Controller;
use App\Models\Maps\Fields\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * @var FieldRepositoryInterface
     */
    private $fieldRepo;

    /**
     * Map Controller Constructor
     *
     * @param FieldRepositoryInterface $fieldRepository
     * @return void
     */
    public function __construct(
        FieldRepositoryInterface $fieldRepository
    )
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
        return view('front.homepage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function maps()
    {
        $fields = 0;
        return view('front.maps',compact('fields'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mapsApi(Request $request)
    {
        if($request->id == 0 ) {
            $fields = $this->fieldRepo->listFields()->sortBy('name');
        } else {
            $fields = Field::where('id',$request->id)->get();
        }
      
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
                "status"  => $item->status
                )
            ),
            "geometry" => array(
                "type" => $item->geometries->geo_type,
                "coordinates" => json_decode($item->geometries->coordinates)
            )
            );
            
            $field_response["features"][] = $temp;
            
        }
    
        return response()->json([
            'code'    => 200,
            'status'  => 'success',
            'data'    => $field_response
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $fields     = $this->fieldRepo->listFields()->sortBy('name');
        $tArea      = $fields->count('id');
        $tStatusA   = $fields->where('status','aman')->count('id');
        $tStatusS   = $fields->where('status','sedang')->count('id');
        $tStatusR   = $fields->where('status','rawan')->count('id');
        $tCivil     = $fields->sum('civilians');
        return view('front.data',[
            'fields'    => $fields,
            'tArea'     => $tArea,
            'tStatusA'  => $tStatusA,
            'tStatusS'  => $tStatusS,
            'tStatusR'  => $tStatusR,
            'tCivil'    => $tCivil
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataDetail($id)
    {
        $getEnc = Crypt::decrypt($id);
        $getId = $this->fieldRepo->findFieldById($getEnc);
        $fields = $getId->id;

        return view('front.maps',compact('fields'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        return view('front.about');
    }
}
