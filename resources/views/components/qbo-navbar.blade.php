<!-- QuickBooks Style Top Navigation -->
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        
        <!-- Left Section - Mobile Menu Toggle & Search -->
        <div class="flex items-center space-x-4 flex-1">
            
            <!-- Mobile Menu Toggle -->
            <button id="mobileSidebarToggle" class="lg:hidden text-gray-500 hover:text-gray-700">
                <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- Global Search -->
            <div class="relative max-w-md flex-1">
                <input type="text" 
                       placeholder="Search transactions, customers, invoices..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            
        </div>
        
        <!-- Right Section - Layout Toggle, Create Button, Notifications, Profile -->
        <div class="flex items-center space-x-4">
            
            <!-- Layout Toggle Button -->
            <div class="relative">
                <button onclick="toggleLayout()" class="text-gray-500 hover:text-gray-700 transition-colors" title="Toggle Layout">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </button>
                
                <!-- Layout Toggle Dropdown -->
                <div id="layoutMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                    <div class="py-2">
                        <button onclick="setLayout('qbo')" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors w-full text-left">
                            <i class="fas fa-chart-line text-blue-600 mr-3 w-5"></i>
                            <div>
                                <p class="font-medium text-gray-900">QBO Layout</p>
                                <p class="text-xs text-gray-500">QuickBooks style</p>
                            </div>
                        </button>
                        <button onclick="setLayout('traditional')" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors w-full text-left">
                            <i class="fas fa-th-large text-gray-600 mr-3 w-5"></i>
                            <div>
                                <p class="font-medium text-gray-900">Traditional Layout</p>
                                <p class="text-xs text-gray-500">Original style</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Create (+) Button -->
            <div class="relative">
                <button onclick="toggleCreateMenu()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-plus"></i>
                    <span class="hidden sm:inline">Create</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                
                <!-- Create Dropdown Menu -->
                <div id="createMenu" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                    <div class="py-2">
                        <a href="{{ route('invoices.create') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-file-invoice-dollar text-blue-600 mr-3 w-5"></i>
                            <div>
                                <p class="font-medium text-gray-900">Invoice</p>
                                <p class="text-xs text-gray-500">Create new invoice</p>
                            </div>
                        </a>
                        <a href="{{ route('expenses.create') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-receipt text-orange-600 mr-3 w-5"></i>
                            <div>
                                <p class="font-medium text-gray-900">Expense</p>
                                <p class="text-xs text-gray-500">Record expense</p>
                            </div>
                        </a>
                        <a href="{{ route('customers.create') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-user-plus text-green-600 mr-3 w-5"></i>
                            <div>
                                <p class="font-medium text-gray-900">Customer</p>
                                <p class="text-xs text-gray-500">Add new customer</p>
                            </div>
                        </a>
                        <a href="{{ route('vendors.create') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-truck text-purple-600 mr-3 w-5"></i>
                            <div>
                                <p class="font-medium text-gray-900">Vendor</p>
                                <p class="text-xs text-gray-500">Add new vendor</p>
                            </div>
                        </a>
                        <a href="{{ route('payments.receive') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-money-bill-wave text-teal-600 mr-3 w-5"></i>
                            <div>
                                <p class="font-medium text-gray-900">Receive Payment</p>
                                <p class="text-xs text-gray-500">Record customer payment</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Notifications -->
            <div class="relative">
                <button onclick="toggleNotifications()" class="relative text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                </button>
                
                <!-- Notifications Dropdown -->
                <div id="notificationsDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900">Notifications</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <div class="p-4 hover:bg-gray-50 border-b border-gray-100 cursor-pointer">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">New invoice created</p>
                                    <p class="text-xs text-gray-500">Invoice #1234 for John Doe - $1,250.00</p>
                                    <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 hover:bg-gray-50 border-b border-gray-100 cursor-pointer">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Payment received</p>
                                    <p class="text-xs text-gray-500">Customer ABC paid $500.00</p>
                                    <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-orange-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Expense due tomorrow</p>
                                    <p class="text-xs text-gray-500">Office rent payment due</p>
                                    <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-t border-gray-200">
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all notifications</a>
                    </div>
                </div>
            </div>
            
            <!-- User Profile Dropdown -->
            <div class="relative">
                <button onclick="toggleProfileMenu()" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 transition-colors">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <span class="hidden md:block text-sm font-medium">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                
                <!-- Profile Dropdown -->
                <div id="profileMenu" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                    <div class="p-4 border-b border-gray-200">
                        <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="py-2">
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-user text-gray-600 mr-3 w-5"></i>
                            <span class="text-gray-700">My Profile</span>
                        </a>
                        <a href="{{ route('settings.company') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-cog text-gray-600 mr-3 w-5"></i>
                            <span class="text-gray-700">Settings</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-question-circle text-gray-600 mr-3 w-5"></i>
                            <span class="text-gray-700">Help & Support</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 hover:bg-gray-50 transition-colors text-left">
                                <i class="fas fa-sign-out-alt text-red-600 mr-3 w-5"></i>
                                <span class="text-red-600">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</header>

