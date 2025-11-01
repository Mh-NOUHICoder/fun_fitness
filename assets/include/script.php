<?php 
   include('config.php');


//    code of create account
    if(isset($_POST['btn_ajouter_user'])){
        $full_name = $_POST['name'];
        $user_name = $_POST['login'];
        $password = $_POST['pwd'];

        $con->query("INSERT INTO `users`( `id_user`,`name`, `login`, `pwd`) VALUES (null,'$full_name','$user_name','$password')");
        header('location:../../login.php');

    }

    // code of ajoute member

    if (isset($_POST['btn_ajouter_member'])) {
        $firstname = trim($_POST['firstname']); // Trim whitespace from input
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $phone_num = trim($_POST['phone_num']);
        $address = trim($_POST['address']);
        $join_date = ('join_date'); // Use current date for join date
        $gender = isset($_POST['gender']);
 
        $con->query("INSERT INTO `members`(`member_id`, `firstname`, `lastname`, `email`, `phone_num`, `address`, `join_date`,`gender`)
                                    VALUES (Null,'$firstname','$lastname','$email','$phone_num','$address','$join_date','$gender')");
        header('location:../../pages/members.php');

    }


    // code of sup member
    if(isset($_GET['id_sup_member'])){

		$id = $_GET['id_sup_member'];

		$con->query("DELETE FROM members WHERE `members`.`member_id` = $id");

        header("location:../../pages/members.php");


	}

    // code of edit member
    if(isset($_GET['id_edit_member'])){

		$id = $_GET['id_edit_member'];
        $id_mem = $_POST['member_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone_num = $_POST['phone_num'];
        $address = $_POST['address'];
        $join_date = $_POST['join_date'];

		$con->query("UPDATE `members` SET `member_id`='[value-1]',`firstname`='[value-2]',`lastname`='[value-3]',`email`='[value-4]',
        `phone_num`='[value-5]',`address`='[value-6]',`membership_id`='[value-8]',`join_date`='[value-9]'");

        header("location:../../pages/members.php");


	}
    //code of add staff member
    if(isset($_POST['btn_ajouter_staff'])){
        $member_id = $_POST['staff_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $hire_date = $_POST['hire_date'];
        $role = $_POST['role'];
        $salary = $_POST['salary'];
        echo "you have problem";
 
        $con->query("INSERT INTO `staff`(`staff_id`, `first_name`, `last_name`, `email`, `phone_number`, `hire_date`,`role`, `salary`)
                                    VALUES (Null,'$first_name','$last_name','$email','$phone_number','$hire_date','$role','$salary')");
        header('location:../../pages/staff.php');

    }

    // code of sup member
    if(isset($_GET['id_sup_member'])){

		$id = $_GET['id_sup_member'];

		$con->query("DELETE FROM members WHERE `members`.`member_id` = $id");

        header("location:../../pages/members.php");


	}
    

                                //charts data 
    

    // Define your SQL query to fetch data (replace with your table and columns)
    $sql = "SELECT MONTH(join_date) AS month, COUNT(*) AS new_members
    FROM members
    GROUP BY MONTH(join_date)
    ORDER BY month ASC;
    ";
    $result = $con->query($sql);

    // Initialize empty arrays for labels and data
    $labels = [];
    $data = [];

    // Loop through results and populate arrays
    if ($result->rowCount() > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $monthNum = $row["month"];
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10)); // Adjust for desired format (optional)
        $labels[] = $monthName;
        $data[] = $row["new_members"];
    }
    } else {
    echo "No data found in the database";
    }



