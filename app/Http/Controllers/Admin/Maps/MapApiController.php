<?php

namespace App\Http\Controllers\Admin\Maps;

use App\Models\Maps\Fields\Requests\CreateFieldRequest;
use App\Models\Maps\Fields\Requests\UpdateFieldRequest;
use App\Models\Maps\Fields\Repositories\FieldRepository;
use App\Models\Maps\Fields\Repositories\Interfaces\FieldRepositoryInterface;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Maps\Fields\Field;
use App\Models\Maps\Geometries\Geometry;

class MapApiController extends Controller
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
        // Spatie ACL
        $this->middleware('permission:maps-list');
        $this->middleware('permission:maps-create', ['only' => ['create','store']]);
        $this->middleware('permission:maps-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:maps-delete', ['only' => ['destroy']]);

        $this->fieldRepo = $fieldRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
              "areaName" => $item->area_name,
              "desc" => $item->description,
              "eventDate" => $item->event_date
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFieldRequest $request)
    {
        
        $field = new Field();
        $field->color       = $request->color;
        $field->area_name   = $request->areaName;
        $field->description = $request->desc;
        $field->event_date  = $request->eventDate;
        $field->save();

        $geometry = new Geometry();
        $geometry->geo_type     = "Polygon";
        $geometry->coordinates  = $request->coordinates;
        $geometry->field_id     = $field->id;
        $geometry->save();

        $message = "Field Succesfully created";
        
        return response()->json([
            'code'        => 200,
            'status'      => 'success',
            'icon'        => 'check',
            'status'      => 'green',
            'message'     => $message,
            'redirect_url'=> route('admin.view.index'),
            'data'        => null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getField = $this->fieldRepo->findFieldById($id);
        return response()->json([
          'code'    => 200,
          'status'  => 'success',
          'data'    => $getField
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFieldRequest $request, $id)
    {
      $getField = $this->fieldRepo->findFieldById($id);
      
      $getField->area_name   = $request->areaName;
      $getField->description = $request->desc;
      $getField->event_date  = $request->eventDate;
      $getField->save();

      $message = "Field Succesfully updated";
    
      return response()->json([
          'code'        => 200,
          'status'      => 'success',
          'icon'        => 'check',
          'status'      => 'green',
          'message'     => $message,
          'redirect_url'=> route('admin.view.index'),
          'data'        => null
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $field = $this->fieldRepo->findFieldById($id);

        if($request->user_action == "delete") {
          $message = 'Field successfully Deleted';
          $getField = new FieldRepository($field);
          $getField->deleteField();
        }

        return response()->json([
          'icon'        => 'check',
          'status'      => 'green',
          'message'     => $message,
          'redirect_url'=> route('admin.view.index')
      ]);
    }
}
