<?php 
session_start();
// Include database configuration
include('../assets/include/config.php');

// CSRF token generation for security
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --- BACKEND: Fetch Plan Statistics ---
// Counts how many members are assigned to each plan type
$planStats = [];
try {
    $statsStmt = $con->query("
        SELECT m.type, COUNT(mem.member_id) as member_count 
        FROM memberships m 
        LEFT JOIN members mem ON m.membership_id = mem.membership_id 
        GROUP BY m.membership_id
    ");
    $planStats = $statsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $planStats = [];
}

// --- BACKEND: Define Ready-Made Templates ---
// These are static templates available for quick creation
$planTemplates = [
    'basic' => [
        'name' => 'Starter Pack',
        'price' => 29.99,
        'duration' => 1,
        'description' => 'Perfect for beginners starting their fitness journey',
        'features' => ['Gym Access', 'Locker Room', 'Basic Equipment', '1 Free Training Session'],
        'color' => '#667eea',
        'icon' => 'fa-seedling'
    ],
    'pro' => [
        'name' => 'Pro Fitness',
        'price' => 59.99,
        'duration' => 3,
        'description' => 'For serious fitness enthusiasts wanting more',
        'features' => ['All Basic Features', 'Group Classes', 'Premium Equipment', '3 Training Sessions', 'Nutrition Guide'],
        'color' => '#f093fb',
        'icon' => 'fa-dumbbell'
    ],
    'elite' => [
        'name' => 'Elite Performance',
        'price' => 99.99,
        'duration' => 6,
        'description' => 'Maximum results with premium services',
        'features' => ['All Pro Features', 'Personal Trainer', 'Unlimited Classes', 'Recovery Services', 'Advanced Analytics'],
        'color' => '#4facfe',
        'icon' => 'fa-crown'
    ],
    'ultimate' => [
        'name' => 'Ultimate Transformation',
        'price' => 149.99,
        'duration' => 12,
        'description' => 'Complete lifestyle transformation package',
        'features' => ['All Elite Features', '24/7 Access', 'Spa & Sauna', 'Meal Planning', 'Progress Tracking', 'Priority Booking'],
        'color' => '#43e97b',
        'icon' => 'fa-rocket'
    ]
];

// --- BACKEND: Fetch Active Plans ---
// Retrieves plans currently stored in the database
try {
    $req = $con->query("
        SELECT m.*, p.price, p.service_name, p.description as price_description 
        FROM memberships m 
        LEFT JOIN prices p ON m.id_price = p.price_id 
        ORDER BY m.membership_id DESC
    ");
    $existingPlans = $req->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $existingPlans = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Membership Plans - Fast Fit Gym</title>
    <link rel="shortcut icon" type="x-icon" href="../assets/IMAGES/logo-icon.png">
</head>
<style>
    @font-face {
        font-family: "Montserrat";
        src: url(../assets/fonts/Montserrat/static/Montserrat-Regular.ttf);
    }
    
    :root {
        --bg-primary: #f8fafc;
        --bg-secondary: #ffffff;
        --bg-card: #ffffff;
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --accent-primary: #4299e1;
        --accent-secondary: #667eea;
        --border-color: #e2e8f0;
        --success: #48bb78;
        --warning: #ed8936;
        --info: #4299e1;
        --light-blue: #ebf8ff;
        --light-purple: #faf5ff;
        --light-green: #f0fff4;
        --light-orange: #fffaf0;
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
        overflow: hidden;
    }

    body.dark-mode {
        --bg-primary: #1a202c;
        --bg-secondary: #2d3748;
        --bg-card: #2d3748;
        --text-primary: #f7fafc;
        --text-secondary: #cbd5e0;
        --accent-primary: #63b3ed;
        --accent-secondary: #7f9cf5;
        --border-color: #4a5568;
        --success: #68d391;
        --warning: #f6ad55;
        --info: #63b3ed;
        --light-blue: #2a4365;
        --light-purple: #44337a;
        --light-green: #22543d;
        --light-orange: #744210;
    }

    /* Header */
    header {
        background: var(--bg-secondary);
        grid-area: header;
        border-bottom: 1px solid var(--border-color);
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        padding: 0 20px;
        position: relative;
    }

    .big_title {
        letter-spacing: 1px;
        color: var(--text-primary);
        font-weight: 600;
        margin: 0;
        text-align: center;
        flex: 1;
    }

    .logo {
        width: 140px;
    }

    body.light-mode .logo {
        filter: brightness(0) invert(1);
    }

    .sidebar {
        background: var(--bg-secondary);
        grid-area: side;
        border-right: 1px solid var(--border-color);
    }

    /* Main Content */
    main { 
        grid-area: main;
        padding: 30px;
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: auto 1fr;
        gap: 30px;
        overflow-y: auto;
        background: var(--bg-primary);
    }

    /* Hero Section */
    .hero-section {
        text-align: center;
        padding: 50px 20px;
        background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-secondary) 100%);
        border-radius: 16px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        color: white;
    }

    .hero-title {
        font-size: 2.5em;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .hero-subtitle {
        font-size: 1.1em;
        opacity: 0.9;
        margin-bottom: 0;
    }

    /* Section Headers */
    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 2em;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-primary);
    }

    .section-subtitle {
        color: var(--text-secondary);
        font-size: 1.1em;
    }

    /* Plan Templates Grid */
    .templates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    .template-card {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        position: relative;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .template-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.1);
    }

    .template-header {
        padding: 30px 25px 20px;
        text-align: center;
        position: relative;
        color: white;
    }

    .template-icon {
        font-size: 2.5em;
        margin-bottom: 15px;
        opacity: 0.9;
    }

    .template-name {
        font-size: 1.6em;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .template-description {
        opacity: 0.9;
        font-size: 0.95em;
        line-height: 1.5;
    }

    .template-price {
        font-size: 3em;
        font-weight: 700;
        margin: 20px 0;
        line-height: 1;
    }

    .template-duration {
        opacity: 0.9;
        font-size: 0.9em;
        margin-bottom: 25px;
    }

    .template-features {
        padding: 0 25px 25px;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        font-size: 0.95em;
        color: var(--text-primary);
    }

    .feature-item i {
        color: var(--success);
        margin-right: 12px;
        font-size: 1.1em;
    }

    .template-actions {
        padding: 20px;
        text-align: center;
        border-top: 1px solid var(--border-color);
    }

    .btn-template {
        background: var(--accent-primary);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-template:hover {
        background: var(--accent-secondary);
        color: white;
        transform: translateY(-2px);
    }

    .btn-template:disabled {
        background: var(--text-secondary);
        cursor: not-allowed;
        transform: none;
    }

    /* Existing Plans Section */
    .existing-plans-section {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
        margin-bottom: 30px;
    }

    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }

    .plan-card {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 25px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .plan-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--accent-primary);
    }

    .plan-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }

    .plan-header {
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .plan-type {
        font-size: 1.3em;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .plan-price {
        font-size: 1.8em;
        font-weight: 700;
        color: var(--accent-primary);
        margin: 10px 0;
    }

    .plan-duration {
        color: var(--text-secondary);
        font-size: 0.9em;
    }

    .plan-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
    }

    .member-count {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-secondary);
        font-size: 0.9em;
    }

    .member-count i {
        color: var(--success);
    }

    /* Custom Plan Section */
    .custom-plan-section {
        background: linear-gradient(135deg, var(--light-blue) 0%, var(--light-purple) 100%);
        border-radius: 16px;
        padding: 40px;
        text-align: center;
        margin-top: 30px;
        border: 1px solid var(--border-color);
    }

    .custom-title {
        font-size: 2em;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--text-primary);
    }

    .custom-subtitle {
        font-size: 1.1em;
        margin-bottom: 30px;
        color: var(--text-secondary);
    }

    .btn-custom {
        background: var(--accent-primary);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: var(--accent-secondary);
        color: white;
        transform: translateY(-2px);
    }

    /* Success States */
    .template-card.success {
        border: 2px solid var(--success);
    }

    .template-card.success .template-header {
        background: var(--success) !important;
    }

    /* Notification System */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 1000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .notification.show {
        transform: translateX(0);
    }

    .notification.success {
        background: var(--success);
    }

    .notification.error {
        background: #e53e3e;
    }

    .notification.info {
        background: var(--accent-primary);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        body {
            grid-template-columns: 80px 1fr;
        }
        
        .logo {
            width: 120px;
        }

        .pricing-grid {
            grid-template-columns: repeat(2, 1fr);
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
            border-right: none;
            border-bottom: 1px solid var(--border-color);
        }

        .pricing-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease;
    }
