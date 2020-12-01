<?php

namespace App\Models\Maps\Fields\Repositories;

use App\Models\Maps\Fields\Field;
use App\Models\Maps\Fields\Exceptions\FieldNotFoundException;
use App\Models\Maps\Fields\Repositories\Interfaces\FieldRepositoryInterface;
use App\Models\Tools\UploadableTrait;
use App\Models\Maps\Geometries\Geometry;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class FieldRepository implements FieldRepositoryInterface
{
    use UploadableTrait;
    /**
     * FieldRepository constructor.
     *
     * @param Field $field
     */
    public function __construct(Field $field)
    {
        $this->model = $field;
    }

    /**
     * List all the Fields
     *
     * @param string $order
     * @param string $sort
     *
     * @return Collection
     */
    public function listFields(string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * Create the Field
     *
     * @param array $data
     *
     * @return Field
     */
    public function createField(array $data): Field
    {
        try {
            if($data['status'] == "aman") {
                $setColor = "#4caf50";
            } else if($data['status'] == "sedang") {
                $setColor = "#fafb00";
            } else {
                $setColor = "#f3000e";
            }
            $field = $this->model->create([
                "color"         => $setColor,
                "area_name"     => $data['aName'],
                "event_start"   => $data['eStart'],
                "event_end"     => $data['eEnd'],
                "water_level"   => $data['wLevel'],
                "flood_type"    => $data['fType'],
                "damage"        => $data['damage'],
                "civilians"     => $data['civil'],
                "description"   => $data['desc'],
                "status"        => $data['status'],
                "image"         => $data['images']
            ]);
            $this->createGeo($field->id,$data['coordinates']);
            return $field;
        } catch (QueryException $e) {
            throw new FieldNotFoundException($e);
        }
    }

    /**
     * Create the Geometries
     *
     * @param array $data
     *
     *
     */
    private function createGeo($id, $coordinates) {

        $geometry = new Geometry();
        $geometry->geo_type     = "Polygon";
        $geometry->coordinates  = $coordinates;
        $geometry->field_id     = $id;
        $geometry->save();
    }
    /**
     * Find the field by id
     *
     * @param int $id
     *
     * @return Field
     */
    public function findFieldById(int $id): Field
    {
        try {
            return $this->model->where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new FieldNotFoundException;
        }
    }

    /**
     * Update field
     *
     * @param array $params
     *
     * @return bool
     */
    public function updateField(array $data): bool
    {
        return $this->model->where('id', $this->model->id)->update([
            "color"         => $data['color'],
            "area_name"     => $data['aName'],
            "event_start"   => $data['eStart'],
            "event_end"     => $data['eEnd'],
            "water_level"   => $data['wLevel'],
            "flood_type"    => $data['fType'],
            "damage"        => $data['damage'],
            "civilians"     => $data['civil'],
            "description"   => $data['desc'],
            "status"        => $data['status'],
            "image"         => $data['images']
        ]);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteField() : bool
    {
        return $this->model->delete();
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function saveCoverImage(UploadedFile $file) : string
    {
        return $file->store('fields', ['disk' => 'public']);
    }

    /**
     * Destroye File on Storage
     *
     * @param string $get_data
     *
     */
    public function deleteFile(string $get_data)
    {
        return File::delete("storage/{$get_data}");
    }
}
