@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>Admins</div>
                        <div class="h3">5</div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-table me-1"></i>
            Recent Activities
        </div>
        <div class="card-body">
            <p>Welcome to the MDC ProCollege System Admin Dashboard. This is where you'll manage all aspects of the college system.</p>
            <p>Use the sidebar navigation to access different sections of the admin panel.</p>
        </div>
    </div>
@endsection 