</style>
<body>
    <!-- Notification System -->
    <div class="notification" id="notification"></div>

    <!-- Sidebar Include -->
    <?php include('../home.php'); ?>

    <header class="header">
        <div class="logo">
            <img src="../assets/IMAGES/fast-fit.png" style="background:none;width: 100%;" alt="Fast Fit Gym Logo">
        </div>
        <span class="big_title"><h4>Membership Plans</h4></span>
        
    </header>
    
    <main>
        <!-- Plan Templates Section -->
        <!-- Ready-Made Plans Section -->
<section class="my-5">
    <div class="text-center mb-4">
        <h2>Ready-Made Plans</h2>
        <p>Choose from our most popular membership packages</p>
    </div>
    <div class="row g-4">
        <?php foreach ($planTemplates as $key => $template):
            $isExisting = false;
            foreach ($existingPlans as $existing) {
                if ($existing['type'] === $template['name']) {
                    $isExisting = true;
                    break;
                }
            }
        ?>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header text-center p-4" style="background: <?= $template['color'] ?>; color:white;">
                    <i class="fas <?= $template['icon'] ?> fa-2x mb-2"></i>
                    <h5 class="card-title mb-2"><?= $template['name'] ?></h5>
                    <p class="mb-0 small"><?= $template['description'] ?></p>
                    <h3 class="mt-3">$<?= number_format($template['price'], 2) ?> <small>/ <?= $template['duration'] ?> mo</small></h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-3">
                        <?php foreach ($template['features'] as $feature): ?>
                        <li><i class="fas fa-check text-success me-2"></i><?= $feature ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button class="btn w-100 <?= $isExisting ? 'btn-secondary' : 'btn-primary' ?>" <?= $isExisting ? 'disabled' : '' ?>>
                        <?= $isExisting ? 'Plan Active' : 'Add Plan' ?>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Existing Plans Section -->
