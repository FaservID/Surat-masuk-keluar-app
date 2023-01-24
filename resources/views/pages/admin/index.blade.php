@extends('pages.partials.main')
@section('title', 'Admin Home')


@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary display-6">Halo, {{auth()->user()->name}}! 🎉</h5>
                        <p class="mb-4">
                            {{\Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY');}}
                        </p>
                        <p class="fw-bold text-muted" style="font-size: 13px">
                            *) Laporan Hari Ini
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{asset('sneat/assets/img/illustrations/man-with-laptop-light.png')}}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{asset('sneat/assets/img/icons/unicons/chart-success.png')}}" alt="chart success" class="rounded" />
                            </div>

                        </div>
                        <span class="fw-semibold d-block mb-1">Surat Masuk</span>
                        <h3 class="card-title mb-2">{{$data['incomingLetter']}}</h3>
                        {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{asset('sneat/assets/img/icons/unicons/wallet-info.png')}}" alt="Credit Card" class="rounded" />
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Surat Keluar</span>
                        <h3 class="card-title mb-2">{{$data['outgoingLetter']}}</h3>
                        {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> --}}
                    </div>
                </div>
            </div>
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{asset('sneat/assets/img/icons/unicons/paypal.png')}}" alt="Credit Card" class="rounded" />
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Klasifikasi</span>
                        <h3 class="card-title mb-2">{{$data['klasifikasi']}}</h3>
                        {{-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> --}}
                    </div>
                </div>
            </div>
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{asset('sneat/assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Jumlah Pengguna</span>
                        <h3 class="card-title mb-2">{{$data['users']}}</h3>
                        {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 mb-4 order-0 card">
        <div id="canvas"></div>
        <script src="https://code.highcharts.com/highcharts.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chart = Highcharts.chart('canvas', {
                    chart: {
                        type: 'bar'
                    }
                    , title: {
                        text: 'Statistik Surat Masuk & Keluar'
                    }
                    , xAxis: {
                        categories: ['Surat Masuk', 'Surat Keluar']
                    }
                    , yAxis: {
                        title: {
                            text: 'Jumlah'
                        }
                    }
                    , series: [{
                        name: 'Surat Masuk'
                        , data: [ {!!json_encode($data['incomingLetter'])!!}]
                    }, {
                        name: 'Surat Keluar'
                        , data: [ {!!json_encode($data['outgoingLetter'])!!}]
                    }]
                });
            });

        </script>
    </div>
    @endsection


    @push('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    @endpush

    @push('custom-scripts')

    @endpush
