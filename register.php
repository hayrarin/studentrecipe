<?php
require 'connection.php';

if(isset($_POST["registeruser"])){

    if(registeruser($_POST)> 0){
        echo "<script>
                alert ('User registered successfully.');
                document.location.href='userlist.php';
            </script>";
    }else if(registerdesigner($_POST)> 0){
        echo "<script>
                alert ('Designer registered successfully.');
                document.location.href='designerlist.php';
            </script>";
    }
    else{
        echo mysqli_error($conn);
    }
} else if(isset($_POST["registerdesigner"])){

    if(registerdesigner($_POST)> 0){
        echo "<script>
                alert ('Designer registered successfully.');
                document.location.href='designerlist.php';
            </script>";
    }
    else{
        echo mysqli_error($conn);
    }
}
?>
    
<body>
        <?php 
            include"header.php";
        ?>
        <!--Start breadcrumb-->
        <ul class="breadcrumb">
            <li><a href="login.php" class="fa fa-arrow-circle-left"> Back</a></li>
        </ul>
        <!--End breadcrumb-->
    
        <div class="login-container">
          <div class="login-wrapper">
                <div id="main">
      <!-- Tab Buttons -->
      <div id="tab-btn">
        <a href="#" class="login-tab active">New User</a>
        <a href="#" class="register-tab">New Designer</a>
      </div>
      <!-- Login Form -->
      <div class="login-box">
        <h2>Want more recipe? Join Us!</h2>
        <div class="login-input">
        <form action="" method="post">
                <div class="row">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="username cannot be changed" require>
                </div>
               <div class="row">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name="email" id="email" placeholder="email" require>
                </div>
                <div class="row">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" placeholder="password" id="password" require>
                </div>
                <div class="row">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password2" placeholder="Confirm Password" id="password2" require>
                </div>
               <a href="login.php" class="">Existing user? Login now!</a>
            <div class="row">
                <button type="submit" name="registeruser">Register!</button>
            </div>
                <p>
  		
  	</p>
           </form>
        </div>
      </div>
      <!-- Registration Form -->
      <div class="register-box">
        <h2>Love posting recipe? Join Us!</h2>
<div class="login-input">
           <form action="" method="post">
                <div class="row">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="username cannot be changed" require>
                </div>
               <div class="row">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name="email" id="email" placeholder="email" require>
                </div>
                <div class="row">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" placeholder="password" id="password" require>
                </div>
                <div class="row">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password2" placeholder="Confirm Password" id="password2" require>
                </div>
               <a href="login.php" class="">Existing user? Login now!</a>
            <div class="row">
                <button type="submit" name="registerdesigner">Register!</button>
            </div>
                <p>
  		
  	</p>
           </form>
                </div>
      </div>
    </div>
            </div>
    </div>
    <script>
                $(document).ready(function () {
  $(".register-tab").click(function () {
    $(".register-box").show();
    $(".login-box").hide();
    $(".register-tab").addClass("active");
    $(".login-tab").removeClass("active");
  });
  $(".login-tab").click(function () {
    $(".login-box").show();
    $(".register-box").hide();
    $(".login-tab").addClass("active");
    $(".register-tab").removeClass("active");
  });
});
    </script>
</body>