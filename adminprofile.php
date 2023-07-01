<?php
require 'connection.php';
?>

        <?php
          include 'sidenavadmin.php';
        ?>
        <?php 
            $username = $_SESSION["username"];
            $query=mysqli_query ($conn,"SELECT * FROM admin WHERE username ='$username'");
            $row=mysqli_fetch_array($query);
            $id=$row["id"];
        ?>
    <div class="content">
            <div class="main">
          <div class="welcome"><br>
              <hr style="border-top: 1px solid #00008B; margin: 0;"><br>
        <h1 style="text-align:center;">Welcome back! <?php echo $_SESSION["username"];?></h1><br>
              <hr style="border-top: 1px solid #00008B; margin: 0;">
        </div><BR><BR>
                <h1 style="text-align:center;background-color:#00008B;">Profile Management</h1>
       <div class="profile-container">
    <h1>User Profile</h1><br>
    <form method="post" action="updateadmin.php?id=<?php echo $id; ?>">
        <div class="row">
            <div class="col-30"><label>Name: </label></div>
            <div class="col-70"><input type="text" name="name" value="<?php echo $row['name']; ?>"></div>
        </div>
        <div class="row">
            <div class="col-30"><label>Username: </label></div>
            <div class="col-70"><input type="text" name="username" value="<?php echo $row['username']; ?>" readonly></div>
        </div>
        <div class="row">
            <input class="btn-updateprofile" type="submit" value="Update Profile" name="updateProfile">
        </div>
    </form>
</div>

<div class="profile-container">
    <h1>Change Password</h1><br>
    <form method="post" action="updateadmin.php?id=<?php echo $id; ?>">
        <div class="row">
            <div class="col-30"><label>Old Password: </label></div>
            <div class="col-70"><input type="password" name="oldpass" id="oldpass"></div>
        </div>
        <div class="row">
            <div class="col-30"><label>New Password: </label></div>
            <div class="col-70"><input type="password" name="newpass" id="newpass"></div>
        </div>
        <div class="row">
            <input class="btn-changepass" type="submit" value="Change Password" name="changePass">
        </div>
    </form>
</div>


<?php
    if(isset($_GET['msg'])){
        if($_GET['msg'] == "updatesuccess"){
            echo "<script>alert('Update Profile Success');</script>";
        }
        if($_GET['msg'] == "changesuccess"){
            echo "<script>alert('Changing Password Success');</script>";
        } else if($_GET['msg'] == "wrongpassword"){
            echo "<script>alert('Your old password is incorrect. Please try again later');</script>";
        }
    }
?>

<?php include "footer.php";?>
