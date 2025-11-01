<?php
include('config.php'); // Your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $instructor_id = $_POST['instructor_id'];
        $day = $_POST['day'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        
        // Insert into database
        $stmt = $con->prepare("INSERT INTO classes (name, description, instructor_id, day, start_time, end_time) 
                              VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $instructor_id, $day, $start_time, $end_time]);
        
        $response = [
            'success' => true,
            'message' => 'Class added successfully!'
        ];
    } catch (PDOException $e) {
        $response = [
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>