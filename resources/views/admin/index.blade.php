@extends('layouts.admin')

@section('content')
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome {{ auth()->user()->name }}</h3>
                        <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have
                            <span class="text-primary">3 unread alerts!</span>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Today’s Bookings</p>
                                <p class="fs-30 mb-2">4006</p>
                                <p>10.00% (30 days)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Bookings</p>
                                <p class="fs-30 mb-2">61344</p>
                                <p>22.00% (30 days)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Number of Meetings</p>
                                <p class="fs-30 mb-2">34040</p>
                                <p>2.00% (30 days)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Number of Clients</p>
                                <p class="fs-30 mb-2">47033</p>
                                <p>0.22% (30 days)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Charts</p>
                        <div class="charts-data">
                            <div class="mt-3">
                                <p class="mb-0">Data 1</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="progress progress-md flex-grow-1 mr-4">
                                        <div class="progress-bar bg-inf0" role="progressbar" style="width: 95%"
                                            aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mb-0">5k</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="mb-0">Data 2</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="progress progress-md flex-grow-1 mr-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 35%"
                                            aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mb-0">1k</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="mb-0">Data 3</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="progress progress-md flex-grow-1 mr-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 48%"
                                            aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mb-0">992</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="mb-0">Data 4</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="progress progress-md flex-grow-1 mr-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mb-0">687</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Order Details</p>
                        <p class="font-weight-500">The total number of sessions within the date range. It
                            is the period time a user is actively engaged with your website, page or app,
                            etc</p>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="mr-5 mt-3">
                                <p class="text-muted">Order value</p>
                                <h3 class="text-primary fs-30 font-weight-medium">12.3k</h3>
                            </div>
                            <div class="mr-5 mt-3">
                                <p class="text-muted">Orders</p>
                                <h3 class="text-primary fs-30 font-weight-medium">14k</h3>
                            </div>
                            <div class="mr-5 mt-3">
                                <p class="text-muted">Users</p>
                                <h3 class="text-primary fs-30 font-weight-medium">71.56%</h3>
                            </div>
                            <div class="mt-3">
                                <p class="text-muted">Downloads</p>
                                <h3 class="text-primary fs-30 font-weight-medium">34040</h3>
                            </div>
                        </div>
                        <canvas id="order-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-title">Sales Report</p>
                            <a href="#" class="text-info">View all</a>
                        </div>
                        <p class="font-weight-500">The total number of sessions within the date range. It
                            is the period time a user is actively engaged with your website, page or app,
                            etc</p>
                        <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
                        <canvas id="sales-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')

@endsection
