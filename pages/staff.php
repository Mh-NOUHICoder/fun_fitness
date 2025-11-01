<?php 
    include('../assets/include/script.php');
    //Sidebar include
    include('../HOME.PHP');
                    //Count of role Staff
        $total_trainer_staff = $con->query("SELECT COUNT(*) AS total_trainer_staff FROM `staff` WHERE role = 'trainer' ")->fetchColumn();

        $total_cleaning_staff = $con->query("SELECT COUNT(*) AS total_cleaning_staff FROM `staff` WHERE role = 'cleaning'")->fetchColumn();

        $total_cashier_staff = $con->query("SELECT COUNT(*) AS total_cashier_staff FROM `staff` WHERE role = 'receptionist'")->fetchColumn();    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- table -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <title>Staff Page</title>
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
    
    

    
    /* dark button */
    .dark-mode {
        background-color:black;
        color: #fff;
    }
 
    .btn:hover i {
    transform: scale(0.9);
    fill: #333333;
    }
    
    body{
        height: 100vh;
        display: grid;
        grid-template-columns: 150px 1fr;
        grid-template-rows: 40px 1fr;
        grid-gap: 10px;
        grid-template-areas: 
            "header header"
            "side main";
        padding: 20px;
        }

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
        }
        .logo{
        position: absolute;
        top: 0;
        left: 10px;
        width:160px;
        }

        
        
        
    /*----------- Main -------------*/
    main{      
        grid-area: main;
        padding: 5px;
        gap: 20px;
    }
   
    .card_dash {  
        position: relative;
        height: 280px;
        width: 400px;  
        border-radius: 10px;
        text-shadow: 1px 1px  #f7f5f5d6;
        backdrop-filter:blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background-color:rgba(0, 0, 0, 0.477);
        margin-left:10px;
        box-shadow: 0px 0px 7px #ffffff52 inset;
        background: linear-gradient(135deg,rgba(255,255,255,0.1),rgba(255,255,255,0));    
    }
    .card_dash i{
        position: absolute;
        font-weight: 600;
        top: 10px;
        left: 10%;
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
    }
    
   

    .table{
        grid-area: t;
        margin: 0;
        padding: 10px;
    }
    
    @media (min-width:725px) ,(max-width:950px){ 
        
        .card_dash{ 
            height: 170px; 
           
        }
        .card_dash h3{
            font-family: 'dancing';
        }
        .table {
            grid-area: initial !important;
        }
    }
    @media (max-width:725px){
     .big_title{
        font-family: 'Montserrat';
        letter-spacing: 10px;
     }
    
       
    }
     /* End of media */
    
    
    
            /* form of add staff */
    .shine {
      font-size: 2em;
      font-weight: 900;
      color: rgba(255, 255, 255, 0.3);
      background: #222 -webkit-linear-gradient(
        -40deg, transparent 0%, transparent 40%, #fff 50%, transparent 60%, transparent 100%
        )0 0 no-repeat;
       
      
          background-clip: text;
          background-size: 50px;
          animation: zezzz;
          animation-duration: 5s;
          animation-iteration-count: infinite;
      }
      @keyframes zezzz {
      0%,
      10% {
          background-position: -200px;
      }
      20% {
          background-position: top left;
      }
      100% {
          background-position: 300px;
      }
    
    }

    .add_staff {
      grid-area: f;
      width: 400px;
      padding: 10px;
      background: rgba(24, 20, 20, 0.6);
      box-shadow: 0 15px 25px rgba(0,0,255,.6);
      border-radius: 10px;
    }
    .add_staff .user-box{
      position: relative;
    }
    .add_staff .user-box input {
      width: 100%;
      padding: 10px 0;
      font-size: 16px;
      color: #fff;
      margin-bottom: 30px;
      border: none;
      border-bottom: 1px solid #fff;
      outline: none;
      background: transparent;
    }
    .add_staff .user-box label {
      position: absolute;
      top: 0;
      left: 10px;
      padding: 10px 0;
      font-size: 16px;
      color: #a3a2a2;
      pointer-events: none;
      transition: .5s;
    }

    .add_staff .user-box input:focus ~ label,
    .add_staff .user-box input:valid ~ label {
      top: -33px;
      left: 0;
      color: #bdb8b8;
      font-size: 16px;
    }
    
    
    .add_staff button {
      position: relative;
      display: inline-block;
      background: linear-gradient(90deg , rgba(0,0,255,.6),transparent,transparent,rgba(0,0,255,.6));
      padding: 10px 20px;
      border-radius: 30px;
      width: 40%;
      color: #d4e7fa;
      font-size: 16px;
      transition: .5s;
      margin-top: 40px;
      letter-spacing: 4px;
      animation: float-up-down 1s infinite;
    }

    .add_staff button:hover {
      background: rgba(0,0,255,.6);
      color: #fff;
      border-radius: 5px;
      animation: none;
      box-shadow: 0 0 5px rgba(0,0,255,.6),
                  0 0 25px rgba(0,0,255,.6),
                  0 0 50px rgba(0,0,255,.6);
                  
    }
    @keyframes float-up-down {
    0% {
        -webkit-transform:translateY(0)
    }

    50% {
        -webkit-transform: translateY(-10%);
        transform:translateY(-20%)
    }

    100% {
        -webkit-transform: translateY(0);
        transform:translateY(0)
    }
    }
   
