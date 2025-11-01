<?php
include('../assets/include/script.php');
//Sidebar include
include('../HOME.PHP');

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
    --clr-primary:#4444e2;
    --clr-dangerd:#ea3b3b;
    --clr-success:#6cf856;
    --clr-white:#ffffff;
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
    --box-shodow:0 2rem 3rem var(var(--clr-light));

    }

    *{
    padding: 0 ;
    margin: 0;
    
    }
    html{
    scroll-behavior: smooth;
    }
    @font-face {
    font-family: "Sedan";
    src: url(../assets/fonts/Sedan/Sedan-Regular.ttf);
    font-family: 'Montserrat';
    src: url(../assets/fonts/Montserrat/static/Montserrat-Regular.ttf);
    font-family: "play";
    src: url(../assets/fonts/static/Platypi-SemiBold.ttf);
    }
    @font-face {

    font-family: "dancing2";
    src: url(../assets/fonts/Dancing_Script/static/DancingScript-Regular.ttf);
    }
    @font-face {
    font-family: "dancing";
    src: url(../assets/fonts/Dancing_Script/static/DancingScript-Bold.ttf);
    }
    /* scroll style */
    .scroll-w{
    height: 4px;
    position: fixed;
    top: 0;
    z-index: 1000;
    background-color: rgb(128, 238, 69);
    width: 100%;
    scale: 0 1;
    animation: scroll-w linear;
    animation-timeline: scroll();
    }
    @keyframes scroll-w {
    to{ scale: 1 1;}
    }
    /* end style of scroll */
    h1{
    font-family: "Montserrat";
    letter-spacing: 8px;
    font-weight: 700;
    font-size: xx-large;
    }


    .logo{
    width:160px;

    }

    
    /* dark button */
    .dark-mode {
        background-color:black;
        color: #fff;
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
        
        height: 90vh;
        display: grid;
        grid-template-columns: 150px 1fr;
        grid-template-rows: 60px 1fr;
        grid-gap: 10px;
        grid-template-areas: 
            "header header"
            "side main" ;
        }
    /* Header style */

        header{
        background-color: transparent;
        grid-area: header;
        border-bottom: 2px solid #ddd;
        padding-bottom: 30px;
        }
        .big_title{
        letter-spacing: 8px;
        position: absolute;
        top: 0px;
        left: 50%;
        transform: translateX(-50%);
        }
        .logo{
        position: absolute;
        top: 0;
        left: 10px;
        width:160px;
        }

        .sidebar{
        background-color: black;
        grid-area: side;

        }
    
    /*----------- Main style-------------*/
    main{ 
        grid-area: main ;
        padding: 25px;
        gap: 20px;
        }
   
    .card_dash {
        position: relative;
        height: 200px;
        width: auto;
        gap: 20px;
        border-radius: var(--border-radius-1);
        text-shadow: 1px 1px  #f7f5f5d6;
        backdrop-filter:blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background-color:rgba(0, 0, 0, 0.477);
        margin-left:10px;
        box-shadow: 0px 0px 7px #ffffff52 inset;
        background: linear-gradient(135deg,rgba(255,255,255,0.1),rgba(255,255,255,0));
        
    }
    .card_dash_table{
        min-height: 500px;
        gap: 20px;
        padding: 20px;
        border-radius: var(--border-radius-1);
        text-shadow: 1px 1px  #f7f5f5d6;
        backdrop-filter:blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background-color:rgba(0, 0, 0, 0.477);
        margin-left:10px;
        box-shadow: 0px 0px 7px #ffffff52 inset;
        background: linear-gradient(135deg,rgba(255,255,255,0.1),rgba(255,255,255,0));
    }
   
    .card_dash h2{
        position:absolute;
        top: 10%;
        left: 20%;
    }
    .card_dash i{
        position: absolute;
        right: 5px;
        font-size: 2rem;
    }
    .card_dash-text {
        display: flex;
        letter-spacing: 0.3rem;
        position: absolute;
        left: 30px;
        bottom: 20px;
    }
    .card_dash .card-title{
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translateX(-50%);
        font-size: 3rem;
    }
    
    /* Classes Table Styles */
    .classes-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    
    .classes-table th {
        background-color: rgba(255, 255, 255, 0.1);
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .classes-table td {
        padding: 12px 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .classes-table tr:hover {
        background-color: rgba(255, 255, 255, 0.05);
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
        background: rgba(255, 255, 255, 0.05);
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
        background: rgba(0, 0, 0, 0.9);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .modal-title {
        font-size: 1.4rem;
        font-weight: 600;
    }

    .close-modal {
        background: none;
        border: none;
        color: var(--clr-white);
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
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: var(--clr-white);
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
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: var(--clr-white);
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
    }
    
    @media (max-width:725px){
        main{
            gap: 20px;
        }
        
        .card_dash{
            grid-area: initial ;
        }

        .big_title{
            visibility: hidden;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
    }
     /* End of media */
    
     
</style>
<body class="1000vh" >
    <div class="scroll-w"></div>
    
       
        <!-- sidebar include -->
        <?php 
            include('../HOME.PHP');
        ?>
        <!-- Page Content -->
        <!---------------------------------------------- Header Code -->
        <header class="header">
            <div class="logo bg-transparen sidebar-heading   ">
                        <img class="" src="../assets/IMAGES/fast-fit.png"  
                        style="background:none;width: 100%; filter: drop-shadow(0px 0px 10px  white)"></div>
                    <span class="big_title "><center><h1>Classes Management</h1></center></span>
        </header>
        <!----------------------------------------------End of Header Code -->
        
            
        <main class="main text-center">
            <!-- Alert Messages -->
            <div id="alert-message" class="alert" style="display: none;"></div>
            
            <div class="row mt-3">
                <div class="col-4">
                    <div class="card_dash">
                        <div class="card-body">
                            <h2><i class="fa-solid fa-dumbbell"></i></h2>
                            <h1 class="card-title"><?=number_format($total_classes)?></h1>
                            <h6 class="card_dash-text">TOTAL CLASSES</h6>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card_dash">
                        <div class="card-body">
                            <h2><i class="fa-solid fa-check-circle"></i></h2>
                            <h1 class="card-title"><?=number_format($active_classes)?></h1>
                            <h6 class="card_dash-text">ACTIVE CLASSES</h6>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card_dash">
                        <div class="card-body">
                            <h2><i class="fa-solid fa-calendar-alt"></i></h2>
                            <h1 class="card-title"><?=number_format($upcoming_classes)?></h1>
                            <h6 class="card_dash-text">UPCOMING CLASSES</h6>
                        </div>
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
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <i class="fas fa-dumbbell text-primary"></i>
                                                </div>
                                                <div>
                                                    <div><strong><?= htmlspecialchars($class['name']) ?></strong></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($class['description']) ?></td>
                                        <td><?= htmlspecialchars($class['instructor_name'] ?? 'Not Assigned') ?></td>
                                        <td><?= htmlspecialchars($class['day']) ?></td>
                                        <td><?= $time_range ?></td>
                                        <td>
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