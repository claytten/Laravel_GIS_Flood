<?php

namespace App\Models\Maps\Fields\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Models\Maps\Fields\Field;
use App\Models\Maps\Geometries\Geometry;
use Illuminate\Support\Collection;

interface FieldRepositoryInterface extends BaseRepositoryInterface
{
    public function listFields(): Collection;

    public function createField(array $params) : Field;

    public function findFieldById(int $id) : Field;

    public function updateField(array $params): bool;

    public function deleteField() : bool;
}
