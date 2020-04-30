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
use App\Models\Tools\UploadableTrait;
use Illuminate\Http\UploadedFile;

class MapApiController extends Controller
{
  use UploadableTrait;
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
    public function store(Request $request)
    {
      if($request->has('id')) {
        $getField = $this->fieldRepo->findFieldById($request->id);

        if($request['status'] == "aman") {
            $setColor = "#4caf50";
        } else if($request['status'] == "sedang") {
            $setColor = "#fafb00";
        } else {
            $setColor = "#f3000e";
        }

        $updateField = new FieldRepository($getField);
        if ($request->hasFile('image') && $request->file('image') instanceof UploadedFile) {
          if(!empty($getField->image)) {
              $updateField->deleteFile($getField->image);
          }
          $request['images'] = $this->fieldRepo->saveCoverImage($request->file('image'));
        }
        $updateField->updateField(
          array_merge($request->all(), ['color' => $setColor])
        );

        $message = "Field Succesfully updated";

        return response()->json([
            'code'        => 200,
            'status'      => 'success',
            'icon'        => 'check',
            'status'      => 'green',
            'message'     => $message,
            'redirect_url'=> route('admin.view.index'),
            'data'        => $request->id
        ]);
      }

      if ($request->hasFile('image') && $request->file('image') instanceof UploadedFile) {
          $request['images'] = $this->fieldRepo->saveCoverImage($request->file('image'));
      }

      $this->fieldRepo->createField($request->all());
      $message = "Field Succesfully created";

      return response()->json([
          'code'        => 200,
          'status'      => 'success',
          'icon'        => 'check',
          'status'      => 'green',
          'message'     => $message,
          'redirect_url'=> route('admin.view.index'),
          'data'        => $request->all()
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
     * Remove the specified resource from database.
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
          if(!empty($field->image) ) {
            $getField->deleteFile($field->image);
          }
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