<?php if (!empty($existingPlans)): ?>
<section class="my-5">
    <div class="text-center mb-4">
        <h2>Active Plans</h2>
        <p>Manage your currently active membership plans</p>
    </div>
    <div class="row g-4">
        <?php foreach ($existingPlans as $plan):
            $memberCount = 0;
            foreach ($planStats as $stat) {
                if ($stat['type'] === $plan['type']) {
                    $memberCount = $stat['member_count'];
                    break;
                }
            }
        ?>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header text-center p-3">
                    <h5 class="card-title mb-1"><?= htmlspecialchars($plan['type']) ?></h5>
                    <h4 class="mb-1 text-primary">$<?= number_format($plan['price'], 2) ?></h4>
                    <small class="text-muted"><?= htmlspecialchars($plan['duration']) ?> months duration</small>
                </div>
                <div class="card-body">
                    <p class="text-secondary"><?= htmlspecialchars($plan['description']) ?></p>
                    <div class="d-flex align-items-center gap-2 text-muted">
                        <i class="fas fa-users"></i> <?= $memberCount ?> active members
                    </div>
                    <button class="btn btn-outline-danger w-100 mt-3">Remove Plan</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

        <!-- Existing Plans Section -->
        <?php if (!empty($existingPlans)): ?>
        <section class="fade-in-up">
            <div class="section-header text-center">
                <h2 class="section-title">Active Plans</h2>
                <p class="section-subtitle">Manage your currently active membership plans</p>
            </div>
            
            <div class="pricing-grid" id="existing-plans-grid">
                <?php foreach ($existingPlans as $plan): 
                    $memberCount = 0;
                    foreach ($planStats as $stat) {
                        if ($stat['type'] === $plan['type']) {
                            $memberCount = $stat['member_count'];
                            break;
                        }
                    }
                ?>
                <div class="pricing-card" id="plan-<?= $plan['membership_id'] ?>">
                    <div class="plan-header">
                        <h3 class="plan-name"><?= htmlspecialchars($plan['type']) ?></h3>
                        <div class="plan-price-wrapper">
                            <span class="currency">$</span>
                            <span class="amount"><?= number_format($plan['price'], 2) ?></span>
                        </div>
                        <div class="period mt-2"><?= htmlspecialchars($plan['duration']) ?> months duration</div>
                    </div>
                    
                    <div class="plan-features">
                        <p class="text-secondary"><?= htmlspecialchars($plan['description']) ?></p>
                        <div class="mt-3 d-flex align-items-center gap-2 text-primary">
                            <i class="fas fa-users"></i>
                            <strong><?= $memberCount ?></strong> active members
                        </div>
                    </div>
                    
                    <button class="btn-plan btn-outline-plan remove-plan-btn" 
                            data-plan-id="<?= $plan['membership_id'] ?>"
                            data-plan-name="<?= htmlspecialchars($plan['type']) ?>">
                        <i class="fas fa-trash-alt"></i> Remove Plan
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Custom Plan Section -->
        <section class="custom-plan-banner fade-in-up">
            <div class="custom-content">
                <h2 class="mb-3">Need a Custom Solution?</h2>
                <p class="mb-4 opacity-75">Create a bespoke membership plan tailored to specific requirements.</p>
                <button class="btn-white" onclick="openCustomPlanModal()">
                    <i class="fas fa-magic me-2"></i> Create Custom Plan
                </button>
            </div>
        </section>
    </main>

    <!-- Custom Plan Modal -->
    <div class="modal fade" id="customPlanModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Custom Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="customPlanForm">
                        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Plan Name</label>
                                <input type="text" name="plan_name" class="form-control" required 
                                       placeholder="e.g., Premium Plus" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Monthly Price ($)</label>
                                <input type="number" name="price" class="form-control" required 
                                       min="0" step="0.01" placeholder="99.99">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" 
                                          placeholder="Describe this plan's benefits..." maxlength="500"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Duration (months)</label>
                                <select name="duration" class="form-select" required>
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Service Type</label>
                                <input type="text" name="service_name" class="form-control" required 
                                       placeholder="e.g., Premium Membership" maxlength="255">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Key Features (one per line)</label>
                                <textarea name="features" class="form-control" rows="4" 
                                          placeholder="24/7 Access&#10;Personal Trainer&#10;Nutrition Coaching"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="createCustomPlan()">
                        Create Plan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Notification system
        function showNotification(message, type = 'info', duration = 4000) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type} show`;
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, duration);
        }

        

        // Use template plan with AJAX
        document.querySelectorAll('.use-template-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const templateKey = this.dataset.templateKey;
                const templateCard = document.getElementById(`template-${templateKey}`);
                
                // Show loading state
                this.innerHTML = '<span class="spinner"></span> Adding...';
                this.disabled = true;
                templateCard.classList.add('loading');
                
                // AJAX request
                fetch('../assets/include/script.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `csrf=<?= htmlspecialchars($_SESSION['csrf_token']) ?>&btn_use_template=1&template_key=${templateKey}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success state
                        templateCard.classList.remove('loading');
                        templateCard.classList.add('success');
                        this.innerHTML = '<i class="fas fa-check me-2"></i>Plan Added';
                        
                        showNotification(data.message, 'success');
                        
                        // Refresh existing plans section after a delay
                        setTimeout(() => {
                            refreshExistingPlans();
                        }, 1000);
                        
                        // Show next steps notification
                        setTimeout(() => {
                            showNotification('✨ Next: Assign this plan to members or set it as default for new signups', 'info', 6000);
                        }, 1500);
                    } else {
                        // Error state
                        templateCard.classList.remove('loading');
                        this.innerHTML = '<i class="fas fa-plus me-2"></i>Use This Plan';
                        this.disabled = false;
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    templateCard.classList.remove('loading');
                    this.innerHTML = '<i class="fas fa-plus me-2"></i>Use This Plan';
                    this.disabled = false;
                    showNotification('An error occurred. Please try again.', 'error');
                });
            });
        });

        // Remove plan with AJAX
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-plan-btn') || e.target.closest('.remove-plan-btn')) {
                const btn = e.target.classList.contains('remove-plan-btn') ? e.target : e.target.closest('.remove-plan-btn');
                const planId = btn.dataset.planId;
                const planName = btn.dataset.planName;
                
                if (confirm(`Are you sure you want to remove "${planName}"? This will not affect existing members with this plan.`)) {
                    // Show loading state
                    btn.innerHTML = '<span class="spinner"></span>';
                    btn.disabled = true;
                    
                    // AJAX request
                    fetch('../assets/include/script.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `csrf=<?= htmlspecialchars($_SESSION['csrf_token']) ?>&id_sup_plan=${planId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove plan card
                            document.getElementById(`plan-${planId}`).remove();
                            showNotification(data.message, 'success');
                            
                            // Refresh template buttons if this was a template plan
                            refreshTemplateButtons();
                        } else {
                            btn.innerHTML = '<i class="fas fa-times"></i>';
                            btn.disabled = false;
                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        btn.innerHTML = '<i class="fas fa-times"></i>';
                        btn.disabled = false;
                        showNotification('An error occurred. Please try again.', 'error');
                    });
                }
            }
        });

        // Refresh existing plans section
        function refreshExistingPlans() {
            fetch('get_plans.php')
                .then(response => response.text())
                .then(html => {
                    const existingSection = document.querySelector('.existing-plans-section');
                    if (existingSection) {
                        existingSection.querySelector('.plans-grid').innerHTML = html;
                    } else {
                        // Create existing plans section if it doesn't exist
                        const templatesSection = document.querySelector('.templates-section');
                        const newSection = document.createElement('section');
                        newSection.className = 'existing-plans-section fade-in-up';
                        newSection.innerHTML = `
                            <div class="section-header">
                                <h2 class="section-title">Current Plans</h2>
                                <p class="section-subtitle">Plans currently available in your system</p>
                            </div>
                            <div class="plans-grid">${html}</div>
                        `;
                        templatesSection.after(newSection);
                    }
                });
        }

        // Refresh template buttons (enable/disable based on existing plans)
        function refreshTemplateButtons() {
            // This would require an API call to check which templates are already used
            // For now, we'll just refresh the page to get updated state
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        // Open custom plan modal
        function openCustomPlanModal() {
            const modal = new bootstrap.Modal(document.getElementById('customPlanModal'));
            modal.show();
        }

        // Create custom plan
        function createCustomPlan() {
            const form = document.getElementById('customPlanForm');
            const formData = new FormData(form);
            
            // Show loading state
            const submitBtn = document.querySelector('#customPlanModal .btn-primary');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner"></span> Creating...';
            submitBtn.disabled = true;
            
            fetch('../assets/include/script.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    bootstrap.Modal.getInstance(document.getElementById('customPlanModal')).hide();
                    form.reset();
                    
                    // Refresh the page to show new plan
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // Add hover effects
        document.querySelectorAll('.template-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>