<script>
function toggleCreateMenu() {
    const menu = document.getElementById('createMenu');
    const notifications = document.getElementById('notificationsDropdown');
    const profile = document.getElementById('profileMenu');
    const layout = document.getElementById('layoutMenu');
    
    notifications.classList.add('hidden');
    profile.classList.add('hidden');
    layout.classList.add('hidden');
    menu.classList.toggle('hidden');
}

function toggleNotifications() {
    const notifications = document.getElementById('notificationsDropdown');
    const menu = document.getElementById('createMenu');
    const profile = document.getElementById('profileMenu');
    const layout = document.getElementById('layoutMenu');
    
    menu.classList.add('hidden');
    profile.classList.add('hidden');
    layout.classList.add('hidden');
    notifications.classList.toggle('hidden');
}

function toggleProfileMenu() {
    const profile = document.getElementById('profileMenu');
    const menu = document.getElementById('createMenu');
    const notifications = document.getElementById('notificationsDropdown');
    const layout = document.getElementById('layoutMenu');
    
    menu.classList.add('hidden');
    notifications.classList.add('hidden');
    layout.classList.add('hidden');
    profile.classList.toggle('hidden');
}

function toggleLayout() {
    const layout = document.getElementById('layoutMenu');
    const menu = document.getElementById('createMenu');
    const notifications = document.getElementById('notificationsDropdown');
    const profile = document.getElementById('profileMenu');
    
    menu.classList.add('hidden');
    notifications.classList.add('hidden');
    profile.classList.add('hidden');
    layout.classList.toggle('hidden');
}

function setLayout(layoutType) {
    fetch('/layout/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            qbo: layoutType === 'qbo'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show notification
            showNotification(data.message, 'success');
            // Reload page to apply new layout
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error toggling layout:', error);
        showNotification('Error switching layout', 'error');
    });
    
    // Close layout menu
    document.getElementById('layoutMenu').classList.add('hidden');
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const createMenu = document.getElementById('createMenu');
    const notifications = document.getElementById('notificationsDropdown');
    const profileMenu = document.getElementById('profileMenu');
    const layoutMenu = document.getElementById('layoutMenu');
    
    if (!event.target.closest('#createMenu') && !event.target.closest('button[onclick="toggleCreateMenu()"]')) {
        createMenu.classList.add('hidden');
    }
    
    if (!event.target.closest('#notificationsDropdown') && !event.target.closest('button[onclick="toggleNotifications()"]')) {
        notifications.classList.add('hidden');
    }
    
    if (!event.target.closest('#profileMenu') && !event.target.closest('button[onclick="toggleProfileMenu()"]')) {
        profileMenu.classList.add('hidden');
    }
    
    if (!event.target.closest('#layoutMenu') && !event.target.closest('button[onclick="toggleLayout()"]')) {
        layoutMenu.classList.add('hidden');
    }
});
</script>
