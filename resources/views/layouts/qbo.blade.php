<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hospitality College Management') - QBO Style</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom Styles -->
    <style>
        /* QuickBooks Inspired Custom Styles */
        .sidebar-collapsed {
            width: 4rem !important;
        }
        
        .sidebar-collapsed .sidebar-text {
            display: none;
        }
        
        .sidebar-collapsed .sidebar-icon {
            margin: 0 auto;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .qbo-green {
            background: linear-gradient(135deg, #2ECC71 0%, #27AE60 100%);
        }
        
        .qbo-blue {
            background: linear-gradient(135deg, #3498DB 0%, #2980B9 100%);
        }
        
        .qbo-orange {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }
        
        .hidden {
            display: none;
        }
        
        .qbo-red {
            background: linear-gradient(135deg, #E74C3C 0%, #C0392B 100%);
        }
        
        .sidebar-item:hover {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
        }
        
        .sidebar-item.active {
            background-color: #e3f2fd;
            border-left: 4px solid #3498db;
            color: #1976d2;
        }
        
        .content-wrapper {
            transition: margin-left 0.3s ease;
        }
        
        .content-wrapper.sidebar-open {
            margin-left: 16rem;
        }
        
        .content-wrapper.sidebar-collapsed {
            margin-left: 4rem;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .content-wrapper {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        @include('components.qbo-sidebar')
        
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Navigation -->
            @include('components.qbo-navbar')
            
            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 content-wrapper sidebar-open" id="contentWrapper">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
            
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" id="sidebarOverlay"></div>
    
    <!-- Scripts -->
    <script>
        // Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('contentWrapper');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
            
            // Desktop sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('sidebar-collapsed');
                    contentWrapper.classList.toggle('sidebar-collapsed');
                    contentWrapper.classList.toggle('sidebar-open');
                });
            }
            
            // Mobile sidebar toggle
            if (mobileSidebarToggle) {
                mobileSidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                    sidebarOverlay.classList.toggle('hidden');
                });
            }
            
            // Close mobile sidebar on overlay click
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    sidebarOverlay.classList.add('hidden');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
