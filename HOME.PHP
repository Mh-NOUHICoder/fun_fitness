<?php 
$currentPageName = basename($_SERVER['SCRIPT_NAME']);
?>
<style>
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

    /* Scroll Progress */
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

    /* Sidebar */
    .sidebar {
        background: var(--bg-secondary);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        border-right: 1px solid var(--border-color);
        padding: 10px 0;
        transition: all 0.3s ease;
    }

    .sidebar-header {
        padding: 0 20px 20px 20px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 20px;
    }

    .sidebar-logo {
        width: 120px;
        filter: brightness(0) invert(1);
    }

    .light-mode .sidebar-logo {
        filter: none;
    }

    .sidebar-nav {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 0 15px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 2px;
        text-decoration: none;
        color: var(--text-secondary);
        border-radius: 10px;
        transition: all 0.3s ease;
        position: relative;
        border: 1px solid transparent;
    }

    .nav-item:hover {
        background: var(--bg-card);
        color: var(--text-primary);
        border-color: var(--border-color);
        transform: translateX(5px);
    }

    .nav-item.active {
        background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-secondary) 100%);
        color: white;
        border-color: var(--accent-primary);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .nav-item.active::before {
        content: '';
        position: absolute;
        left: -15px;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: var(--accent-primary);
        border-radius: 0 4px 4px 0;
    }

    .nav-icon {
        width: 20px;
        text-align: center;
        font-size: 1.1em;
        transition: transform 0.3s ease;
    }

    .nav-item:hover .nav-icon {
        transform: scale(1.1);
    }

    .nav-text {
        font-weight: 500;
        font-size: 0.9em;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .badge {
        background: var(--danger);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.7em;
        font-weight: 600;
        margin-left: auto;
    }

    /* Sidebar Bottom Actions - FIXED POSITION */
    .sidebar-actions {
        padding: 15px;
        border-top: 1px solid var(--border-color);
        margin-top: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
        position: sticky;
        bottom: 0;
        background: var(--bg-secondary);
    }

    .sidebar-action {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-primary);
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .sidebar-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .theme-toggle:hover {
        background: var(--accent-primary);
        color: white;
    }

    .logout-btn:hover {
        background: var(--danger);
        color: white;
        border-color: var(--danger);
    }

    .action-icon {
        font-size: 1.1em;
        transition: transform 0.3s ease;
        width: 20px;
        text-align: center;
    }

    .theme-toggle:hover .action-icon {
        transform: rotate(180deg);
    }

    .logout-btn:hover .action-icon {
        transform: translateX(3px);
    }

    .action-text {
        font-weight: 500;
        font-size: 0.9em;
        flex: 1;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .sidebar {
            width: 80px;
        }

        .sidebar-header {
            padding: 0 10px 15px 10px;
            text-align: center;
        }

        .sidebar-logo {
            width: 50px;
        }

        .nav-text,
        .action-text {
            display: none;
        }

        .nav-item {
            justify-content: center;
            padding: 15px 10px;
        }

        .nav-item.active::before {
            left: -10px;
        }

        .badge {
            position: absolute;
            top: 8px;
            right: 8px;
            padding: 2px 4px;
            font-size: 0.6em;
        }

        .sidebar-actions {
            padding: 10px;
        }

        .sidebar-action {
            justify-content: center;
            padding: 12px 10px;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            flex-direction: row;
            overflow-x: auto;
            padding: 10px;
            border-right: none;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-header {
            display: none;
        }

        .sidebar-nav {
            flex-direction: row;
            flex: 1;
            gap: 5px;
            padding: 0 10px;
        }

        .nav-item {
            flex-direction: column;
            gap: 8px;
            padding: 10px;
            min-width: 70px;
        }

        .nav-item.active::before {
            left: 50%;
            top: -10px;
            transform: translateX(-50%);
            width: 70%;
            height: 3px;
            border-radius: 3px 3px 0 0;
        }

        .nav-text {
            display: block;
            font-size: 0.7em;
            text-align: center;
        }

        .badge {
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .sidebar-actions {
            display: none;
        }

        /* Mobile Bottom Bar */
        .mobile-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            padding: 10px 15px;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-action {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.3s ease;
            flex: 1;
            justify-content: center;
        }

        .mobile-action:hover {
            transform: translateY(-2px);
        }

        .theme-toggle-mobile:hover {
            background: var(--accent-primary);
            color: white;
        }

        .logout-mobile:hover {
            background: var(--danger);
            color: white;
        }

        .mobile-icon {
            font-size: 1em;
        }

        .mobile-text {
            font-size: 0.8em;
            font-weight: 500;
        }
    }

    @media (max-width: 480px) {
        .sidebar {
            position: relative;
        }

        .nav-item {
            min-width: 60px;
            padding: 8px 5px;
        }

        .nav-text {
            font-size: 0.65em;
        }

        .nav-icon {
            font-size: 1em;
        }

        .mobile-bottom-bar {
            padding: 8px 10px;
        }

        .mobile-action {
            padding: 8px 10px;
            gap: 6px;
        }

        .mobile-text {
            font-size: 0.7em;
        }
    }

    /* Animation for sidebar items */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .nav-item {
        animation: slideIn 0.3s ease forwards;
    }

    .nav-item:nth-child(1) { animation-delay: 0.1s; }
    .nav-item:nth-child(2) { animation-delay: 0.2s; }
    .nav-item:nth-child(3) { animation-delay: 0.3s; }
    .nav-item:nth-child(4) { animation-delay: 0.4s; }
    .nav-item:nth-child(5) { animation-delay: 0.5s; }
</style>
    
    <!-- Sidebar -->
    <section class="sidebar">
        <!-- <div class="sidebar-header">
            <img src="../assets/IMAGES/fast-fit.png" alt="Fast Fit Gym" class="sidebar-logo">
        </div> -->
        <div style="margin-bottom:50px;"></div>
        
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="nav-item <?= ($currentPageName=="dashboard.php")? "active":""?>">
                <i class="nav-icon fa-solid fa-border-all"></i>
                <span class="nav-text">Dashboard</span>
            </a>
            
            <a href="members.php" class="nav-item <?= ($currentPageName=="members.php")? "active":""?>">
                <i class="nav-icon fa-solid fa-people-group"></i>
                <span class="nav-text">Members</span>
            </a>
            
            <a href="staff.php" class="nav-item <?= ($currentPageName=="staff.php")? "active":""?>">
                <i class="nav-icon fa-solid fa-user-tie"></i>
                <span class="nav-text">Staff</span>
            </a>

            <a href="classes.php" class="nav-item <?= ($currentPageName=="classes.php")? "active":""?>">
                <i class="nav-icon fa-solid fa-dumbbell"></i>
                <span class="nav-text">Classes</span>
            </a>

            <a href="plans.php" class="nav-item <?= ($currentPageName=="plans.php")? "active":""?>">
                <i class="nav-icon fa-solid fa-credit-card"></i>
                <span class="nav-text">Plans</span>
            </a>

            <a href="#" class="nav-item">
                <i class="nav-icon fa-regular fa-message"></i>
                <span class="nav-text">Messages</span>
                <span class="badge">14</span>
            </a>
        </nav>

        <!-- Desktop Actions - FIXED POSITION AT BOTTOM -->
        <div class="sidebar-actions">
            <div class="sidebar-action theme-toggle" id="themeToggle">
                <i class="action-icon fa-solid fa-moon"></i>
                <span class="action-text">Theme</span>
            </div>

            <a href="../login.php" class="sidebar-action logout-btn">
                <i class="action-icon fa-solid fa-arrow-right-from-bracket"></i>
                <span class="action-text">Log Out</span>
            </a>
        </div>
    </section>

    <!-- Mobile Bottom Bar -->
    <div class="mobile-bottom-bar" id="mobileBottomBar">
        <div class="mobile-action theme-toggle-mobile" id="themeToggleMobile">
            <i class="mobile-icon fa-solid fa-moon"></i>
            <span class="mobile-text">Theme</span>
        </div>

        <a href="../login.php" class="mobile-action logout-mobile">
            <i class="mobile-icon fa-solid fa-arrow-right-from-bracket"></i>
            <span class="mobile-text">Logout</span>
        </a>
    </div>

    <script>
        // Theme Toggle Functionality
        function initializeTheme() {
            const themeToggle = document.getElementById('themeToggle');
            const themeToggleMobile = document.getElementById('themeToggleMobile');
            const body = document.body;
            
            // Function to update theme and icons
            function updateTheme(isDark) {
                if (isDark) {
                    body.classList.remove('light-mode');
                    // Update icons to moon (dark mode)
                    updateIcons('moon');
                    localStorage.setItem('theme', 'dark');
                } else {
                    body.classList.add('light-mode');
                    // Update icons to sun (light mode)
                    updateIcons('sun');
                    localStorage.setItem('theme', 'light');
                }
            }
            
            // Function to update all theme icons
            function updateIcons(iconType) {
                const icons = document.querySelectorAll('.theme-toggle .action-icon, .theme-toggle-mobile .mobile-icon');
                icons.forEach(icon => {
                    if (iconType === 'sun') {
                        icon.className = icon.classList.contains('mobile-icon') ? 
                            'mobile-icon fa-solid fa-sun' : 'action-icon fa-solid fa-sun';
                    } else {
                        icon.className = icon.classList.contains('mobile-icon') ? 
                            'mobile-icon fa-solid fa-moon' : 'action-icon fa-solid fa-moon';
                    }
                });
            }
            
            // Toggle theme function
            function toggleTheme() {
                const isCurrentlyDark = !body.classList.contains('light-mode');
                updateTheme(!isCurrentlyDark);
            }
            
            // Add event listeners to both theme toggles
            if (themeToggle) {
                themeToggle.addEventListener('click', toggleTheme);
            }
            if (themeToggleMobile) {
                themeToggleMobile.addEventListener('click', toggleTheme);
            }
            
            // Check for saved theme preference on page load
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                updateTheme(false);
            } else {
                updateTheme(true);
            }
        }

        // Mobile Bottom Bar Visibility
        function handleMobileBottomBar() {
            const mobileBottomBar = document.getElementById('mobileBottomBar');
            if (window.innerWidth <= 768) {
                mobileBottomBar.style.display = 'flex';
            } else {
                mobileBottomBar.style.display = 'none';
            }
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeTheme();
            handleMobileBottomBar();
            
            // Update mobile bottom bar on resize
            window.addEventListener('resize', handleMobileBottomBar);
            
            // Add active state to navigation items
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // Don't prevent default for links
                    navItems.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });

        // Ensure theme works across all pages
        window.addEventListener('storage', function(e) {
            if (e.key === 'theme') {
                initializeTheme();
            }
        });
    </script>