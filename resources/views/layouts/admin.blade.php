@extends('layouts.app')

@push('styles')
    <!-- Admin styles -->
    <style>
        .admin-dashboard {
            display: flex;
            min-height: 100vh;
            margin-top: -10px; /* Offset the main padding */
            background-color: #f4f6f9;
            padding-bottom: 20px; /* Add padding at bottom */
        }

        .side-nav {
            width: 250px;
            background-color: #2c3e50;
            padding: 20px;
            color: white;
            position: fixed;
            height: 100%; /* Make sidebar extend full height */
            top: 56px; /* Height of navbar */
            z-index: 1000;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f4f6f9;
            margin-left: 250px;
            min-height: calc(100vh - 66px); /* Account for top margin and bottom padding */
        }

        /* Navigation styles */
        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-links li {
            margin-bottom: 5px;
        }

        .nav-links li a {
            display: block;
            padding: 10px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .nav-links li a:hover,
        .nav-links li.active a {
            background-color: #F08CB0;
            color: white;
        }

        .nav-brand {
            font-size: 1.2rem;
            font-weight: 600;
            padding: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        /* Card styles */
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 15px 0 20px;
            background-color: #ffffff !important;
            border-radius: 8px;
        }

        .card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #edf2f9;
            padding: 1rem;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            background-color: #ffffff !important;
            color: #2c3e50;
            padding: 1.25rem;
            border-radius: 8px;
        }

        /* Table styles */
        .table {
            color: #2c3e50;
            background-color: #ffffff !important;
            margin-bottom: 0;
        }

        .table thead {
            background-color: #f8f9fa !important;
        }

        .table thead th {
            background-color: #f8f9fa !important;
            color: #2c3e50 !important;
            border-bottom: 2px solid #edf2f9;
            font-weight: 600;
            padding: 1rem;
            white-space: nowrap;
        }

        .table tbody tr {
            border-bottom: 1px solid #edf2f9;
            background-color: #ffffff !important;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa !important;
        }

        .table td {
            vertical-align: middle;
            color: #2c3e50 !important;
            padding: 1rem;
            background-color: #ffffff !important;
        }

        /* Recent Products card specific */
        .card .table {
            border-radius: 0 0 8px 8px;
        }

        .card .table td, 
        .card .table th {
            padding: 1rem;
            background-color: transparent;
        }

        .card .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #edf2f9;
        }

        .card .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Action buttons in table */
        .table .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 0.125rem;
        }

        .table .btn i {
            font-size: 0.875rem;
        }

        /* View All button */
        .btn-outline-primary {
            color: #F08CB0;
            border-color: #F08CB0;
            background-color: transparent;
        }

        .btn-outline-primary:hover {
            color: #ffffff;
            background-color: #F08CB0;
            border-color: #F08CB0;
        }

        /* Stat card styles */
        .stat-card {
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        /* Individual card colors - using direct row > col selector */
        .row > div:nth-child(1) .stat-card {
            background-color: #E8F5E9 !important; /* Pale green */
        }

        .row > div:nth-child(2) .stat-card {
            background-color: #E3F2FD !important; /* Pale blue */
        }

        .row > div:nth-child(3) .stat-card {
            background-color: #F3E5F5 !important; /* Pale purple */
        }

        .row > div:nth-child(4) .stat-card {
            background-color: #FFF3E0 !important; /* Pale orange */
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            opacity: 0.95;
        }

        .stat-card-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            font-size: 1.8rem;
            color: #F08CB0;
            padding: 15px;
            border-radius: 12px;
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card h3 {
            margin: 0;
            font-size: 2rem;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-card p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Make sure text in table is visible */
        .table td, 
        .table th,
        .card-header h5 {
            color: #2c3e50 !important;
        }

        /* Price column specific style */
        .table td:nth-child(3) {
            font-weight: 600;
            color: #F08CB0 !important;
        }

        /* Category column style */
        .table td:nth-child(2) {
            color: #6c757d !important;
        }

        /* Created date column style */
        .table td:nth-child(4) {
            color: #6c757d !important;
            font-size: 0.9rem;
        }

        /* Button styles */
        .btn-primary {
            background-color: #F08CB0;
            border-color: #F08CB0;
            color: white;
        }

        .btn-primary:hover {
            background-color: #e07a9e;
            border-color: #e07a9e;
            color: white;
        }

        /* Alert styles */
        .alert {
            background-color: white;
            border-left: 4px solid #F08CB0;
            color: #2c3e50;
        }

        /* Pagination styles */
        .pagination {
            background-color: transparent;
        }

        .page-link {
            color: #F08CB0;
            background-color: white;
            border-color: #edf2f9;
        }

        .page-item.active .page-link {
            background-color: #F08CB0;
            border-color: #F08CB0;
            color: white;
        }

        /* Header text */
        h4, h5, h6 {
            color: #2c3e50;
            font-weight: 600;
        }

        /* Override any conflicting styles */
        .admin-dashboard .card,
        .admin-dashboard .card-header,
        .admin-dashboard .card-body,
        .admin-dashboard .table,
        .admin-dashboard .table td,
        .admin-dashboard .table th {
            background-color: #ffffff !important;
        }

        .admin-dashboard .table thead th {
            background-color: #f8f9fa !important;
        }

        /* Make text visible */
        .admin-dashboard {
            color: #2c3e50;
        }

        .admin-dashboard h4,
        .admin-dashboard h5,
        .admin-dashboard h6,
        .admin-dashboard p,
        .admin-dashboard .table {
            color: #2c3e50 !important;
        }

        /* Header styles */
        .d-flex.justify-content-between.align-items-center.mb-4 {
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
<div class="admin-dashboard">
    @include('admin.partials.sidebar')
    
    <div class="main-content">
        @yield('admin-content')
    </div>
</div>
@endsection 