<?php 
session_start();

// Security Check: Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("location:../login.php");
    exit();
}

include('../assets/include/script.php');

$total_members = $con->query("SELECT COUNT(*) AS total_members FROM `members`")->fetchColumn();
$total_staff = $con->query("SELECT COUNT(*) AS total_staff FROM `staff`")->fetchColumn();

// Real data for charts - get monthly member registrations
$monthly_data = [];
$monthly_labels = [];

for ($i = 1; $i <= 12; $i++) {
    $stmt = $con->prepare("SELECT COUNT(*) FROM members WHERE MONTH(join_date) = ? AND YEAR(join_date) = YEAR(CURDATE())");
    $stmt->execute([$i]);
    $monthly_data[] = $stmt->fetchColumn();
    $monthly_labels[] = date('M', mktime(0, 0, 0, $i, 1));
}

// Sample revenue data (you can replace with real revenue data from your database)
$revenue_data = [4500, 5200, 4800, 6100, 5800, 7200, 6800, 7500, 8200, 7800, 8500, 9200];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Add Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard - Fast Fit Gym</title>
    <link rel="shortcut icon" type="x-icon" href="../assets/IMAGES/logo-icon.png">
</head>
<style>
    @font-face {
        font-family: "Montserrat";
        src: url(../assets/fonts/Montserrat/static/Montserrat-Regular.ttf);
    }
    
    :root {
        --bg-primary: #1a1d28;
        --bg-secondary: #252a3a;
        --bg-card: #2d3446;
        --text-primary: #ffffff;
        --text-secondary: #b0b3c1;
        --accent-primary: #667eea;
        --accent-secondary: #764ba2;
        --border-color: #3a4158;
        --success: #6cf856;
        --danger: #ea3b3b;
        --warning: #ff9bac;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        height: 100vh;
        display: grid;
        grid-template-columns: 150px 1fr;
        grid-template-rows: 60px 1fr;
        grid-gap: 10px;
        grid-template-areas: 
            "header header"
            "side main";
        background: var(--bg-primary);
        color: var(--text-primary);
        margin: 0;
        padding: 0;
    }

    body.light-mode {
        --bg-primary: #f8f9fa;
        --bg-secondary: #ffffff;
        --bg-card: #ffffff;
        --text-primary: #2d3446;
        --text-secondary: #6c757d;
        --accent-primary: #667eea;
        --accent-secondary: #764ba2;
        --border-color: #dee2e6;
        --success: #28a745;
        --danger: #dc3545;
        --warning: #ffc107;
    }

    /* Header */
    header {
        background-color: var(--bg-secondary);
        grid-area: header;
        border-bottom: 1px solid var(--border-color);
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        padding: 0 20px;
        position: relative;
    }

    .big_title {
        letter-spacing: 2px;
        color: var(--text-primary);
        font-weight: 600;
        margin: 0;
        text-align: center;
        flex: 1;
    }

    .logo {
        width: 140px;
    }

    .dark-mode-toggle {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 5px 15px;
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9em;
    }

    .dark-mode-toggle:hover {
        background: var(--accent-primary);
    }

    .sidebar {
        background-color: var(--bg-secondary);
        grid-area: side;
        border-radius: 0 15px 15px 0;
        border-right: 1px solid var(--border-color);
    }

    /* Main Content */
    main { 
        grid-area: main;
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: auto 1fr;
        gap: 20px;
        overflow-y: auto;
    }

    /* Stats Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 10px;
    }

    .stat-card {
        background: var(--bg-card);
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-secondary) 100%);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .stat-card.members::before {
        background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-secondary) 100%);
    }

    .stat-card.staff::before {
        background: linear-gradient(135deg, var(--success) 0%, #28a745 100%);
    }

    .stat-icon {
        font-size: 2.5em;
        color: var(--accent-primary);
        margin-bottom: 15px;
        opacity: 0.8;
    }

    .stat-card.members .stat-icon {
        color: var(--accent-primary);
    }

    .stat-card.staff .stat-icon {
        color: var(--success);
    }

    .stat-number {
        font-size: 3em;
        font-weight: bold;
        color: var(--text-primary);
        margin: 10px 0;
        line-height: 1;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.9em;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 500;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        margin-top: 10px;
        font-size: 0.85em;
    }

    .trend-up {
        color: var(--success);
    }

    .trend-down {
        color: var(--danger);
    }

    /* Charts Container */
    .charts-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 20px;
    }

    .chart-card {
        background: var(--bg-card);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        border: 1px solid var(--border-color);
        transition: transform 0.3s ease;
    }

    .chart-card:hover {
        transform: translateY(-3px);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .chart-title {
        color: var(--text-primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.2em;
    }

    .chart-actions {
        display: flex;
        gap: 10px;
    }

    .chart-btn {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.8em;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .chart-btn:hover {
        background: var(--accent-primary);
        color: white;
        border-color: var(--accent-primary);
    }

    .chart-wrapper {
        position: relative;
        height: 300px;
        width: 100%;
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .action-card {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .action-card:hover {
        background: var(--accent-primary);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .action-card:hover .action-icon,
    .action-card:hover .quick-action-text {
        color: white;
    }

    .action-icon {
        font-size: 2em;
        color: var(--accent-primary);
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    .quick-action-text {
        color: var(--text-primary);
        font-weight: 500;
        transition: color 0.3s ease;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        body {
            grid-template-columns: 80px 1fr;
        }
        
        .logo {
            width: 120px;
        }
        
        .big_title {
            font-size: 1.1em;
        }
        
        .charts-container {
            grid-template-columns: 1fr;
        }

        .quick-action-text{
            font-weight: 400;
        }
    }

    @media (max-width: 768px) {
        body {
            grid-template-columns: 1fr;
            grid-template-rows: 60px auto 1fr;
            grid-template-areas: 
                "header"
                "side"
                "main";
            height: auto;
            min-height: 100vh;
        }
        
        .sidebar {
            border-radius: 0;
            border-right: none;
            border-bottom: 1px solid var(--border-color);
        }
        
        .stats-cards {
            grid-template-columns: 1fr;
        }
        
        .charts-container {
            grid-template-columns: 1fr;
        }
        
        .chart-wrapper {
            height: 250px;
        }
        
        .logo {
            width: 100px;
        }
        
        .big_title {
            font-size: 1em;
        }
        
        main {
            padding: 15px;
            gap: 15px;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .stat-number {
            font-size: 2.5em;
        }
    }

    @media (max-width: 480px) {
        .chart-card {
            padding: 15px;
        }
        
        .chart-wrapper {
            height: 200px;
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
        
        .dark-mode-toggle {
            padding: 4px 10px;
            font-size: 0.8em;
        }
        
        .dark-mode-toggle span {
            display: none;
        }
        
        .dark-mode-toggle i {
            margin: 0;
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--bg-secondary);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--accent-primary);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--accent-secondary);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.6s ease;
    }

    /* Progress Scroll */
    .scroll-progress {
        height: 4px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-secondary) 100%);
        width: 100%;
        scale: 0 1;
        transform-origin: left;
        animation: scroll-progress linear;
        animation-timeline: scroll();
    }

    @keyframes scroll-progress {
        to { scale: 1 1; }
    }
</style>
<body class="dark-mode">
    <div class="scroll-progress"></div>
    
    <!-- sidebar include -->
    <?php include('../home.php'); ?>

    <header class="header">
        <div class="logo">
            <img src="../assets/IMAGES/fast-fit.png" style="background:none;width: 100%; " alt="Fast Fit Gym Logo">
        </div>
        <span class="big_title"><h4>Dashboard Overview</h4></span>
    </header>
    
    <main>
        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="stat-card members fade-in">
                <div class="stat-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="stat-number"><?= number_format($total_members) ?></div>
                <div class="stat-label">Total Members</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>12% from last month</span>
                </div>
            </div>

            <div class="stat-card staff fade-in">
                <div class="stat-icon">
                    <i class="fa fa-briefcase"></i>
                </div>
                <div class="stat-number"><?= number_format($total_staff) ?></div>
                <div class="stat-label">Staff Members</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>5% from last month</span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-container">
            <div class="chart-card fade-in">
                <div class="chart-header">
                    <h3 class="chart-title">New Members Statistics</h3>
                    <div class="chart-actions">
                        <button class="chart-btn active" data-chart="members" data-type="monthly">Monthly</button>
                        <button class="chart-btn" data-chart="members" data-type="yearly">Yearly</button>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="membersChart"></canvas>
                </div>
            </div>

            <div class="chart-card fade-in">
                <div class="chart-header">
                    <h3 class="chart-title">Revenue Overview</h3>
                    <div class="chart-actions">
                        <button class="chart-btn active" data-chart="revenue" data-type="monthly">Monthly</button>
                        <button class="chart-btn" data-chart="revenue" data-type="yearly">Yearly</button>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="action-card" onclick="window.location.href='members.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div class="quick-action-text">Add New Member</div>
            </div>
            <div class="action-card" onclick="window.location.href='staff.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div class="quick-action-text">Manage Staff</div>
            </div>
            <div class="action-card" onclick="window.location.href='classes.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>
                <div class="quick-action-text">View Classes</div>
            </div>
            <div class="action-card" onclick="window.location.href='plans.php'">
                <div class="action-icon">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div class="quick-action-text">plans</div>
            </div>
        </div>
    </main>

    <script>
        // Chart instances
        let membersChart = null;
        let revenueChart = null;

        // Chart data
        const chartData = {
            members: {
                monthly: {
                    labels: <?= json_encode($monthly_labels) ?>,
                    data: <?= json_encode($monthly_data) ?>
                },
                yearly: {
                    labels: ['2020', '2021', '2022', '2023', '2024'],
                    data: [120, 180, 240, 320, <?= $total_members ?>]
                }
            },
            revenue: {
                monthly: {
                    labels: <?= json_encode($monthly_labels) ?>,
                    data: <?= json_encode($revenue_data) ?>
                },
                yearly: {
                    labels: ['2020', '2021', '2022', '2023', '2024'],
                    data: [45000, 52000, 68000, 82000, 95000]
                }
            }
        };

        // Chart Colors based on theme
        function getChartColors() {
            const isLightMode = document.body.classList.contains('light-mode');
            return {
                primary: isLightMode ? '#667eea' : '#667eea',
                secondary: isLightMode ? '#764ba2' : '#764ba2',
                success: isLightMode ? '#28a745' : '#6cf856',
                background: isLightMode ? '#ffffff' : '#2d3446',
                border: isLightMode ? '#dee2e6' : '#3a4158',
                text: isLightMode ? '#2d3446' : '#ffffff',
                grid: isLightMode ? 'rgba(0, 0, 0, 0.1)' : 'rgba(255, 255, 255, 0.1)'
            };
        }

        // Initialize Charts
        function initializeCharts() {
            const colors = getChartColors();
            
            // Destroy existing charts if they exist
            if (membersChart) {
                membersChart.destroy();
            }
            if (revenueChart) {
                revenueChart.destroy();
            }
            
            // Members Chart
            const membersCtx = document.getElementById('membersChart').getContext('2d');
            membersChart = new Chart(membersCtx, {
                type: 'line',
                data: {
                    labels: chartData.members.monthly.labels,
                    datasets: [{
                        label: 'New Members',
                        data: chartData.members.monthly.data,
                        borderColor: colors.primary,
                        backgroundColor: colors.primary + '20',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: colors.primary,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { 
                                color: colors.text,
                                font: { size: 12 }
                            }
                        },
                        tooltip: {
                            backgroundColor: colors.background,
                            titleColor: colors.text,
                            bodyColor: colors.text,
                            borderColor: colors.border,
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: { 
                                color: colors.grid,
                                drawBorder: false
                            },
                            ticks: { 
                                color: colors.text,
                                font: { size: 11 }
                            }
                        },
                        y: {
                            grid: { 
                                color: colors.grid,
                                drawBorder: false
                            },
                            ticks: { 
                                color: colors.text,
                                font: { size: 11 },
                                beginAtZero: true
                            }
                        }
                    }
                }
            });

            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            revenueChart = new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: chartData.revenue.monthly.labels,
                    datasets: [{
                        label: 'Revenue ($)',
                        data: chartData.revenue.monthly.data,
                        backgroundColor: colors.secondary + '80',
                        borderColor: colors.secondary,
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { 
                                color: colors.text,
                                font: { size: 12 }
                            }
                        },
                        tooltip: {
                            backgroundColor: colors.background,
                            titleColor: colors.text,
                            bodyColor: colors.text,
                            borderColor: colors.border,
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: { 
                                color: colors.grid,
                                drawBorder: false
                            },
                            ticks: { 
                                color: colors.text,
                                font: { size: 11 }
                            }
                        },
                        y: {
                            grid: { 
                                color: colors.grid,
                                drawBorder: false
                            },
                            ticks: { 
                                color: colors.text,
                                font: { size: 11 },
                                beginAtZero: true,
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Update charts when theme changes
        function updateChartsForTheme() {
            initializeCharts();
        }

        // Switch chart data type (monthly/yearly)
        function switchChartType(chartName, type) {
            if (chartName === 'members') {
                membersChart.data.labels = chartData.members[type].labels;
                membersChart.data.datasets[0].data = chartData.members[type].data;
                membersChart.update();
            } else if (chartName === 'revenue') {
                revenueChart.data.labels = chartData.revenue[type].labels;
                revenueChart.data.datasets[0].data = chartData.revenue[type].data;
                revenueChart.update();
            }
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts
            initializeCharts();

            // Dark Mode Toggle
            document.getElementById('darkModeToggle').addEventListener('click', function() {
                document.body.classList.toggle('light-mode');
                if (document.body.classList.contains('light-mode')) {
                    this.innerHTML = '<i class="fas fa-moon me-2"></i><span>Dark Mode</span>';
                    localStorage.setItem('theme', 'light');
                } else {
                    this.innerHTML = '<i class="fas fa-sun me-2"></i><span>Light Mode</span>';
                    localStorage.setItem('theme', 'dark');
                }
                updateChartsForTheme();
            });

            // Load saved theme
            if (localStorage.getItem('theme') === 'light') {
                document.body.classList.add('light-mode');
                document.getElementById('darkModeToggle').innerHTML = '<i class="fas fa-moon me-2"></i><span>Dark Mode</span>';
            }

            // Chart type switcher
            document.querySelectorAll('.chart-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const chart = this.dataset.chart;
                    const type = this.dataset.type;
                    
                    // Update active state
                    this.parentElement.querySelectorAll('.chart-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Switch chart data
                    switchChartType(chart, type);
                });
            });

            // Add loading animation to stats cards
            const statsCards = document.querySelectorAll('.stat-card');
            statsCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (membersChart) membersChart.resize();
            if (revenueChart) revenueChart.resize();
        });
    </script>
</body>
</html>