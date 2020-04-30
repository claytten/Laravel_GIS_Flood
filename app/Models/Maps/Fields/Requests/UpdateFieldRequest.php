<?php

namespace App\Models\Maps\Fields\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'area_name'      => ['required'],
            'event_start'    => ['required'],
            'water_level'    => ['required','numeric', 'min:0'],
            'flood_type'     => ['required'],
            'status'         => ['required']
        ];
    }
}
