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
     * @return Employee
     */
    public function createField(array $data): Field
    {
        try {
            return $this->create([
                "color"     => $data['color'],
                "area_name" => $data['area_name'],
                "crop"      => $data['crop'],
                "event_date"=> $data['event_date']
            ]);
        } catch (QueryException $e) {
            throw new FieldNotFoundException($e);
        }
    }

    /**
     * Find the field by id
     *
     * @param int $id
     *
     * @return Employee
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
    public function updateField(array $params): bool
    {
        if (isset($params['password'])) {
            // $params['password'] = Hash::make($params['password']);
        }

        return $this->update($params);
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