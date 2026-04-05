<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Shop Management System - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fb;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            width: 260px;
            background: linear-gradient(135deg, #6e7fcb 50%, #764ba2 100%);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 20px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu-item {
            padding: 12px 25px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-menu-item:hover,
        .sidebar-menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #ffd700;
        }

        .sidebar-menu-item i {
            width: 24px;
            font-size: 18px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            transition: all 0.3s;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .date-time {
            font-size: 14px;
            color: #666;
            font-weight: bolder;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-card-title {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-card-value {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .stat-card-change {
            font-size: 12px;
            color: #10b981;
        }

        /* Bank Accounts Section */
        .bank-accounts-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .bank-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }

        .bank-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .bank-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(45deg);
        }

        .bank-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .account-number {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 15px;
        }

        .bank-balance {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .last-updated {
            font-size: 11px;
            opacity: 0.7;
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .chart-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Inventory Alerts */
        .alert-item {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        /* Real-time Update Indicator */
        .live-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #10b981;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
                transform: scale(1);
            }

            100% {
                opacity: 0;
                transform: scale(1.5);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar.active {
                left: 0;
            }
        }

        /* Loading Spinner */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Loading Spinner -->
    <div id="loading" class="loading">
        <div class="spinner"></div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-mobile-alt"></i> MobileShop Pro</h3>
            <small>Complete Management System</small>
        </div>
        <div class="sidebar-menu">
            <div class="sidebar-menu-item active" onclick="loadPage('dashboard')">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </div>
            <div class="sidebar-menu-item" onclick="loadPage('inventory')">
                <i class="fas fa-boxes"></i>
                <span>Inventory</span>
            </div>
            <div class="sidebar-menu-item" onclick="loadPage('sales')">
                <i class="fas fa-shopping-cart"></i>
                <span>Sales</span>
            </div>
            <div class="sidebar-menu-item" onclick="loadPage('purchases')">
                <i class="fas fa-truck"></i>
                <span>Purchases</span>
            </div>
            <div class="sidebar-menu-item" onclick="loadPage('banking')">
                <i class="fas fa-university"></i>
                <span>Bank Accounts</span>
            </div>
            <div class="sidebar-menu-item" onclick="loadPage('customers')">
                <i class="fas fa-users"></i>
                <span>Customers</span>
            </div>
            <div class="sidebar-menu-item" onclick="loadPage('suppliers')">
                <i class="fas fa-handshake"></i>
                <span>Suppliers</span>
            </div>
            <div class="sidebar-menu-item" onclick="loadPage('assets')">
                <i class="fas fa-chart-line"></i>
                <span>Assets & Liabilities</span>
            </div>
            <div class="sidebar-menu-item" onclick="loadPage('reports')">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </div>
            <div class="sidebar-menu-item" onclick="loadPage('settings')">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div>
                <h2 class="page-title">Dashboard</h2>
                <div class="live-indicator">
                    <span class="live-dot"></span>
                    <span>Live Updates Active</span>
                </div>
            </div>
            <div class="date-time" id="currentDateTime"></div>
        </div>

        <div id="pageContent">
            <!-- Dynamic content loads here -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Real-time WebSocket Connection
        let socket;
        let charts = {};

        // Initialize WebSocket for real-time updates
        function initWebSocket() {
            socket = io('http://localhost:3000', {
                transports: ['websocket'],
                reconnection: true
            });

            socket.on('connect', () => {
                console.log('Connected to real-time server');
                showNotification('Connected to live updates', 'success');
            });

            socket.on('balance_update', (data) => {
                console.log('Balance update received:', data);
                updateBankBalance(data.bankId, data.newBalance);
                showNotification(`Bank balance updated: ${data.bankName}`, 'info');
            });

            socket.on('stock_update', (data) => {
                console.log('Stock update received:', data);
                updateProductStock(data.productId, data.newQuantity);
                if (data.newQuantity <= data.minLevel) {
                    showNotification(`Low stock alert: ${data.productName}`, 'warning');
                }
            });

            socket.on('sale_completed', (data) => {
                refreshDashboard();
                showNotification(`New sale: ₹${data.amount}`, 'success');
            });

            socket.on('disconnect', () => {
                console.log('Disconnected from server');
                showNotification('Connection lost. Reconnecting...', 'error');
            });
        }

        // Update bank balance in UI
        function updateBankBalance(bankId, newBalance) {
            $(`.bank-balance[data-bank-id="${bankId}"]`).each(function() {
                const oldBalance = parseFloat($(this).text().replace(/[^0-9.-]+/g, ''));
                $(this).text(`₹${formatNumber(newBalance)}`);

                // Add animation effect
                $(this).css('animation', 'pulse 0.5s');
                setTimeout(() => {
                    $(this).css('animation', '');
                }, 500);
            });

            // Update total bank balance in stats
            updateTotalBankBalance();
        }

        // Format number with commas
        function formatNumber(num) {
            return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Load Dashboard
        async function loadDashboard() {
            showLoading();
            try {
                // Load all dashboard data in parallel
                const [stats, bankAccounts, recentSales, lowStock, chartData] = await Promise.all([
                    fetchAPI('get_dashboard_stats'),
                    fetchAPI('get_bank_accounts'),
                    fetchAPI('get_recent_sales', {
                        limit: 10
                    }),
                    fetchAPI('get_low_stock_products'),
                    fetchAPI('get_chart_data', {
                        period: 'monthly'
                    })
                ]);

                const html = `
                    <!-- Stats Cards -->
                    <div class="stats-grid">
                        ${createStatCard('Total Sales', '₹' + formatNumber(stats.total_sales), 'fa-chart-line', '#10b981', stats.sales_growth)}
                        ${createStatCard('Total Purchases', '₹' + formatNumber(stats.total_purchases), 'fa-shopping-cart', '#f59e0b', stats.purchases_growth)}
                        ${createStatCard('Stock Value', '₹' + formatNumber(stats.stock_value), 'fa-boxes', '#3b82f6', '')}
                        ${createStatCard('Receivables', '₹' + formatNumber(stats.receivables), 'fa-users', '#ef4444', stats.receivables_change)}
                        ${createStatCard('Payables', '₹' + formatNumber(stats.payables), 'fa-handshake', '#8b5cf6', stats.payables_change)}
                        ${createStatCard('Net Profit', '₹' + formatNumber(stats.net_profit), 'fa-chart-line', '#06b6d4', stats.profit_growth)}
                    </div>
                    
                    <!-- Bank Accounts Section -->
                    <div class="bank-accounts-section">
                        <div class="section-title">
                            <i class="fas fa-university"></i> Bank Accounts 
                            <button class="btn btn-sm btn-primary float-end" onclick="addBankAccount()">
                                <i class="fas fa-plus"></i> Add Account
                            </button>
                        </div>
                        <div class="bank-grid" id="bankGrid">
                            ${bankAccounts.map(account => `
                                <div class="bank-card">
                                    <div class="bank-name">${account.bank_name}</div>
                                    <div class="account-number">${account.account_number}</div>
                                    <div class="bank-balance" data-bank-id="${account.id}">
                                        ₹${formatNumber(account.current_balance)}
                                    </div>
                                    <div class="last-updated">
                                        Last updated: ${new Date(account.last_updated).toLocaleString()}
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    
                    <!-- Charts Section -->
                    <div class="charts-section">
                        <div class="chart-card">
                            <canvas id="salesChart"></canvas>
                        </div>
                        <div class="chart-card">
                            <canvas id="profitChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Recent Sales & Low Stock -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-card">
                                <h4><i class="fas fa-clock"></i> Recent Sales</h4>
                                <div style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr><th>Invoice</th><th>Customer</th><th>Amount</th><th>Date</th></tr>
                                        </thead>
                                        <tbody>
                                            ${recentSales.map(sale => `
                                                <tr>
                                                    <td>${sale.invoice_no}</td>
                                                    <td>${sale.customer_name}</td>
                                                    <td>₹${formatNumber(sale.amount)}</td>
                                                    <td>${new Date(sale.date).toLocaleDateString()}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart-card">
                                <h4><i class="fas fa-exclamation-triangle"></i> Low Stock Alerts</h4>
                                <div id="lowStockAlerts">
                                    ${lowStock.map(product => `
                                        <div class="alert-item">
                                            <strong>${product.product_name}</strong><br>
                                            Current: ${product.quantity} | Min: ${product.min_stock_level}
                                            <button class="btn btn-sm btn-warning float-end" onclick="reorderStock(${product.id})">
                                                Reorder
                                            </button>
                                        </div>
                                    `).join('')}
                                    ${lowStock.length === 0 ? '<p class="text-success">All products have sufficient stock!</p>' : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#pageContent').html(html);

                // Initialize charts
                initCharts(chartData);

            } catch (error) {
                console.error('Error loading dashboard:', error);
                $('#pageContent').html('<div class="alert alert-danger">Error loading dashboard. Please refresh.</div>');
            }
            hideLoading();
        }

        function createStatCard(title, value, icon, color, change) {
            return `
                <div class="stat-card" onclick="navigateTo('${title.toLowerCase()}')">
                    <div class="stat-card-header">
                        <span class="stat-card-title">${title}</span>
                        <div class="stat-card-icon" style="background: ${color}20; color: ${color}">
                            <i class="fas ${icon}"></i>
                        </div>
                    </div>
                    <div class="stat-card-value">${value}</div>
                    ${change ? `<div class="stat-card-change"><i class="fas fa-arrow-up"></i> ${change}% from last month</div>` : ''}
                </div>
            `;
        }

        function initCharts(data) {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            charts.sales = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Sales',
                        data: data.sales,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Purchases',
                        data: data.purchases,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Sales vs Purchases Trend'
                        }
                    }
                }
            });

            // Profit Chart
            const profitCtx = document.getElementById('profitChart').getContext('2d');
            charts.profit = new Chart(profitCtx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Profit',
                        data: data.profits,
                        backgroundColor: '#10b981',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Monthly Profit'
                        }
                    }
                }
            });
        }

        // Update total bank balance
        async function updateTotalBankBalance() {
            const banks = await fetchAPI('get_bank_accounts');
            const totalBalance = banks.reduce((sum, bank) => sum + bank.current_balance, 0);
            $('.stat-card').each(function() {
                if ($(this).find('.stat-card-title').text() === 'Total Bank Balance') {
                    $(this).find('.stat-card-value').text(`₹${formatNumber(totalBalance)}`);
                }
            });
        }

        // Refresh dashboard (called after any transaction)
        function refreshDashboard() {
            if ($('.page-title').text() === 'Dashboard') {
                loadDashboard();
            }
        }

        // Auto-refresh every 30 seconds
        setInterval(() => {
            if ($('.page-title').text() === 'Dashboard') {
                refreshDashboard();
            }
        }, 30000);

        // Update date and time
        function updateDateTime() {
            const now = new Date();
            document.getElementById('currentDateTime').innerHTML =
                now.toLocaleDateString('en-PK', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) +
                ' | ' + now.toLocaleTimeString();
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();

        // Show notification
        function showNotification(message, type) {
            const notification = $(`
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} border-0" 
                     role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000"
                     style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 250px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `);
            $('body').append(notification);
            const toast = new bootstrap.Toast(notification[0]);
            toast.show();
            notification.on('hidden.bs.toast', () => notification.remove());
        }

        // API helper functions
        async function fetchAPI(endpoint, params = {}) {
            const queryString = new URLSearchParams(params).toString();
            const url = `backend/api.php?action=${endpoint}&${queryString}`;
            const response = await fetch(url);
            if (!response.ok) throw new Error(`API error: ${response.status}`);
            return await response.json();
        }

        function showLoading() {
            $('#loading').fadeIn();
        }

        function hideLoading() {
            $('#loading').fadeOut();
        }

        // Page navigation
        function loadPage(page) {
            $('.sidebar-menu-item').removeClass('active');
            $(event.currentTarget).addClass('active');

            switch (page) {
                case 'dashboard':
                    loadDashboard();
                    break;
                case 'inventory':
                    loadInventory();
                    break;
                case 'sales':
                    loadSales();
                    break;
                case 'purchases':
                    loadPurchases();
                    break;
                case 'banking':
                    loadBanking();
                    break;
                case 'customers':
                    loadCustomers();
                    break;
                case 'suppliers':
                    loadSuppliers();
                    break;
                case 'assets':
                    loadAssets();
                    break;
                case 'reports':
                    loadReports();
                    break;
                case 'settings':
                    loadSettings();
                    break;
            }
        }

        // Initialize
        $(document).ready(() => {
            initWebSocket();
            loadDashboard();
        });

        // Include Bootstrap JS
        const bootstrapScript = document.createElement('script');
        bootstrapScript.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';
        document.head.appendChild(bootstrapScript);
    </script>
</body>

</html>