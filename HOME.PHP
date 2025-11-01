<?php include('assets/include/config.php') ?>

<?php 
                                $currentPageName = basename($_SERVER['SCRIPT_NAME']);
                                
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
    --clr-light:rgba(254, 250, 250, 0.10);
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

        /*      Fonts         */
    @font-face {
    font-family: "Sedan";
    src: url(assets/fonts/Sedan/Sedan-Regular.ttf);
    font-family: 'Montserrat';
    src: url(assets/fonts/Montserrat/static/Montserrat-Regular.ttf);
    font-family: "play";
    src: url(assets/fonts/static/Platypi-SemiBold.ttf);
    }
    @font-face {

    font-family: "dancing2";
    src: url(assets/fonts/Dancing_Script/static/DancingScript-Regular.ttf);
    }
    @font-face {
    font-family: "dancing";
    src: url(assets/fonts/Dancing_Script/static/DancingScript-Bold.ttf);
    }
        /* . */
    .scroll-w{
    height: 4px;
    position: fixed;
    top: 0;
    z-index: 1000;
    opacity: .5;
    background-color: #3061f4;
    width: 100%;
    scale: 0 1;
    animation: scroll-w linear;
    animation-timeline: scroll();
    }
    @keyframes scroll-w {
    to{ scale: 1 1;}
    }
   


    .logo{
    width:160px;

    }
    
      

        

        @media (max-width: 925px){
            body{
                grid-template-columns: 80px 1fr;
            }
            .sidebar{
            max-width: 80px ;
            }
            .main{
                grid-template-columns: 1fr;
                grid-template-rows: repeat(6,200px);
                grid-template-areas: initial;
            }
            
            .card_dash{
                grid-area: initial !important ;
            }
        }
    /* dark button */
    .dark-mode {
        background-color:black;
        color: #fff;
        }
        .btndark {
        display: block;
        position: absolute;
        bottom: 5rem;
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

        .btndark:hover {
        box-shadow: inset 4px 4px 6px -1px rgba(0,0,0,0.2),
                inset -4px -4px 6px -1px rgba(255,255,255,0.7),
                -0.5px -0.5px 0px rgba(255,255,255,1),
                0.5px 0.5px 0px rgba(0,0,0,0.15),
                0px 12px 10px -10px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.1);
        transform: translateY(0.5em);
        }

        .btndark i {
        position: absolute;
        top: 15px;
        right: 10px;
        width: 25px;
        height: 25px;
        color: #e3edf7;
        transition: transform 0.5s;
        }

        .btndark:hover i {
        transform: scale(0.9);
        fill: #333333;
        }






    /************** sidebar ************/
    .sidebar{
        background: transparent;
        display: flex;
        flex-direction: column;
        height: 100vh;
        grid-area: side;
        position: relative;
        top: 1rem;
       
    }
    h3{
        font-weight: 100;
        
        font-family: 'Montserrat';
    }
    h5{
        font-family: 'Montserrat';
        font-size: 1rem;
    }
    .sidebar a{
        display: flex;
        margin-left: 1.rem;
        margin-top: 1.2rem;
        text-decoration: none;
        color: var(--clr-gray);
        font-style:oblique;
        text-shadow: 1px 1px  #f7f5f5d6;
        gap: 1rem;
        align-items: center;
        height: 3.2rem;
        transition: all .1s ease-in;
    }
    .sidebar a span{
        color: var(--clr-gray);
        margin-left: 10px;
        text-shadow: 1px 1px  #f7f5f5d6;
        font-size: 1.6rem;
        transition: all .1s ease-in;
        
    }
    .sidebar a:last-child{
        position: absolute;
        bottom: 200px;
        width: 100%;

    }
    .sidebar a.active{
        background: var(--clr-light);
        color: var(--clr-primary);
        margin-left: 0;
        width: 100%;
        border-left: 5px solid var(--clr-primary);
    }

    .sidebar a.active::before{
        content: "";
        width: 6px;
        height: 100%;
        background-color: var(--clr-primary);

    }
    .sidebar a:hover{
        color: var(--clr-primary);
    }
    .sidebar a:hover span{
        color: var(--clr-primary);
        margin-left: 1rem ;
        transition: .4s ease;
    }
    .sidebar a span.msg_count{
        background: var(--clr-dangerd);
        color: var(--clr-white);
        padding: 2px 5px;
        font-size: 11px;
        border-radius: var(--border-radius-1);
    }
    @media  (max-width:925px){
        h5{
            visibility: hidden;
        }
        .sidebar{
            width: 100px;
        }
        .sidebar span{
            position: relative;
        }
        span.msg_count {
           position: absolute;
           left: 55px;
        }
    }

   
        
    
   
</style>
<body class="100vh" >
    <div class="scroll-w"></div>
        
        <!-- Sidebar -->
        <section class="sidebar  bg-transparen ">
            <div class="" id="sidebar-wrapper">
                
                <div class="list-group list-group-flush my-3">
                    
                            
                                <a href="dashboard.php" aria-current="page" class="<?= ($currentPageName=="dashboard.php")? "active":""?> nav-link"><span><i class="fa-solid fa-border-all"></i></span>
                                <h5>Dashboard</h5>
                                
                                </a>
                                
                                <a href="members.php" aria-current="page" class="<?= ($currentPageName=="members.php")? "active":""?> nav-link"><span><i class="fa-solid fa-people-group"></i></span>
                                <h5>members</h5>
                                </a>
                               
                                <a href="staff.php" aria-current="page" class="<?= ($currentPageName=="staff.php")? "active":""?>"><span><i class="fa-solid fa-user"></i></span>
                                <h5>staff</h5>
                                </a>

                                <a href="classes.php" class="<?= ($currentPageName=="classes.php")? "active":""?>"><span><i class="fa-solid fa-layer-group"></i></span>
                                <h5>Classes</h5>
                                
                                </a>

                                <a href="#" class=""><span><i class="fa-regular fa-message"></i></span>
                                <h5>Messages</h5>
                                <span class="msg_count">14</span>
                                </a>

                                <button class=" btndark bg-transparent  mx-6 border-primary" id="dark-mode-toggle">
                                    <i class=" fa-solid fa-adjust" id="dicon"></i>                                   
                                </button>
                                <a href="../login.php" class=" "><span></span><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                                <h5>Log Out</h5>
                                </a>
                                
                    
                </div>
            </div>
        </section>
        <!-- /#sidebar-wrapper -->
        <main class="main">
            
        </main>
        
    
    <!-- jquery code -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
    $(document).ready(function() {
      const darkModeToggle = $('#dark-mode-toggle');
      const body = $('body');
      const icon = $('#dicon');
    
      // Check if dark mode is already set in localStorage
      const isDarkMode = localStorage.getItem('darkMode') === 'true';
      if (isDarkMode) {
        body.addClass('dark-mode');
        
      }
    
      darkModeToggle.click(function() {
        body.toggleClass('dark-mode');
        if (body.hasClass('dark-mode')) {
          localStorage.setItem('darkMode', 'true');  
          
        } else {
          localStorage.removeItem('darkMode');
          body.css("color:dark; background-color:white;");
          icon.css("color:black;");
        }
      });
    });
    
  </script>

  <!-- end of jquery code  -->
</body>
</html>