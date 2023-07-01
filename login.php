<?php $currentPage ='login'; ?>
<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require 'connection.php';/////mulakan connection
if(isset($_SESSION["login"]) && $_SESSION["login"] ){///////////// jika sudah login tetap ke laman index
    
    header("Location:dashboard.php");
    exit;
}
//cek cookie
if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){
    $id=$_COOKIE['id'];
    $key=$_COOKIE['key'];

    //ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM admin WHERE id= $id" );
    $row = mysqli_fetch_assoc($result); 
    
    $result1 = mysqli_query($conn, "SELECT username FROM user WHERE id= $id" );
    $row = mysqli_fetch_assoc($result1); 
    
    $result2 = mysqli_query($conn, "SELECT username FROM designer WHERE id= $id" );
    $row = mysqli_fetch_assoc($result2); 

    //cek cookie dan username
    if($key === hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }
}

if(isset($_POST["login"])){///jika button submit login ditekan
    $username = $_POST["username"];
    $password =$_POST["password"];
    $_SESSION['username'] = $_POST['username'];
    
    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username ='$username'");
    
    $result1 = mysqli_query($conn, "SELECT * FROM user WHERE username ='$username'");
    
    $result2 = mysqli_query($conn, "SELECT * FROM designer WHERE username ='$username'");
    
    //cek username
    if(mysqli_num_rows($result)=== 1){////cek stiap row klau sme username

        //cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])){//jika pass verify sama, masuk home page
            

            //set session
            $_SESSION["login"] = true;

            //cek remember me
            if(isset($_POST['remember'])){
                //buat cookie
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username'],time()+60));////////encrypt the username
            }


            header("Location: dashboard.php");
            exit;
        } else {
            header("location:login.php?msg=wrongpassword");
        }
    } else if(mysqli_num_rows($result1)=== 1){////cek stiap row klau sme username

        //cek password
        $row = mysqli_fetch_assoc($result1);
        if (password_verify($password, $row["password"])){//jika pass verify sama, masuk home page
            

            //set session
            $_SESSION["login"] = true;

            //cek remember me
            if(isset($_POST['remember'])){
                //buat cookie
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username'],time()+60));////////encrypt the username
            }


            header("Location: index.php");
            exit;
        } else {
            header("location:login.php?msg=wrongpassword");
        }
    } else if(mysqli_num_rows($result2)=== 1){////cek stiap row klau sme username

        //cek password
        $row = mysqli_fetch_assoc($result2);
        if (password_verify($password, $row["password"])){//jika pass verify sama, masuk home page
            

            //set session
            $_SESSION["login"] = true;

            //cek remember me
            if(isset($_POST['remember'])){
                //buat cookie
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username'],time()+60));////////encrypt the username
            }


            header("Location: dashboard.php");
            exit;
        } else {
            header("location:login.php?msg=wrongpassword");
        }
    } else {
        $error = true;
    }
}


?>

<?php
  include 'header.php';
?>
    <!--Start breadcrumb-->
    <ul class="breadcrumb">
        <li><a href="index.php" class="fa fa-arrow-circle-left"> Back</a></li>
    </ul>
    <!--End breadcrumb-->
<div class="login-container">
  <div class="login-wrapper">
    <div class="login-box">
        <div class="heading-wrap">
        <h2 style="margin-bottom: -30px;">Login</h2>
        </div>
    <?php if(isset($error)):?>
        <p style="color:red; font-style:italic; text-align: center;">No Account Exist! Register Now !</p>
    <?php endif; ?>

        <div class="login-input">
        <form action="" method="post">
            <div class="row">
                <i class="fas fa-id-card"></i>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="row">
                <i class="fas fa-key"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <a href="forgotpassword.php" class="" >Forgot Password? </a> <a href="register.php" class="" >  New User? Register now!</a>
            <div class="row">
                <button type="submit" name="login">Login</button>
            </div>
        </form>
        </div>
    </div>
  </div>
</div>
<?php
            if(isset($_GET['msg'])){
                if($_GET['msg']=="wrongpassword"){
                    echo"<script>alert('Your Password is Wrong! Please Try Again!');</script>";
                }
            }
        ?>
<?php
  include 'footer.php';
?>
