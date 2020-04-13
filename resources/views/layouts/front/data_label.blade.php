<div class="col-12 col-md-3 pb-4">
    <div class="stats-small stats-small--1 card card-small">
        <div class="card-body p-0 d-flex">
            <div class="d-flex flex-column m-auto">
                <div class="stats-small__data text-center">
                    <span class="stats-small__label text-uppercase">Total daerah</span>
                    <h6 class="stats-small__value count my-3">{{ $areas }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-md-3 pb-4">
    <div class="stats-small stats-small--1 card card-small">
        <div class="card-body p-0 d-flex">
            <div class="d-flex flex-column m-auto">
                <div class="stats-small__data text-center">
                    <span class="stats-small__label text-uppercase">Daerah Status Aman</span>
                    <h6 class="stats-small__value count my-3">{{ $safe }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-md-3 pb-4">
    <div class="stats-small stats-small--1 card card-small">
        <div class="card-body p-0 d-flex">
            <div class="d-flex flex-column m-auto">
                <div class="stats-small__data text-center">
                    <span class="stats-small__label text-uppercase">Daerah Status Sedang</span>
                    <h6 class="stats-small__value count my-3">{{ $middle }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-md-3 pb-4">
    <div class="stats-small stats-small--1 card card-small">
        <div class="card-body p-0 d-flex">
            <div class="d-flex flex-column m-auto">
                <div class="stats-small__data text-center">
                    <span class="stats-small__label text-uppercase">Daerah Status Rawan</span>
                    <h6 class="stats-small__value count my-3">{{ $danger }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-md-12">
    <div class="row justify-content-md-center">
        <div class="col-12 col-md-3">
            <div class="stats-small stats-small--1 card card-small">
                <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                        <div class="stats-small__data text-center">
                            <span class="stats-small__label text-uppercase">Total Korban</span>
                            <h6 class="stats-small__value count my-3">{{ $civil }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>