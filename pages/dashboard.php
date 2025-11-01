<?php include('../assets/INCLUDE/script.php');

       $total_members = $con->query("SELECT COUNT(*) AS total_members FROM `members`")->fetchColumn();

       $total_staff = $con->query("SELECT COUNT(*) AS total_staff FROM `staff`")->fetchColumn();


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
    <title>Dashboard</title>
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
    .btn {
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

    .btn:hover {
    box-shadow: inset 4px 4px 6px -1px rgba(0,0,0,0.2),
            inset -4px -4px 6px -1px rgba(255,255,255,0.7),
            -0.5px -0.5px 0px rgba(255,255,255,1),
            0.5px 0.5px 0px rgba(0,0,0,0.15),
            0px 12px 10px -10px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.1);
    transform: translateY(0.5em);
    }

    .btn i {
    position: absolute;
    top: 15px;
    right: 10px;
    width: 25px;
    height: 25px;
    transition: transform 0.5s;
    }
     
    .btn:hover i {
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
    .card_dash_chart{
        height: 500px;
        gap: 20px;
        padding: 10px;
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
    
    
    
    @media (min-width:725px) ,(max-width:950px){
        #myChart{
           min-width: 400px;
            height: 170px;
        }
   
        
        .card_dash{
          
            gap: 30px;
        }
        .card_dash_chart h3{
            font-family: 'Montserrat';
            padding-top: 30px;
        }
    }
    @media (max-width:725px){
        main{
            
            
            gap: 20px;
        }
        #myChart{
           min-width: 380px;
            height: 160px;
        }
        
        .card_dash{
            grid-area: initial ;
            
        }

        .big_title{
        visibility: hidden;
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
                    <span class="big_title "><center><h1>Dashboard</h1></center></span>
        </header>
        <!----------------------------------------------End of Header Code -->
        
            
        <main class="main text-center">
            
                        
                        
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="card_dash " >
                                <div class="card-body">
                                    <h2><i class="fa-solid fa-users"></i></h2>
                                    
                                
                                        
                                    <h1 class="card-title"><?=number_format($total_members)?></h1>

                                    <h6 class="card_dash-text">TOTAL Members</h6>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card_dash " >
                                <div class="card-body">
                                    <h2><i class="fa fa-briefcase"></i></h2>
                                    
                                    <h1 class="card-title"><?=number_format($total_staff)?></h1>

                                    <h6 class="card_dash-text">TOTAL Staff Members</h6>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 g-4">
                        <div class="col-6 ">
                            <div class="card_dash_chart" ><h3>Stastic of new members</h3>
                            <canvas id="myChart" width="auto" height="auto"></canvas>
                            </div>
                        </div>
                        <div class="col-6 h-100 py-3">
                        <div class="card_dash_chart"><h3>Income</h3>
                        <canvas id="income" width="auto" height="auto"></canvas>
                        </div>
                        </div>
                    </div>
        </main>
     
    <!-- jquery code -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://www.jsdelivr.com/package/npm/chart.js?path=dist"></script>
        <script>
        // new client statistic chart script
        const Data = {
                labels: <?= json_encode($labels) ?>,
                datasets: [
                    {
                        label:'new member',
                        borderColor: 'cyan',
                        backgroundColor: 'rgba(0, 255, 255, 0.1)',
                        fill: true,
                        data : <?= json_encode($data) ?>,
                    }, 
                ],
                };
                const options1 = {
                responsive: true,
                
                };

                const new_mem = document.getElementById('myChart').getContext('2d');
                const ctx = new Chart(new_mem, {
                type: 'line',
                data: Data,
                options: options1,
                });
                // Income chart code
            const data = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [
                    {
                    label: 'Membership Fees',
                    data: [5000, 9000, 7500, 8000,5000 , 3000],
                    borderColor: 'green',
                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                    fill: true,
                    },        
                    
                ],
                };

                const options = {
                responsive: true,
                title: {
                    display: true,
                    text: 'Gym Revenue by Source',
                },
                scales: {
                    yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    },
                    }],
                },
                };

                const income = document.getElementById('income').getContext('2d');
                const chart = new Chart(income, {
                type: 'line',
                data: data,
                options: options,
                });
        </script>
</body>
</html>