</style>
<body class="100vh" >
    <div class="scroll-w"></div>
    <header class="header">
        <div class="logo  py-1  ">
            <img class="" src="../assets/IMAGES/fast-fit.png"  
            style="width: 100%; filter: drop-shadow(0px 0px 10px  white)">
        </div>
                <span class="big_title mb-3"><center><h1>Staff</h1></center></span>
    </header>       
    <main class="main text-center">
            
        <div class="row mt-3 mb-3">
            <div class="col-4">
                        <div class="card_dash  ">
                            <div class="card-body  text-center">
                                <h1><i class="fa-solid fa-user"></i></h1>
                                
                                <h1 class="card-title"><?=number_format($total_trainer_staff)?></h1>
                                <h6 class="card_dash-text">TOTAL Trainers</h6>
                                
                            </div>             
                        </div>  
                      
            </div>
            <div class="col-4">
                        <div class="card_dash " >
                            <div class="card-body">
                                <h1><i class="fa-solid fa-broom"></i></h1>
                                <h1 class="card-title"><?=number_format($total_cleaning_staff)?></h1>
                                <h6 class="card_dash-text">TOTAL Cleaning staff</h6>
                                
                            </div>
                        </div>
            </div>
            <div class="col-4">
                        <div class="card_dash " >
                            <div class="card-body text-center">
                                <h1><i class="fa-solid fa-money-bill-wave"></i></h1>
                                <h1 class="card-title"><?=number_format($total_cashier_staff)?></h1>
                                <h6 class="card_dash-text">TOTAL Cashier</h6>
                                
                            </div>
                        </div>
            </div>
        </div>
        <div class="row mt-4 ">
                <div class="col-8">
                    <table id="myTable" class="table d-gap p-3 mt-5 mb-3 w-100 table-dark text-body opacity-75 bg-transparent "  >
                        <caption>Table of Staff Members</caption>
                    <thead>
                        <tr>
                        <th scope="col">id</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile Phone</th>
                        <th scope="col">Hire Date</th>
                        <th scope="col">Role</th>
                        <th scope="col">Salary</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="rounded py-3">
                    <?php 
                                    $req = $con->query("SELECT * FROM `staff`");
                                    foreach ($req as  $value) {
                                        
                                    ?>
                        <tr>
                        <th scope="row"><?=$value['staff_id'] ?></th>
                        <td><?=$value['first_name'] ?></td>
                        <td><?=$value['last_name'] ?></td>
                        <td><?=$value['email'] ?></td>
                        <td><?=$value['phone_number'] ?></td>
                        <td><?=$value['hire_date'] ?></td>
                        <td><?=$value['role'] ?></td>
                        <td><?=$value['salary'] ?></td>
                        <td>
                        <a href="../assets/include/script.php?id_sup_staff=<?=$value['staff_id']?>" 
                        class=" btn btn-sm text-danger border-danger" >
                        <i class="fa-solid fa-trash"></i>
                                        </a>
                        <a  
                                        data-bs-toggle="modal" data-bs-target="#modif"
                                        data-id="<?=$value["staff_id"]?>"
                                        data-first_name="<?=$value["first_name"]?>"
                                        data-last_name="<?=$value["last_name"]?>"
                                        data-email="<?=$value["email"]?>"
                                        data-phone_number="<?=$value["phone_number"]?>"
                                        data-hire_date="<?=$value["hire_date"]?>"
                                        data-role="<?=$value["role"]?>"
                                        data-salary="<?=$value["salary"]?>"
                            href="../assets/include/script.php?id_edit_staff=<?=$value['staff_id']?>" 
                            class="btn btn-sm text-success border-success btn_edit" >
                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>

                        </td>
                        
                        </tr>
                        <?php  } ?>
                    </tbody>
                    </table>
                    </div>
                <div class="col-4">                
                    <form class="add_staff" action="../assets/include/script.php" method="POST" >
                                    <div class=" modal-body text-light">
                                    <div class="shine mb-3"> <center>ADD Staff Member</center></div>
                                        <input type="text" name="staff_id" class="custom-hidden-input" style="display: none;">
                                        <div class="user-box"> 
                                        
                                        <input type="" name="first_name" class="form-control first_name" required>
                                        <label>First Name</label>
                                        </div>

                                        <div class="user-box"> 
                                        <input type="" name="last_name" class="form-control last_name" required>
                                        <label>Last Name</label>
                                        </div>

                                        <div class="user-box"> 
                                        <input type="email" name="email" class="form-control email"required>
                                        <label>Email</label> 
                                        </div>

                                        <div class="user-box"> 
                                        <input type="tel" name="phone_number" class="form-control phone_number" required>
                                        <label>Mobile Phone</label>
                                        </div>

                                        <div class="user-box"> 
                                        <input type="date" name="hire_date" class="form-control hire_date" required>
                                        <label>Hire date</label>
                                        </div>

                                        <div class="user-box"> 
                                        <input type="text" name="role" class="form-control role"required>
                                        <label>Role</label> 
                                        </div>

                                        <div class="user-box"> 
                                        <input type="text" name="salary" class="form-control"required>
                                        <label>salary</label> 
                                        </div>                           
                                    </div>               
                                <center>
                                <button href="#" type="submit" class="submit-button" 
                                name="btn_ajouter_staff"><b>ADD</b>
                                </button></center>
                        </form>
                    
                </div>                        
    </main>
        
    
    
    <!-- jquery code -->

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
  <script>
  $(document).ready(function(){
        $('.btn_edit').click(function(){
          $('.first_name').val($(this).data('first_name'))
          $('.last_name').val($(this).data('last_name'))
          $('.email').val($(this).data('email'))
          $('.phone_number').val($(this).data('phone_number'))
          $('.hire_date').val($(this).data('hire_date'))
          $('.role').val($(this).data('role'))
          $('.salary').val($(this).data('salary'))
      })
  });
    
  </script>

  <!-- end of jquery code  -->

  <!-- new client statistic chart script -->
  
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
  });
</script>
</body>
</html>