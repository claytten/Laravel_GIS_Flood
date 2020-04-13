<?php

namespace App\Http\Controllers\Admin\Maps;

use App\Models\Maps\Fields\Repositories\Interfaces\FieldRepositoryInterface;

use App\Http\Controllers\Controller;
use App\Models\Maps\Fields\reportField;
use Maatwebsite\Excel\Facades\Excel;

class MapController extends Controller
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
        $getFields = $fields = $this->fieldRepo->listFields()->sortBy('name');
        return view('admin.maps.index',compact('getFields'));

    }

    /**
     * Reporting excel
     *
     * @return \Illuminate\Http\Response
     */
    public function reportExcel()
    {
        $fileName = 'laporan_daerah_'.date('Y-m-d_H-i-s').'.csv';
        return Excel::download(new reportField, $fileName);
    }
}
