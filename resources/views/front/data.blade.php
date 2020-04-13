@extends('layouts.front.app',[
    'navbar'        => 'data',
    'second_title'  => 'Data'
])

@section('plugins_css')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/front/extras.1.1.0.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/front/shards-dashboards.1.1.0.min.css') }}" id="main-stylesheet" data-version="1.1.0">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/datatables.css') }}">
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
</style>
@endsection

@section('content_body')
<div class="slider-area ">
    <!-- Mobile Menu -->
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{asset('images/front/Industries_hero.jpg')}}">
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
<script type="text/javascript" src="{{ asset('plugins/datatable/datatables.js') }}"></script>
@endsection

@section('inline_js')
<script>
var datasTable = $("#dataTable").DataTable({
    order: [0, 'asc'],
    pageLength: 5,
    aLengthMenu:[5,10,15,25,50],
    columnDefs: [
        {
            targets: 8,
            orderable: false,
            searchable: false,
        }
    ],
    responsive: true
});
</script>
@endsection