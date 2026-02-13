<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { overflow-x: hidden; }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #1a1a1a 0%, #0d0d0d 100%);
            padding: 0;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0,0,0,0.3);
        }
        .sidebar-header {
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255,181,0,0.2);
        }
        .sidebar-brand {
            color: #FFB500;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 1px;
        }
        .sidebar-menu {
            padding: 20px 0;
        }
        .sidebar-item {
            padding: 15px 25px;
            color: #aaa;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .sidebar-item:hover {
            background: rgba(255,181,0,0.1);
            color: #FFB500;
            border-left-color: #FFB500;
        }
        .sidebar-item.active {
            background: rgba(255,181,0,0.15);
            color: #FFB500;
            border-left-color: #FFB500;
        }
        .sidebar-item i {
            font-size: 20px;
            width: 24px;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            background: #f8f9fa;
        }
        .logout-btn {
            position: absolute;
            bottom: 30px;
            left: 25px;
            right: 25px;
        }
        .logout-btn button {
            width: 100%;
            background: rgba(220,53,69,0.1);
            border: 1px solid rgba(220,53,69,0.3);
            color: #dc3545;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .logout-btn button:hover {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">GLORI ADMIN</a>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.landing-images.index') }}" class="sidebar-item {{ request()->routeIs('admin.landing-images.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i>
                <span>Landing Images</span>
            </a>
            <a href="{{ route('admin.client-logos.index') }}" class="sidebar-item {{ request()->routeIs('admin.client-logos.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Client Logos</span>
            </a>
            <a href="{{ route('admin.services.index') }}" class="sidebar-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Services</span>
            </a>
            <a href="{{ route('admin.contact-messages.index') }}" class="sidebar-item {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i>
                <span>Contact Messages</span>
            </a>
        </div>
        
        <div class="logout-btn">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
