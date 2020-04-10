<?php

namespace App\Models\Maps\Fields\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Models\Maps\Fields\Field;
use App\Models\Maps\Fields\Exceptions\FieldNotFoundException;
use App\Models\Maps\Fields\Repositories\Interfaces\FieldRepositoryInterface;
use App\Models\Maps\Geometries\Geometry;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;

class FieldRepository extends BaseRepository implements FieldRepositoryInterface
{
    /**
     * FieldRepository constructor.
     *
     * @param Field $field
     */
    public function __construct(Field $field)
    {
        parent::__construct($field);
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
    public function listFields(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
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
            $field = $this->create([
                "color"         => $setColor,
                "area_name"     => $data['aName'],
                "event_start"   => $data['eStart'],
                "event_end"     => $data['eEnd'],
                "water_level"   => $data['wLevel'],
                "flood_type"    => $data['fType'],
                "damage"        => $data['damage'],
                "civilians"     => $data['civil'],
                "description"   => $data['desc'],
                "status"        => $data['status']
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
            return $this->findOneOrFail($id);
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
        $filtered = collect($data)->all();
        return $this->model->where('id', $this->model->id)->update($filtered);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteField() : bool
    {
        return $this->delete();
    }
}
