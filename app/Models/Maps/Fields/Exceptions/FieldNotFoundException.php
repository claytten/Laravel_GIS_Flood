<?php

namespace App\Models\Maps\Fields\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FieldNotFoundException extends NotFoundHttpException
{

    /**
     * FieldNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Field not found.');
    }
}
