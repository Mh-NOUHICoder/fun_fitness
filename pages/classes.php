<?php

session_start();

include('../assets/include/script.php');

// Get class statistics
$total_classes = $con->query("SELECT COUNT(*) AS total_classes FROM `classes`")->fetchColumn();
$active_classes = $total_classes; // Assuming all classes are active
$upcoming_classes = $total_classes; // Assuming all are upcoming for demo

// Get staff for dropdown
$staff_stmt = $con->query("SELECT staff_id, first_name FROM staff");
$staff = $staff_stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Classes Management</title>
    <link rel="shortcut icon" type="x-icon" href="../assets/IMAGES/logo-icon.png">
</head>
<style>
    :root{
    --clr-primary:#667eea; /* Updated to match dashboard theme */
    --clr-dangerd:#ea3b3b;
    --clr-success:#6cf856;
    --clr-white:#fff;
    --clr-gray:#0a0a0a92;
    --clr-info-dark:hsl(100, 1%, 10%);
    --clr-warning:#ff9bac;
    --clr-light:rgba(254, 250, 250, 0.18);

    --card-border-radius:2rem;
    --border-radius-1: 0.4rem;
    --border-radius-2:0.8rem;
    --border-radius-3:1.2rem;

    --card-padding:1.8rem;
    --padding-1:1.2rem;
    --box-shadow: 0 2rem 3rem var(--clr-light);

    /* Theme Variables (Default Dark) */
    --bg-body: #1a1d28;
    --text-main: #ffffff;
    --card-bg: rgba(0, 0, 0, 0.477);
    --card-shadow-inset: 0px 0px 7px #ffffff52;
    --table-header-bg: rgba(255, 255, 255, 0.1);
    --table-row-hover: rgba(255, 255, 255, 0.05);
    --input-bg: rgba(255, 255, 255, 0.05);
    --input-border: rgba(255, 255, 255, 0.2);
    --modal-bg: rgba(0, 0, 0, 0.9);
    --scroll-color: #667eea;
    }

    *{
    padding: 0 ;
    margin: 0;
    box-sizing: border-box;
    
    }
    html{
    scroll-behavior: smooth;
    }
    
    /* Use global font */
    body {
        font-family: 'Montserrat', sans-serif;
    }

    /* scroll style */
    .scroll-w{
    height: 4px;
    position: fixed;
    top: 0;
    z-index: 1000;
    background-color: var(--scroll-color);
    width: 100%;
    scale: 0 1;
    animation: scroll-w linear;
    animation-timeline: scroll();
    }
    @keyframes scroll-w {
    to{ scale: 1 1;}
    }
    /* end style of scroll */

    .logo img {
        width: 140px;
    }

    
    /* dark button */
    body.light-mode {
        --bg-body: #f8f9fa;
        --text-main: #2d3446;
        --clr-white: #2d3446; /* Invert text color for light mode */
        --card-bg: rgba(255, 255, 255, 0.8);
        --card-shadow-inset: 0px 0px 7px rgba(0,0,0,0.1);
        --table-header-bg: rgba(0, 0, 0, 0.05);
        --table-row-hover: rgba(0, 0, 0, 0.02);
        --input-bg: #ffffff;
        --input-border: #ced4da;
        --modal-bg: rgba(255, 255, 255, 0.95);
        --scroll-color: #4444e2;
    } 

    .btn-dark-mode {
    position: absolute;
    bottom: 3rem;
    display: grid;
    place-items: center;
    background: #e3edf7;
    width: 30px;
    height: 30px;
    margin: 2rem;
    padding: 1.4em;
    border-radius: 50%;
    border: 1px solid rgba(0,0,0,0);
    cursor: pointer;
    transition: transform 0.5s;
    }

    .btn-dark-mode:hover {
    box-shadow: inset 4px 4px 6px -1px rgba(0,0,0,0.2),
            inset -4px -4px 6px -1px rgba(255,255,255,0.7),
            -0.5px -0.5px 0px rgba(255,255,255,1),
            0.5px 0.5px 0px rgba(0,0,0,0.15),
            0px 12px 10px -10px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.1);
    transform: translateY(0.5em);
    }

    .btn-dark-mode i {
    position: absolute;
    top: 15px;
    right: 10px;
    width: 25px;
    height: 25px;
    transition: transform 0.5s;
    }
     
    .btn-dark-mode:hover i {
    transform: scale(0.9);
    fill: #333333;
    }
    /* end style of dark btn */

    
    body{
        background-color: var(--bg-body);
        color: var(--text-main);
        height: 90vh;
        display: grid;
        grid-template-columns: 150px 1fr;
        grid-template-rows: 70px 1fr;
        grid-gap: 10px;
        grid-template-areas: 
            "header header"
            "side main" ;
        }

    /* Responsive Layout */
    @media (max-width: 768px) {
        body {
            grid-template-columns: 1fr;
            grid-template-rows: 60px auto 1fr;
            grid-template-areas: 
                "header"
                "side"
                "main";
            height: auto;
            overflow-y: auto;
            min-height: 100vh;
        }
    }
    /* Header style */

        header{
        grid-area: header;
        background-color: var(--bg-body);
        border-bottom: 1px solid var(--input-border);
        padding: 0 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 10;
        }
        
        .big_title{
            font-weight: 700;
            letter-spacing: 2px;
            margin: 0;
            font-size: 1.5rem;
            text-transform: uppercase;
            flex: 1;
            text-align: center;
        }

        .sidebar {
            grid-area: side;
            min-width: 0; /* Prevent overflow */
        }
    
    /*----------- Main style-------------*/
    main{ 
        grid-area: main ;
        padding: 25px;
        gap: 20px;
        }
   
    .card_dash {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        height: 100%;
        width:100%;
        min-height: 180px;
        padding: 1.5rem;
        border-radius: var(--border-radius-1);
        backdrop-filter:blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background-color: var(--card-bg);
        box-shadow: var(--card-shadow-inset) inset;
        border: 1px solid var(--input-border);
        transition: transform 0.3s ease;
    }
    
    .card_dash:hover {
        transform: translateY(-5px);
    }

    .card_dash_table{
        padding: 20px;
        border-radius: var(--border-radius-1);
        backdrop-filter:blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background-color: var(--card-bg);
        box-shadow: var(--card-shadow-inset) inset;
        border: 1px solid var(--input-border);
    }
    .card_dash i{
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--clr-primary);
    }
    
    .card_dash-text {
        letter-spacing: 2px;
        font-size: 0.9rem;
        opacity: 0.8;
        margin-top: 0.5rem;
        text-transform: uppercase;
    }
    
    .card_dash .card-title{
        font-size: 3rem;
        font-weight: 700;
        margin: 0;
        line-height: 1;
    }
    
    /* Classes Table Styles */
    .classes-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    
    .classes-table th {
        background-color: var(--table-header-bg);
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border-bottom: 1px solid var(--input-border);
        color: var(--text-main);
    }
    
    .classes-table td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--input-border);
        color: var(--text-main);
    }
    
    .classes-table tr:hover {
        background-color: var(--table-row-hover);
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--input-bg);
        color: var(--clr-white);
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        background: var(--clr-primary);
        color: var(--clr-white);
    }
    
    .btn-primary {
        background-color: var(--clr-primary);
        border: none;
        padding: 10px 20px;
        border-radius: var(--border-radius-1);
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #3333cc;
        transform: translateY(-2px);
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        width: 90%;
        max-width: 600px;
        background: var(--modal-bg);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        border: 1px solid var(--input-border);
        color: var(--text-main);
        backdrop-filter: blur(10px);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--input-border);
    }

    .modal-title {
        font-size: 1.4rem;
        font-weight: 600;
    }

    .close-modal {
        background: none;
        border: none;
        color: var(--text-main);
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .close-modal:hover {
        color: var(--clr-dangerd);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 12px 15px;
        background: var(--input-bg);
        border: 1px solid var(--input-border);
        border-radius: 8px;
        color: var(--text-main);
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--clr-primary);
        outline: none;
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 0 3px rgba(68, 68, 226, 0.2);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid var(--input-border);
    }

    .btn-secondary {
        background: var(--input-bg);
        color: var(--text-main);
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    
    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
    }
    
    .alert-success {
        background: rgba(108, 248, 86, 0.2);
        border: 1px solid rgba(108, 248, 86, 0.4);
        color: #6cf856;
    }
    
    .alert-error {
        background: rgba(234, 59, 59, 0.2);
        border: 1px solid rgba(234, 59, 59, 0.4);
        color: #ea3b3b;
    }
    
    @media (min-width:725px) ,(max-width:950px){
        .card_dash{
            gap: 30px; 
        }
        .card_dash_table{
            margin-bottom: 3rem ;
        }
    }
    
    @media (max-width:725px){
        main{
            padding: 15px;
            gap: 15px;
        }
        
        .card_dash{
            min-height: 140px; /* Compact height for mobile */
            padding: 1rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
        header{
            padding: 0 15px;
        }
         .big_title{
            font-size: 1.1rem;
            text-align: right;
        }
        .logo img {
            width: 100px;
        }
    }
     /* End of media */

    /* Header Responsiveness */
    @media (max-width: 768px) {
        /* Creative Card Table for Mobile */
        .classes-table thead {
            display: none;
        }
        
        .classes-table, .classes-table tbody, .classes-table tr, .classes-table td {
            display: block;
            width: 100%;
        }
        
        .classes-table tr {
            margin-bottom: 1rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 1rem;
            border: 1px solid var(--input-border);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .classes-table td {
            padding: 0.5rem 0;
            border: none;
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.95rem;
        }
        
        .classes-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--clr-primary);
            opacity: 0.9;
            margin-right: 1rem;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        /* First cell (Name) acts as card header */
        .classes-table td:first-child {
            text-align: left;
            border-bottom: 1px solid var(--input-border);
            padding-bottom: 0.8rem;
            margin-bottom: 0.5rem;
            justify-content: flex-start;
        }
        
        .classes-table td:first-child::before {
            display: none;
        }

        .classes-table td:last-child {
            justify-content: flex-end;
            padding-top: 0.8rem;
            border-top: 1px solid var(--input-border);
            margin-top: 0.5rem;
        }
    }
    
     
</style>
<body>
    <div class="scroll-w"></div>
    
       
        <!-- sidebar include -->
        <?php 
            include('../home.php');
        ?>
        <!-- Page Content -->
        <!---------------------------------------------- Header Code -->
        <header class="header">
            <div class="logo">
                <img src="../assets/IMAGES/fast-fit.png" alt="Fast Fit Gym">
            </div>
            <h1 class="big_title">Classes Management</h1>
        </header>
        <!----------------------------------------------End of Header Code -->
        
            
        <main class="main text-center">
            <!-- Alert Messages -->
            <div id="alert-message" class="alert" style="display: none;"></div>
            
            <div class="row mt-3">
                <div class="col-12 col-md-4 mb-3">
                    <div class="card_dash">
                        <i class="fa-solid fa-dumbbell"></i>
                        <h1 class="card-title"><?=number_format($total_classes)?></h1>
                        <h6 class="card_dash-text">TOTAL CLASSES</h6>
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <div class="card_dash">
                        <i class="fa-solid fa-check-circle"></i>
                        <h1 class="card-title"><?=number_format($active_classes)?></h1>
                        <h6 class="card_dash-text">ACTIVE CLASSES</h6>
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <div class="card_dash">
                        <i class="fa-solid fa-calendar-alt"></i>
                        <h1 class="card-title"><?=number_format($upcoming_classes)?></h1>
                        <h6 class="card_dash-text">UPCOMING CLASSES</h6>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card_dash_table">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="m-0">All Classes</h3>
                            <button class="btn btn-primary" id="add-class-btn">
                                <i class="fas fa-plus me-2"></i>Add New Class
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="classes-table">
                                <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Description</th>
                                        <th>Instructor</th>
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch classes from database with instructor names
                                    $stmt = $con->query("
                                        SELECT c.*, name as instructor_name 
                                        FROM classes c 
                                        LEFT JOIN staff s ON c.instructor_id = s.staff_id
                                        ORDER BY c.day, c.start_time
                                    ");
                                    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    if (count($classes) > 0) {
                                        foreach ($classes as $class) {
                                            // Format time for display
                                            $start_time = date("g:i A", strtotime($class['start_time']));
                                            $end_time = date("g:i A", strtotime($class['end_time']));
                                            $time_range = $start_time . " - " . $end_time;
                                    ?>
                                    <tr>
                                        <td data-label="Class Name">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <i class="fas fa-dumbbell text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold fs-5"><?= htmlspecialchars($class['name']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Description"><?= htmlspecialchars($class['description']) ?></td>
                                        <td data-label="Instructor"><?= htmlspecialchars($class['instructor_name'] ?? 'Not Assigned') ?></td>
                                        <td data-label="Day"><?= htmlspecialchars($class['day']) ?></td>
                                        <td data-label="Time"><?= $time_range ?></td>
                                        <td data-label="Actions">
                                            <div class="action-buttons">
                                                <button class="action-btn edit-btn" data-id="<?= $class['class_id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="action-btn delete-btn" data-id="<?= $class['class_id'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-dumbbell fa-3x mb-3 text-muted"></i>
                                            <p class="text-muted">No classes found. Add your first class using the button above!</p>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <!-- Add/Edit Class Modal -->
    <div class="modal" id="class-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Add New Class</h3>
                <button class="close-modal" id="close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="class-form">
                <input type="hidden" id="class-id" name="class_id">
                <div class="form-group">
                    <label class="form-label" for="class-name">Class Name *</label>
                    <input type="text" id="class-name" name="name" class="form-input" placeholder="e.g., HIIT Blast, Yoga Flow" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="class-description">Description</label>
                    <textarea id="class-description" name="description" class="form-textarea" placeholder="Describe the class, intensity level, target audience..." rows="3"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="instructor">Instructor *</label>
                        <select id="instructor" name="instructor_id" class="form-select" required>
                            <option value="">Select instructor</option>
                            <?php
                            foreach ($staff as $instructor) {
                                echo "<option value='{$instructor['staff_id']}'>{$instructor['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="day">Day *</label>
                        <select id="day" name="day" class="form-select" required>
                            <option value="">Select day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="start-time">Start Time *</label>
                        <input type="time" id="start-time" name="start_time" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="end-time">End Time *</label>
                        <input type="time" id="end-time" name="end_time" class="form-input" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancel-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="save-btn">
                        <i class="fas fa-save me-2"></i>Save Class
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('class-modal');
            const addClassBtn = document.getElementById('add-class-btn');
            const closeModalBtn = document.getElementById('close-modal');
            const cancelBtn = document.getElementById('cancel-btn');
            const classForm = document.getElementById('class-form');
            const modalTitle = document.getElementById('modal-title');
            const alertMessage = document.getElementById('alert-message');
            
            function showAlert(message, type) {
                alertMessage.textContent = message;
                alertMessage.className = `alert alert-${type}`;
                alertMessage.style.display = 'block';
                
                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 5000);
            }
            
            // Open modal for adding new class
            addClassBtn.addEventListener('click', function() {
                modalTitle.textContent = 'Add New Class';
                classForm.reset();
                document.getElementById('class-id').value = '';
                modal.classList.add('active');
            });
            
            // Close modal
            function closeModal() {
                modal.classList.remove('active');
            }
            
            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);
            
            // Edit class buttons
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const classId = this.getAttribute('data-id');
                    // For now, we'll just show a message
                    showAlert('Edit functionality will be implemented soon!', 'error');
                    // In a real implementation, you would fetch class data and populate the form
                });
            });
            
            // Delete class buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const classId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this class?')) {
                        // Simple delete implementation
                        fetch('delete_class.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'class_id=' + classId
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showAlert('Class deleted successfully!', 'success');
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                showAlert('Error deleting class: ' + data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('Error deleting class', 'error');
                        });
                    }
                });
            });
            
            // Handle form submission
            classForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                // Show loading state
                const saveBtn = document.getElementById('save-btn');
                const originalText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                saveBtn.disabled = true;
                
                fetch('save_class.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        closeModal();
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error saving class: ' + error.message, 'error');
                })
                .finally(() => {
                    // Reset button state
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                });
            });
            
            // Validate time inputs
            const startTimeInput = document.getElementById('start-time');
            const endTimeInput = document.getElementById('end-time');
            
            function validateTimes() {
                const startTime = startTimeInput.value;
                const endTime = endTimeInput.value;
                
                if (startTime && endTime && startTime >= endTime) {
                    endTimeInput.setCustomValidity('End time must be after start time');
                } else {
                    endTimeInput.setCustomValidity('');
                }
            }
            
            startTimeInput.addEventListener('change', validateTimes);
            endTimeInput.addEventListener('change', validateTimes);
        });
    </script>
</body>
</html>