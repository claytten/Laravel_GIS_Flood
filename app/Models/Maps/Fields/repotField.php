<?php

namespace App\Models\Maps\Fields;

use App\Models\Maps\Fields\Field;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class reportField implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('admin.maps.export_map', [
            'fields' => Field::all()
        ]);
    }
}
