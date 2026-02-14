<?php 
session_start();
include('../assets/include/script.php');

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Prepare server-side stats
try {
    $totalStmt = $con->query("SELECT COUNT(*) AS total FROM members");
    $total = (int)$totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

    $active = 0;
    $hasStatusColumn = false;
    try {
        $colCheck = $con->query("SHOW COLUMNS FROM members LIKE 'status'");
        if ($colCheck->rowCount() > 0) {
            $hasStatusColumn = true;
            $activeStmt = $con->query("SELECT COUNT(*) AS active FROM members WHERE status = 'active'");
            $active = (int)$activeStmt->fetch(PDO::FETCH_ASSOC)['active'];
        }
    } catch (\Throwable $e) {
        // ignore - keep $active = 0
    }

    // New this month
    $newStmt = $con->prepare("SELECT COUNT(*) AS newm FROM members WHERE MONTH(join_date) = MONTH(CURDATE()) AND YEAR(join_date) = YEAR(CURDATE())");
    $newStmt->execute();
    $newThisMonth = (int)$newStmt->fetch(PDO::FETCH_ASSOC)['newm'];

    // Fetch all members
    $req = $con->query("SELECT * FROM `members` ORDER BY member_id DESC");
    $members = $req->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $e) {
    $total = $active = $newThisMonth = 0;
    $members = [];
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <title>Members Management</title>
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
        display: flex;
        flex-direction: column;
        gap: 20px;
        overflow-y: auto;
    }

    /* Stats Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 10px;
    }

    .stat-card {
        background: var(--bg-card);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid var(--border-color);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .stat-number {
        font-size: 2.2em;
        font-weight: bold;
        color: var(--accent-primary);
        margin: 8px 0;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.85em;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Action Bar */
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--bg-card);
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: 1px solid var(--border-color);
    }

    .page-title h4 {
        color: var(--text-primary);
        margin: 0;
        font-weight: 600;
    }

    .page-title small {
        color: var(--text-secondary);
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-secondary) 100%);
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        border: 2px solid var(--text-secondary);
        color: var(--text-secondary);
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background: var(--text-secondary);
        color: var(--bg-primary);
        border-color: var(--text-secondary);
    }

    /* Add Member Form */
    .add-member-form {
        display: none;
        background: var(--bg-card);
        border-radius: 12px;
        padding: 25px;
        margin-top: 10px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        border: 1px solid var(--border-color);
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-header {
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    .form-header h3 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-header p {
        color: var(--text-secondary);
        margin: 0;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .form-group {
        position: relative;
        margin-bottom: 20px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
        font-size: 14px;
        color: var(--text-primary);
    }

    .form-control:focus {
        border-color: var(--accent-primary);
        background: var(--bg-secondary);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        color: var(--text-primary);
    }

    .form-label {
        position: absolute;
        top: -10px;
        left: 12px;
        background: var(--bg-card);
        padding: 0 8px;
        font-size: 12px;
        color: var(--accent-primary);
        font-weight: 500;
    }

    .gender-group {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-top: 10px;
    }

    .gender-option {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: var(--text-primary);
        padding: 8px 15px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .gender-option:hover {
        border-color: var(--accent-primary);
    }

    .gender-option.selected {
        border-color: var(--accent-primary);
        background: rgba(102, 126, 234, 0.1);
    }

    /* Table Container */
    .table-container {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: 1px solid var(--border-color);
        overflow-x: auto;
    }

    /* DataTables Customization */
    .dataTables_wrapper {
        color: var(--text-primary);
    }

    .dataTables_filter input {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
        border-radius: 6px;
        padding: 8px 12px;
    }

    .dataTables_length select {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
        border-radius: 6px;
        padding: 6px;
    }

    .table {
        color: var(--text-primary) !important;
        margin-bottom: 0;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.1) !important;
    }

    .table-dark {
        --bs-table-bg: var(--bg-secondary) !important;
        --bs-table-border-color: var(--border-color) !important;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .btn-sm {
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .btn-outline-success {
        border-color: #198754;
        color: #198754;
    }

    .btn-outline-success:hover {
        background: #198754;
        color: white;
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
    }

    /* Badges */
    .badge {
        font-size: 0.75em;
        padding: 6px 12px;
        border-radius: 8px;
    }

    /* Alerts */
    .alert {
        border: none;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: linear-gradient(135deg, #198754 0%, #157347 100%);
        color: white;
    }

    .alert-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
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
        
        .action-bar {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .stats-cards {
            grid-template-columns: 1fr;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .gender-group {
            flex-direction: column;
            gap: 10px;
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
    }

    @media (max-width: 480px) {
        .table-container {
            padding: 10px;
            margin: 0 -10px;
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
        
        .action-bar {
            padding: 12px;
        }
        
        .stat-card {
            padding: 15px;
        }
        
        .form-header h3 {
            font-size: 1.3em;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 4px;
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
</style>
<body class="dark-mode">
    <!-- Sidebar Include -->
    <?php include('../home.php'); ?>

    <header class="header">
        <div class="logo">
            <img src="../assets/IMAGES/fast-fit.png" style="background:none;width: 100%; filter: brightness(0) invert(1)" alt="logo">
        </div>
        <span class="big_title"><h4>Members Management</h4></span>
        
    </header>
    
    <main>
        <!-- Success/Error Messages -->
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> 
                <?php 
                switch($_GET['success']) {
                    case '1': echo 'Member added successfully!'; break;
                    case '2': echo 'Member updated successfully!'; break;
                    case '3': echo 'Member deleted successfully!'; break;
                    default: echo 'Operation completed successfully!';
                }
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> 
                <?php 
                switch($_GET['error']) {
                    case '1': echo 'Failed to add member.'; break;
                    case '2': echo 'Failed to update member.'; break;
                    case '3': echo 'Failed to delete member.'; break;
                    default: echo 'Operation failed.';
                }
                if(isset($_GET['message'])) {
                    echo ' ' . htmlspecialchars($_GET['message']);
                }
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number" id="total-members"><?= (int)$total ?></div>
                <div class="stat-label">Total Members</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="active-members"><?= (int)$active ?></div>
                <div class="stat-label">Active Members</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="new-this-month"><?= (int)$newThisMonth ?></div>
                <div class="stat-label">New This Month</div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <div class="page-title">
                <h4>Members List</h4>
                <small>Manage your gym members efficiently</small>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-outline-secondary" onclick="exportData()">
                    <i class="fas fa-download me-2"></i>Export
                </button>
                <button class="btn btn-primary" id="openAddMemberBtn" onclick="toggleAddMemberForm()">
                    <i class="fas fa-plus me-2"></i>Add Member
                </button>
            </div>
        </div>

        <!-- Add Member Form (Hidden by Default) -->
        <div class="add-member-form" id="addMemberForm" aria-hidden="true">
            <div class="form-header">
                <h3 id="formTitle">Add New Member</h3>
                <p>Fill in the member details below</p>
            </div>
            
            <form action="../assets/include/script.php" method="POST" id="memberForm" autocomplete="off">
                <!-- CSRF token -->
                <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                <!-- mode and id -->
                <input type="hidden" name="member_id" id="member_id" value="">
                
                <div class="form-grid">
                    <div class="form-group">
                        <input type="text" name="firstname" class="form-control" required maxlength="150" pattern="[A-Za-z\s]+" title="Only letters and spaces allowed">
                        <label class="form-label">First Name</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="lastname" class="form-control" required maxlength="150" pattern="[A-Za-z\s]+" title="Only letters and spaces allowed">
                        <label class="form-label">Last Name</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" required maxlength="255">
                        <label class="form-label">Email Address</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="tel" name="phone_num" class="form-control" required maxlength="20" pattern="[0-9+\-\s]+" title="Valid phone number required">
                        <label class="form-label">Mobile Phone</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="address" class="form-control" required>
                        <label class="form-label">Address</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="date" name="join_date" class="form-control" required max="<?= date('Y-m-d') ?>">
                        <label class="form-label">Start Date</label>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <div class="gender-group">
                            <label class="gender-option">
                                <input type="radio" name="gender" value="Male" required> Male
                            </label>
                            <label class="gender-option">
                                <input type="radio" name="gender" value="Female" required> Female
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2 justify-content-end flex-wrap mt-2">
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleAddMemberForm()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" name="btn_ajouter_member" id="formSubmitBtn">
                        <i class="fas fa-save me-2"></i>Save Member
                    </button>
                    <button type="submit" class="btn btn-primary" name="btn_edit_member" id="formEditBtn" style="display: none;">
                        <i class="fas fa-sync me-2"></i>Update Member
                    </button>
                </div>
            </form>
        </div>

        <!-- Members Table -->
        <div class="table-container">
            <table id="myTable" class="table table-hover w-100">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Join Date</th>
                        <th scope="col">Gender</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $value): ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars((string)$value['member_id'], ENT_QUOTES, 'UTF-8') ?></th>
                        <td><?= htmlspecialchars($value['firstname'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($value['lastname'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($value['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($value['phone_num'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= !empty($value['join_date']) ? htmlspecialchars(date('M j, Y', strtotime($value['join_date'])), ENT_QUOTES, 'UTF-8') : '' ?></td>
                        <td>
                            <span class="badge bg-<?= ($value['gender'] ?? '') === 'Male' ? 'primary' : 'success' ?>">
                                <?= htmlspecialchars($value['gender'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td class="text-center action-buttons">
                            <!-- Edit button populates the add/edit form -->
                            <button
                                class="btn btn-sm btn-outline-success btn-edit"
                                data-id="<?= htmlspecialchars((string)$value['member_id'], ENT_QUOTES, 'UTF-8') ?>"
                                data-firstname="<?= htmlspecialchars($value['firstname'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-lastname="<?= htmlspecialchars($value['lastname'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-email="<?= htmlspecialchars($value['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-phone_num="<?= htmlspecialchars($value['phone_num'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-address="<?= htmlspecialchars($value['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-join_date="<?= htmlspecialchars($value['join_date'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-gender="<?= htmlspecialchars($value['gender'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>

                            <!-- Delete - POST form with CSRF -->
                            <form method="POST" action="../assets/include/script.php" style="display:inline-block" onsubmit="return confirm('Are you sure you want to delete this member? This action cannot be undone.')">
                                <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="id_sup_member" value="<?= htmlspecialchars((string)$value['member_id'], ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#myTable').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Search members:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ members"
                },
                "responsive": true,
                "order": [[0, 'desc']]
            });

            // Gender selection styling
            $('input[name="gender"]').change(function() {
                $('.gender-option').removeClass('selected');
                $(this).closest('.gender-option').addClass('selected');
            });

            // Edit button functionality
            $('.btn-edit').click(function(){
                // Populate form with member data
                const $btn = $(this);
                $('#member_id').val($btn.data('id'));
                $('input[name="firstname"]').val($btn.data('firstname'));
                $('input[name="lastname"]').val($btn.data('lastname'));
                $('input[name="email"]').val($btn.data('email'));
                $('input[name="phone_num"]').val($btn.data('phone_num'));
                $('input[name="address"]').val($btn.data('address'));
                $('input[name="join_date"]').val($btn.data('join_date'));
                
                // Set gender and update styling
                $('input[name="gender"][value="' + $btn.data('gender') + '"]').prop('checked', true).trigger('change');
                
                // Update UI
                $('#formTitle').text('Edit Member');
                $('#formSubmitBtn').hide();
                $('#formEditBtn').show();

                // Show the form
                toggleAddMemberForm();

                // Scroll to form
                $('html, body').animate({
                    scrollTop: $("#addMemberForm").offset().top - 100
                }, 500);
            });

            // Dark mode toggle
            $('#darkModeToggle').click(function() {
                $('body').toggleClass('light-mode');
                if ($('body').hasClass('light-mode')) {
                    $(this).html('<i class="fas fa-moon me-2"></i>Dark Mode');
                    localStorage.setItem('theme', 'light');
                } else {
                    $(this).html('<i class="fas fa-sun me-2"></i>Light Mode');
                    localStorage.setItem('theme', 'dark');
                }
            });

            // Load saved theme
            if (localStorage.getItem('theme') === 'light') {
                $('body').addClass('light-mode');
                $('#darkModeToggle').html('<i class="fas fa-moon me-2"></i>Dark Mode');
            }

            // Form validation
            $('#memberForm').on('submit', function(e) {
                const joinDate = new Date($('input[name="join_date"]').val());
                const today = new Date();
                if (joinDate > today) {
                    e.preventDefault();
                    alert('Join date cannot be in the future.');
                    return false;
                }
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        });

        function toggleAddMemberForm() {
            const form = $('#addMemberForm');
            if (form.is(':visible')) {
                form.slideUp(300);
                // Clear form when hiding and reset to add mode
                form.find('form')[0].reset();
                $('#member_id').val('');
                $('#formTitle').text('Add New Member');
                $('#formSubmitBtn').show();
                $('#formEditBtn').hide();
                $('.gender-option').removeClass('selected');
                form.attr('aria-hidden', 'true');
            } else {
                form.slideDown(300);
                form.attr('aria-hidden', 'false');
            }
        }

        function updateStats() {
            // Stats are server-rendered; this function kept if you want dynamic updates later
        }

        function exportData() {
            if (confirm('Export members data to CSV?')) {
                alert('Export functionality would generate a secure CSV download');
            }
        }

        // Input sanitization helper
        function sanitizeInput(input) {
            return input.replace(/[<>]/g, '');
        }

        // Auto-sanitize inputs
        $('input[type="text"]').on('input', function() {
            this.value = sanitizeInput(this.value);
        });
    </script>
</body>
</html>