<?php 
  include('../HOME.PHP');
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
    <title>Members</title>
    <link rel="shortcut icon" type="x-icon" href="../assets/IMAGES/logo-icon.png">

</head>
<style>
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
   .dark-mode {
        background-color:black;
        color: #fff;
    }
      /* Card Add member */
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


  
     
     

   
    
    body{
        height: 100vh;
        display: grid;
        grid-template-columns: 150px 1fr;
        grid-template-rows: 60px 1fr;
        grid-gap: 10px;
        grid-template-areas: 
            "header header"
            "side main" ;
        }
          /* header */
        header{
        background-color: transparent;
        grid-area: header;
        border-bottom: 1px solid #ddd;
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

        .sidebar{
        background-color: black;
        grid-area: side;

        }
        
       
        
    /*- ---------- Main -------------*/
    main{ 
        
        grid-area: main;
        padding: 30px;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr ;
        grid-template-rows: 1fr 1fr 1fr  ;
        grid-template-areas: 
            "t t cf"
            "t t cf"
            "c1 c2 c3" ;
        gap: 60px;
     
     }

     
     .card_mem:nth-child(1){
      grid-area: c1;
     }
     .card_mem:nth-child(2){
      grid-area: c2;
     }

     .card_mem:nth-child(3){
      grid-area: c3;
     }

     .card_member{
      grid-area: cf;
     
     }

    .btn:hover i {
    transform: scale(0.9);
    fill: #333333;
    }
     
     
    .login_add {
      grid-area: cf;
      width: 400px;
      padding: 40px;
      background: rgba(24, 20, 20, 0.6);
      box-shadow: 0 15px 25px rgba(0,0,255,.6);
      border-radius: 10px;
    }
    .login_add .user-box{
      position: relative;
    }
    .login_add .user-box input {
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
    .login_add .user-box label {
      position: absolute;
      top: 0;
      left: 10px;
      padding: 10px 0;
      font-size: 16px;
      color: #a3a2a2;
      pointer-events: none;
      transition: .5s;
    }

    .login_add .user-box input:focus ~ label,
    .login_add .user-box input:valid ~ label {
      top: -33px;
      left: 0;
      color: #bdb8b8;
      font-size: 16px;
    }
    
    
    .login_add button {
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

    .login_add button:hover {
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
    

        

     table{
      grid-area: t;
      height: 100%;
      width: auto;
      border-radius: 20px;
      margin: 10px;
      padding: 25px;
      padding-top: 10px;
     }
    
        /* Media */

     @media (width < 925px){
      main{
        grid-template-columns: 1fr;
        grid-template-areas: initial !important;
      }
      .card_mem{
        grid-template-areas: initial !important;
      }
     }
</style>
<body >
    <header class="header bg-transparen sidebar-heading ">
    <div class="logo bg-transparen sidebar-heading   ">
                        <img class="" src="../assets/IMAGES/fast-fit.png"  
                        style="background:none;width: 100%; filter: drop-shadow(0px 0px 10px  white)"></div>
                <span class="big_title "><center><h1>Members</h1></center></span>
    </header>
    <main>
   
            <table id="myTable" class="table d-gap pt-3 mt-4 mb-3 w-100 table-dark text-body opacity-75 bg-transparent " 
            style="background: transparent;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Mobile Phone</th>
                  <th scope="col">Address</th>
                  <th scope="col">Start Date</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody class="rounded py-3">
              <?php 
                            $req = $con->query("SELECT * FROM `members`");
                             foreach ($req as  $value) {
                                
                            ?>
                <tr>
                  <th scope="row"><?=$value['member_id'] ?></th>
                  <td><?=$value['firstname'] ?></td>
                  <td><?=$value['lastname'] ?></td>
                  <td><?=$value['email'] ?></td>
                  <td><?=$value['phone_num'] ?></td>
                  <td><?=$value['address'] ?></td>
                  <td><?=$value['join_date'] ?></td>
                  <td><?=$value['gender'] ?></td>
                  <td>
                  <a href="../assets/include/script.php?id_sup_member=<?=$value['member_id']?>" 
                   class="btn btn-sm text-danger border-danger" >
                   <i class="fa-solid fa-trash"></i>
                                </a>
                   <a  
                                data-bs-toggle="modal" data-bs-target="#modif"
                                data-id="<?=$value["member_id"]?>"
                                data-firstname="<?=$value["firstname"]?>"
                                data-lastname="<?=$value["lastname"]?>"
                                data-email="<?=$value["email"]?>"
                                data-phone_num="<?=$value["phone_num"]?>"
                                data-address="<?=$value["address"]?>"
                                data-join_date="<?=$value["join_date"]?>"
                                data-gender="<?=$value["gender"]?>"
                    href="../assets/include/script.php?id_edit_member=<?=$value['member_id']?>" 
                    class="btn btn-sm text-success border-success btn_edit" >
                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>

                  </td>
                  
                </tr>
                <?php  } ?>
              </tbody>
            </table>
          
          <div class="card_member ">
                <form class="login_add" action="../assets/include/script.php" method="POST" >
                            <div class=" modal-body text-light">
                            <div class="shine mb-3"> <center>ADD MEMBER</center></div>
                            <input type="text" name="member_id" class="custom-hidden-input" style="display: none;">
                                <div class="user-box"> 
                                
                                <input type="" name="firstname" class="form-control firstname" required>
                                <label>First Name</label>
                                </div>

                                <div class="user-box"> 
                                <input type="" name="lastname" class="form-control lastname" required>
                                <label>Last Name</label>
                                </div>

                                <div class="user-box"> 
                                <input type="email" name="email" class="form-control email"required>
                                <label>Email</label> 
                                </div>

                                <div class="user-box"> 
                                <input type="tel" name="phone_num" class="form-control phone_num" required>
                                <label>Mobile Phone</label>
                                </div>

                                <div class="user-box"> 
                                <input type="" name="address" class="form-control address" required>
                                <label>Address</label>
                                </div>

                                
                                <div class="user-box"> 
                                <input type="date"   name="join_date" class="form-control join_date"  required>
                                <label>Start Date</label>
                                </div>

                                <div class="">
                                <label for="gender" name="gender" class="gender">Gender</label><hr>
                                 <input type="radio"   value="Male"> Male 
                                 <input type="radio"   value="Female"> Female

                                </div>
                            
                            </div>
                            	
		
		                    
                        <center>
                          <button href="../assets/include/script.php?id_edit_member=<?=$value['member_id']?>" type="submit" class="submit-button" 
                          name="btn_ajouter_member"><b>ADD</b>
                                
                            
                          </button></center>
                </form>
            
              </div>
              
        
    </main>
    <!-- jquery code -->

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
  <script>
  $(document).ready(function(){
        $('.btn_edit').click(function(){
          $('.firstname').val($(this).data('firstname'))
          $('.lastname').val($(this).data('lastname'))
          $('.email').val($(this).data('email'))
          $('.phone_num').val($(this).data('phone_num'))
          $('.address').val($(this).data('address'))
          $('.join_date').val($(this).data('join_date'))
          $('.gender').val($(this).data('gender'))
      })
  });
    
  </script>

  <!-- end of jquery code  -->

  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
  });
</script>
</body>
</html>