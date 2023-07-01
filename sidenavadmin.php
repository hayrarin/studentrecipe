<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
</head>
<div class="sidebar">
<div class="sidenav">
    <div class="logo-details">
    </div>
    <?php
        if(($_SESSION["username"]== "admin")){
            echo"<a href='dashboard.php'>Dashboard</a>";
            echo"<a href='recipemanage.php'>Recipe Management</a>";
            echo"<a href='designerlist.php'>Designer Management</a>";
            echo"<a href='userlist.php'>User Management</a>";
            echo"<a href='adminprofile.php'>Profile Management</a>";
            echo"<a href='report.php'>Report Management</a>";
        }
            else{
                echo"<a href='dashboard.php'>Dashboard</a>";
                echo"<a href='recipemanage.php'>Recipe Management</a>";
                echo"<a href='designerprofile.php'>Profile Management</a>";
            }
                    ?>
    
    <a href="feedbackmanage.php"><i class="fa fa-commenting" aria-hidden="true"></i><br>Feedback Management</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i><br>Sign  Out</a>
  </div>
</div>