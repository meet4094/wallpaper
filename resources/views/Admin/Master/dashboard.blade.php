@extends('Admin.template')
@section('main-section')
    <div class="page-header">
        <h2 class="main-content-title tx-24 mg-b-5">Dashboard</h2>
    </div>
    <div class="row row-sm">
        <div class="col-sm-6 col-xl-3 col-lg-6">
            <div class="card custom-card">
                <a href="api_call">
                    <div class="card-body dash1">
                        <div class="d-flex">
                            <p class="mb-1 tx-inverse">Api Call Count</p>
                            <div class="ml-auto">
                                <i class="fas fa-signal fs-20 text-info"></i>
                            </div>
                        </div>
                        <div>
                            {{-- <h3 class="dash-25 text-info">{{ $api_calls_data }}</h3> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-6">
            <div class="card custom-card">
                <a href="status_image_category">
                    <div class="card-body dash1">
                        <div class="d-flex">
                            <p class="mb-1 tx-inverse">Status Image Category Count</p>
                            <div class="ml-auto">
                                <i class="fas fa-chart-line fs-20 text-primary"></i>
                            </div>
                        </div>
                        <div>
                            {{-- <h3 class="dash-25 text-primary">{{ $languages_data }}</h3> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-6">
            <div class="card custom-card">
                <a href="status_image">
                    <div class="card-body dash1">
                        <div class="d-flex">
                            <p class="mb-1 tx-inverse">Status Image Count</p>
                            <div class="ml-auto">
                                <i class="fab fa-rev fs-20 text-secondary"></i>
                            </div>
                        </div>
                        <div>
                            {{-- <h3 class="dash-25 text-secondary">{{ $categories_data }}</h3> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-6">
            <div class="card custom-card">
                <a href="status_video_category">
                    <div class="card-body dash1">
                        <div class="d-flex">
                            <p class="mb-1 tx-inverse">Status Video Category Count</p>
                            <div class="ml-auto">
                                <i class="fas fa-dollar-sign fs-20 text-success"></i>
                            </div>
                        </div>
                        <div>
                            {{-- <h3 class="dash-25 text-success">{{ $questions_data }}</h3> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-6">
            <div class="card custom-card">
                <a href="status_video">
                    <div class="card-body dash1">
                        <div class="d-flex">
                            <p class="mb-1 tx-inverse">Status Video Count</p>
                            <div class="ml-auto">
                                <i class="fas fa-dollar-sign fs-20 text-success"></i>
                            </div>
                        </div>
                        <div>
                            {{-- <h3 class="dash-25 text-success">{{ $questions_data }}</h3> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
