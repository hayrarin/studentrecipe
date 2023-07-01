<?php
    require_once('connection.php');
    $id=$_GET['id'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $name=$_POST['name'];
    $_SESSION['username'] = $_POST['username'];

        $result = mysqli_query($conn, "SELECT * FROM admin WHERE username ='$username'");

        $result1 = mysqli_query($conn, "SELECT * FROM user WHERE username ='$username'");

        $result2 = mysqli_query($conn, "SELECT * FROM designer WHERE username ='$username'");
    if(isset($_POST['updateProfile'])){
        if(mysqli_num_rows($result)== 1){
            $row = mysqli_fetch_assoc($result);
            
            mysqli_query($conn,"update admin set username='$username', name='$name' where id='$id'");
            header("location:adminprofile.php?msg=updatesuccess");
        } else if(mysqli_num_rows($result1)== 1){
            $row = mysqli_fetch_assoc($result);
            
            mysqli_query($conn,"update user set username='$username', 
            phone='$phone', email='$email', name='$name' where userID='$id'");
            header("location:profile.php?msg=updatesuccess");
        } else if(mysqli_num_rows($result2)== 1){
            $row = mysqli_fetch_assoc($result);
            
            mysqli_query($conn,"update designer set username='$username', 
            phone='$phone', email='$email', name='$name' where designerID='$id'");
            header("location:designerprofile.php?msg=updatesuccess");
        } else {
            echo "<script>
				alert('Username cannot be changed!')
				</script>";
        }
    }

    $oldpass=$_POST['oldpass'];
    $newpass=$_POST['newpass'];
    $query=mysqli_query($conn, "select password from user where userID='$id'");
    $row=mysqli_fetch_array($query);

    if(isset($_POST['changePass'])){
        if(md5($oldpass)==$row["password"]){
            mysqli_query($conn,"update user set password=md5('$newpass') where userID='$id'");
            header("location:profile.php?msg=changesuccess");
        }else{
            header("location:profile.php?msg=wrongpassword");
        }
    }
    if(isset($_POST['delete'])){
        mysqli_query($conn,"DELETE FROM user WHERE userID='$id'");
        include"logout.php";
    }
?>