<?php 
include('config.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Code of create account
if(isset($_POST['btn_ajouter_user'])){
    $full_name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $user_name = trim($_POST['login']);
    $password = $_POST['pwd'];

    // Secure password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $con->prepare("INSERT INTO `users`(`id_user`, `name`, `email`, `login`, `pwd`) VALUES (NULL, ?, ?, ?, ?)");
    
    if($stmt->execute([$full_name, $email, $user_name, $hashed_password])) {
        // Auto-login logic
        session_start();
        $_SESSION['user_id'] = $con->lastInsertId();
        $_SESSION['user_name'] = $full_name;
        $_SESSION['role'] = 'admin'; // Default role
        
        header('location:../../pages/dashboard.php');
        exit();
    } else {
        header('location:../../login.php?error=registration_failed');
    }
}

// Code of ajoute member - FIXED
if (isset($_POST['btn_ajouter_member'])) {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone_num = trim($_POST['phone_num']);
    $address = trim($_POST['address']);
    $join_date = $_POST['join_date']; // FIXED: get from POST
    $gender = $_POST['gender']; // FIXED: get value, not isset

    // Debug: Check what values we're getting
    error_log("Inserting member: $firstname $lastname, $email, $phone_num, $address, $join_date, $gender");

    $sql = "INSERT INTO `members`(`member_id`, `firstname`, `lastname`, `email`, `phone_num`, `address`, `join_date`, `gender`)
            VALUES (NULL, '$firstname', '$lastname', '$email', '$phone_num', '$address', '$join_date', '$gender')";
    
    if($con->query($sql)) {
        // Success - redirect to members page
        header('location:../../pages/members.php?success=1');
        exit();
    } else {
        // Error - redirect with error message
        $error = $con->errorInfo();
        error_log("Database error: " . $error[2]);
        header('location:../../pages/members.php?error=1&message=' . urlencode($error[2]));
        exit();
    }
}

// Code of edit member - FIXED
if(isset($_POST['btn_edit_member'])){
    $member_id = $_POST['member_id'];
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone_num = trim($_POST['phone_num']);
    $address = trim($_POST['address']);
    $join_date = $_POST['join_date'];
    $gender = $_POST['gender'];

    error_log("Updating member ID: $member_id");

    $sql = "UPDATE `members` SET 
            `firstname` = '$firstname',
            `lastname` = '$lastname',
            `email` = '$email',
            `phone_num` = '$phone_num',
            `address` = '$address',
            `join_date` = '$join_date',
            `gender` = '$gender'
            WHERE `member_id` = $member_id";

    if($con->query($sql)) {
        header("location:../../pages/members.php?success=2");
        exit();
    } else {
        $error = $con->errorInfo();
        error_log("Update error: " . $error[2]);
        header("location:../../pages/members.php?error=2&message=" . urlencode($error[2]));
        exit();
    }
}

// Code of delete member - KEEP ONLY ONE
if(isset($_POST['id_sup_member'])){
    $id = $_POST['id_sup_member'];
    error_log("Deleting member ID: $id");

    if($con->query("DELETE FROM members WHERE `members`.`member_id` = $id")) {
        header("location:../../pages/members.php?success=3");
        exit();
    } else {
        $error = $con->errorInfo();
        error_log("Delete error: " . $error[2]);
        header("location:../../pages/members.php?error=3&message=" . urlencode($error[2]));
        exit();
    }
}

// Code of add staff member
if(isset($_POST['btn_ajouter_staff'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $hire_date = $_POST['hire_date'];
    $role = $_POST['role'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO `staff`(`staff_id`, `first_name`, `last_name`, `email`, `phone_number`, `hire_date`,`role`, `salary`)
            VALUES (NULL,'$first_name','$last_name','$email','$phone_number','$hire_date','$role','$salary')";
    
    if($con->query($sql)) {
        header('location:../../pages/staff.php?success=1');
        exit();
    } else {
        $error = $con->errorInfo();
        header('location:../../pages/staff.php?error=1&message=' . urlencode($error[2]));
        exit();
    }
}

// Charts data 
$sql = "SELECT MONTH(join_date) AS month, COUNT(*) AS new_members
        FROM members
        GROUP BY MONTH(join_date)
        ORDER BY month ASC";
$result = $con->query($sql);

$labels = [];
$data = [];

if ($result->rowCount() > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $monthNum = $row["month"];
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        $labels[] = $monthName;
        $data[] = $row["new_members"];
    }
}


// Handle template plan creation with JSON response
if (isset($_POST['btn_use_template']) && isset($_POST['template_key'])) {
    $templateKey = $_POST['template_key'];
    
    $templates = [
        'basic' => [
            'type' => 'Starter Pack',
            'description' => 'Perfect for beginners starting their fitness journey',
            'duration' => 1,
            'service_name' => 'Basic Membership',
            'price_description' => 'Gym Access, Locker Room, Basic Equipment, 1 Free Training Session',
            'price' => 29.99
        ],
        'pro' => [
            'type' => 'Pro Fitness',
            'description' => 'For serious fitness enthusiasts wanting more',
            'duration' => 3,
            'service_name' => 'Pro Membership',
            'price_description' => 'All Basic Features, Group Classes, Premium Equipment, 3 Training Sessions, Nutrition Guide',
            'price' => 59.99
        ],
        // ... other templates
    ];

    if (isset($templates[$templateKey])) {
        $template = $templates[$templateKey];
        
        try {
            // Check if plan already exists
            $checkStmt = $con->prepare("SELECT COUNT(*) FROM memberships WHERE type = ?");
            $checkStmt->execute([$template['type']]);
            $exists = $checkStmt->fetchColumn();
            
            if ($exists == 0) {
                // Insert into prices table
                $con->query("INSERT INTO `prices`(`price_id`, `service_name`, `description`, `price`) 
                            VALUES (NULL, '{$template['service_name']}', '{$template['price_description']}', '{$template['price']}')");
                $price_id = $con->lastInsertId();

                // Insert into memberships table
                $con->query("INSERT INTO `memberships`(`membership_id`, `type`, `description`, `duration`, `id_price`) 
                            VALUES (NULL, '{$template['type']}', '{$template['description']}', '{$template['duration']}', '$price_id')");
                
                echo json_encode(['success' => true, 'message' => "{$template['type']} plan added successfully!"]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Plan already exists in your system']);
            }
            exit();
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit();
        }
    }
}

// Handle delete plan with JSON response
if (isset($_POST['id_sup_plan'])) {
    $id = $_POST['id_sup_plan'];
    try {
        $priceStmt = $con->query("SELECT id_price FROM memberships WHERE membership_id = $id");
        $price_id = $priceStmt->fetchColumn();

        $con->query("DELETE FROM memberships WHERE `memberships`.`membership_id` = $id");

        if ($price_id) {
            $con->query("DELETE FROM prices WHERE `prices`.`price_id` = $price_id");
        }

        echo json_encode(['success' => true, 'message' => 'Plan removed successfully']);
        exit();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error removing plan: ' . $e->getMessage()]);
        exit();
    }
}
?>