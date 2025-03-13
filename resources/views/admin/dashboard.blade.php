@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-primary">Export</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <i class="bi bi-calendar3"></i>
                This week
            </button>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Admins</h6>
                            <div class="h2 mb-0">5</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-primary bg-opacity-75">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Colleges</h6>
                            <div class="h2 mb-0">12</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-building-fill"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-success bg-opacity-75">
                    <a class="small text-white stretched-link" href="{{ route('admin.colleges.index') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Payments</h6>
                            <div class="h2 mb-0">34</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-warning bg-opacity-75">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Receipts</h6>
                            <div class="h2 mb-0">64</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-info bg-opacity-75">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Activities Card -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-activity me-1"></i>
                        Recent Activities
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <p class="lead">Welcome to the MDC ProCollege System Admin Dashboard</p>
                    <p>This is where you'll manage all aspects of the Model Degree Colleges (MDCs) & Professional College Bill Receipt and Payment Record-Keeping System.</p>
                    <p>Use the sidebar navigation to access different sections of the admin panel.</p>
                    
                    <div class="list-group mt-4">
                        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="bi bi-person-plus text-white"></i>
                            </div>
                            <div class="d-flex gap-2 w-100 justify-content-between">
                                <div>
                                    <h6 class="mb-0">New college added</h6>
                                    <p class="mb-0 opacity-75">Government College University was added to the system</p>
                                </div>
                                <small class="opacity-50 text-nowrap">3 days ago</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="bi bi-cash text-white"></i>
                            </div>
                            <div class="d-flex gap-2 w-100 justify-content-between">
                                <div>
                                    <h6 class="mb-0">Payment recorded</h6>
                                    <p class="mb-0 opacity-75">Payment of Rs. 250,000 received from Punjab College</p>
                                </div>
                                <small class="opacity-50 text-nowrap">1 week ago</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Links Card -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-lightning-charge me-1"></i>
                    Quick Links
                </div>
                <div class="card-body pb-0">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-plus-circle me-2 text-success"></i>
                            Add New College
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-receipt me-2 text-primary"></i>
                            Record New Payment
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-file-earmark-text me-2 text-warning"></i>
                            Generate Reports
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-gear me-2 text-secondary"></i>
                            System Settings
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <div class="small text-muted mt-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-2 rounded-circle bg-success" style="width: 8px; height: 8px;"></div>
                            System Status: Online
                        </div>
                        <div>Last updated: Today at 10:30 AM</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 