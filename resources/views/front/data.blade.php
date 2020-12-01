@extends('layouts.front.app',[
    'navbar'        => 'data',
    'second_title'  => 'Data'
])

@section('plugins_css')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/front/extras.1.1.0.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/front/shards-dashboards.1.1.0.min.css') }}" id="main-stylesheet" data-version="1.1.0">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('inline_css')
<style>
.nav-link {
    font-size: 1rem;
}
.section-padding {
    padding-top:50px;
}
.fa-map {
    color:black;
}
#dataTable_wrapper {
    padding: 1.25rem !important;
};
</style>
@endsection

@section('content_body')
<div class="slider-area ">
    <!-- Mobile Menu -->
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{asset('img/front/Industries_hero.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>Data Banjir Terbaru</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="blog_area section-padding">
    <div class="container">
        <div class="row">
            @include('layouts.front.data_label',[
                'areas'     => $tArea,
                'safe'      => $tStatusA,
                'middle'    => $tStatusS,
                'danger'    => $tStatusR,
                'civil'     => $tCivil
            ])
            <div class="col-12 col-md-12 mt-4">
                <div class="card">
                    <div class="card-body p-0 pb-2">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Area</th>
                                    <th>Ketinggian Air</th>
                                    <th>Jenis Banjir</th>
                                    <th>Jumlah Korban</th>
                                    <th>Tanggal Mulai Kejadian</th>
                                    <th>Tanggal Berakhir Kejadian</th>
                                    <th>Status Area</th>
                                    <th>Lihat Peta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @foreach($fields as $item)
                                <tr id="rows_{{ $no }}">
                                    <td>{{ $no ++ }}</td>
                                    <td>{{ $item->area_name }}</td>
                                    <td>{{ $item->water_level}}</td>
                                    <td>{{ $item->flood_type }}</td>
                                    <td>{{ $item->civilians}}</td>
                                    <td>{{ $item->event_start }}</td>
                                    <td>
                                        @if($item->event_start == $item->event_end)
                                            Sekarang
                                        @else
                                            {{ $item->event_end}}
                                        @endif
                                    </td>
                                    <td>{{ $item->status}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('data.detail',Crypt::encrypt($item->id))}}"><i class="fas fa-map"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('plugins_js')
<script type="text/javascript" src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
@endsection

@section('inline_js')
<script>
const DatatableButtons = (function() {

    // Variables

    var $dtButtons = $('#dataTable');


    // Methods

    function init($this) {

    // For more options check out the Datatables Docs:
    // https://datatables.net/extensions/buttons/

    var buttons = ["copy", "print"];

    // Basic options. For more options check out the Datatables Docs:
    // https://datatables.net/manual/options

    var options = {
        order: [7, 'asc'],
        lengthChange: !1,
        dom: 'Bfrtip',
        buttons: buttons,
        // select: {
        // 	style: "multi"
        // },
        language: {
        paginate: {
            previous: "<i class='fas fa-angle-left'>",
            next: "<i class='fas fa-angle-right'>"
        }
        },
        columnDefs: [
        {
            targets: 8,
            orderable: false,
            searchable: false,
        }
    ],
    };

    // Init the datatable

    var table = $this.on( 'init.dt', function () {
        $('.dt-buttons .btn').removeClass('btn-secondary').addClass('btn-sm btn-default');
        }).DataTable(options)
    }


    // Events

    if ($dtButtons.length) {
        init($dtButtons);
        $('.dt-buttons').css({"position": "absolute", "display" : "block"});
    }

})();
</script>
@endsection