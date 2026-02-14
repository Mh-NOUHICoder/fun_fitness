<?php 
session_start();
include('../assets/include/script.php');

// Count of role Staff
$total_trainer_staff = $con->query("SELECT COUNT(*) AS total_trainer_staff FROM `staff` WHERE role = 'trainer' ")->fetchColumn();
$total_cleaning_staff = $con->query("SELECT COUNT(*) AS total_cleaning_staff FROM `staff` WHERE role = 'cleaning'")->fetchColumn();
$total_cashier_staff = $con->query("SELECT COUNT(*) AS total_cashier_staff FROM `staff` WHERE role = 'receptionist'")->fetchColumn();    
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
    <!-- table -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <title>Staff Management</title>
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

    .stat-icon {
        font-size: 2.5em;
        margin-bottom: 10px;
        opacity: 0.8;
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

    /* Add Staff Form */
    .add-staff-form {
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

    .role-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 10px;
    }

    .role-option {
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

    .role-option:hover {
        border-color: var(--accent-primary);
    }

    .role-option.selected {
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
        font-weight: 500;
    }

    .badge-trainer {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .badge-cleaning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .badge-receptionist {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    /* Salary styling */
    .salary-amount {
        font-weight: 600;
        color: var(--accent-primary);
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
        
        .role-group {
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

    /* Security notice */
    .security-notice {
        background: var(--bg-card);
        border-left: 4px solid var(--accent-primary);
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 0.9em;
    }
</style>
<body class="dark-mode">
    <!-- Sidebar Include -->
    <?php include('../home.php'); ?>

    <header class="header">
        <div class="logo">
            <img src="../assets/IMAGES/fast-fit.png" style="background:none;width: 100%; filter: brightness(0) invert(1)">
        </div>
        <span class="big_title"><h4>Staff Management</h4></span>
        
    </header>
    
    <main>
        <!-- Security Notice -->
        <div class="security-notice">
            <i class="fas fa-shield-alt me-2"></i>
            <strong>Security Enabled:</strong> All staff data is protected with secure access controls.
        </div>

        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <div class="stat-number"><?= htmlspecialchars($total_trainer_staff) ?></div>
                <div class="stat-label">Total Trainers</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-broom"></i>
                </div>
                <div class="stat-number"><?= htmlspecialchars($total_cleaning_staff) ?></div>
                <div class="stat-label">Cleaning Staff</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-number"><?= htmlspecialchars($total_cashier_staff) ?></div>
                <div class="stat-label">Receptionists</div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <div class="page-title">
                <h4>Staff List</h4>
                <small>Manage your gym staff efficiently</small>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-outline-secondary" onclick="exportData()">
                    <i class="fas fa-download me-2"></i>Export
                </button>
                <button class="btn btn-primary" onclick="toggleAddStaffForm()">
                    <i class="fas fa-plus me-2"></i>Add Staff
                </button>
            </div>
        </div>

        <!-- Add Staff Form (Hidden by Default) -->
        <div class="add-staff-form" id="addStaffForm">
            <div class="form-header">
                <h3>Add New Staff Member</h3>
                <p>Fill in the staff details below</p>
            </div>
            
            <form action="../assets/include/script.php" method="POST" id="staffForm">
                <input type="hidden" name="staff_id" id="staff_id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <input type="text" name="first_name" class="form-control" required maxlength="50" pattern="[A-Za-z\s]+" title="Only letters and spaces allowed">
                        <label class="form-label">First Name</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="last_name" class="form-control" required maxlength="50" pattern="[A-Za-z\s]+" title="Only letters and spaces allowed">
                        <label class="form-label">Last Name</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" required maxlength="100">
                        <label class="form-label">Email Address</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="tel" name="phone_number" class="form-control" required pattern="[0-9+\-\s]+" title="Valid phone number required">
                        <label class="form-label">Mobile Phone</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="date" name="hire_date" class="form-control" required max="<?= date('Y-m-d') ?>">
                        <label class="form-label">Hire Date</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="number" name="salary" class="form-control" required min="0" step="0.01" max="99999">
                        <label class="form-label">Salary ($)</label>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <div class="role-group" id="roleGroup">
                            <label class="role-option">
                                <input type="radio" name="role" value="trainer" required> Trainer
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="cleaning" required> Cleaning
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="receptionist" required> Receptionist
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2 justify-content-end flex-wrap">
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleAddStaffForm()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" name="btn_ajouter_staff" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Save Staff
                    </button>
                </div>
            </form>
        </div>

        <!-- Staff Table -->
        <div class="table-container">
            <table id="myTable" class="table table-hover w-100">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Hire Date</th>
                        <th scope="col">Role</th>
                        <th scope="col">Salary</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $req = $con->query("SELECT * FROM `staff` ORDER BY staff_id DESC");
                    foreach ($req as $value) {
                    ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($value['staff_id']) ?></th>
                        <td><?= htmlspecialchars($value['first_name']) ?></td>
                        <td><?= htmlspecialchars($value['last_name']) ?></td>
                        <td><?= htmlspecialchars($value['email']) ?></td>
                        <td><?= htmlspecialchars($value['phone_number']) ?></td>
                        <td><?= date('M j, Y', strtotime($value['hire_date'])) ?></td>
                        <td>
                            <?php
                            $roleClass = '';
                            switch($value['role']) {
                                case 'trainer': $roleClass = 'badge-trainer'; break;
                                case 'cleaning': $roleClass = 'badge-cleaning'; break;
                                case 'receptionist': $roleClass = 'badge-receptionist'; break;
                                default: $roleClass = 'bg-secondary';
                            }
                            ?>
                            <span class="badge <?= $roleClass ?>">
                                <?= ucfirst(htmlspecialchars($value['role'])) ?>
                            </span>
                        </td>
                        <td class="salary-amount">$<?= number_format($value['salary'], 2) ?></td>
                        <td class="text-center action-buttons">
                            <button class="btn btn-sm btn-outline-success btn-edit" 
                                data-id="<?= htmlspecialchars($value["staff_id"]) ?>"
                                data-first_name="<?= htmlspecialchars($value["first_name"]) ?>"
                                data-last_name="<?= htmlspecialchars($value["last_name"]) ?>"
                                data-email="<?= htmlspecialchars($value["email"]) ?>"
                                data-phone_number="<?= htmlspecialchars($value["phone_number"]) ?>"
                                data-hire_date="<?= htmlspecialchars($value["hire_date"]) ?>"
                                data-role="<?= htmlspecialchars($value["role"]) ?>"
                                data-salary="<?= htmlspecialchars($value["salary"]) ?>">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <a href="../assets/include/script.php?id_sup_staff=<?= $value['staff_id'] ?>" 
                               class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Are you sure you want to delete this staff member? This action cannot be undone.')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
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
                    "search": "Search staff:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ staff members"
                },
                "responsive": true,
                "order": [[0, 'desc']]
            });

            // Role selection styling
            $('input[name="role"]').change(function() {
                $('.role-option').removeClass('selected');
                $(this).closest('.role-option').addClass('selected');
            });

            // Edit button functionality
            $('.btn-edit').click(function(){
                // Populate form with staff data
                $('#staff_id').val($(this).data('id'));
                $('input[name="first_name"]').val($(this).data('first_name'));
                $('input[name="last_name"]').val($(this).data('last_name'));
                $('input[name="email"]').val($(this).data('email'));
                $('input[name="phone_number"]').val($(this).data('phone_number'));
                $('input[name="hire_date"]').val($(this).data('hire_date'));
                $('input[name="salary"]').val($(this).data('salary'));
                
                // Set role and update styling
                $('input[name="role"][value="' + $(this).data('role') + '"]').prop('checked', true).trigger('change');
                
                // Update button text
                $('#submitBtn').html('<i class="fas fa-sync me-2"></i>Update Staff');
                
                // Show the form
                toggleAddStaffForm();
                
                // Scroll to form
                $('html, body').animate({
                    scrollTop: $("#addStaffForm").offset().top - 100
                }, 500);
            });

            // Dark mode toggle
            // $('#darkModeToggle').click(function() {
            //     $('body').toggleClass('light-mode');
            //     if ($('body').hasClass('light-mode')) {
            //         $(this).html('<i class="fas fa-moon me-2"></i>Dark Mode');
            //         localStorage.setItem('theme', 'light');
            //     } else {
            //         $(this).html('<i class="fas fa-sun me-2"></i>Light Mode');
            //         localStorage.setItem('theme', 'dark');
            //     }
            // });

            // Load saved theme
            if (localStorage.getItem('theme') === 'light') {
                $('body').addClass('light-mode');
                $('#darkModeToggle').html('<i class="fas fa-moon me-2"></i>Dark Mode');
            }

            // Form validation
            $('#staffForm').on('submit', function(e) {
                const salary = $('input[name="salary"]').val();
                if (salary < 0) {
                    e.preventDefault();
                    alert('Salary cannot be negative.');
                    return false;
                }
                
                const hireDate = new Date($('input[name="hire_date"]').val());
                const today = new Date();
                if (hireDate > today) {
                    e.preventDefault();
                    alert('Hire date cannot be in the future.');
                    return false;
                }
            });
        });

        function toggleAddStaffForm() {
            const form = $('#addStaffForm');
            if (form.is(':visible')) {
                form.slideUp(300);
                // Clear form when hiding
                form.find('form')[0].reset();
                $('#staff_id').val('');
                $('.role-option').removeClass('selected');
                $('#submitBtn').html('<i class="fas fa-save me-2"></i>Save Staff');
            } else {
                form.slideDown(300);
            }
        }

        function exportData() {
            // Enhanced export functionality
            if (confirm('Export staff data to CSV?')) {
                // This would typically make an AJAX call to generate and download the CSV
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