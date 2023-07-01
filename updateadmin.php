<?php
// update_profile.php

require 'connection.php';

if (isset($_POST['updateProfile'])) {
    $id = $_GET['id'];
    $name = $_POST['name'];

    // Perform the update query
    $query = "UPDATE admin SET name='$name' WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect back to the profile page with success message
        header("Location:  adminprofile.php?msg=updatesuccess");
        exit();
    } else {
        // Redirect back to the profile page with error message
        header("Location: adminprofile.php?msg=updateerror");
        exit();
    }
}

if (isset($_POST['changePass'])) {
    $id = $_GET['id'];
    $oldPassword = $_POST['oldpass'];
    $newPassword = $_POST['newpass'];

    // Fetch the current user's information from the database
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE id='$id'");
    $row = mysqli_fetch_array($query);
    $storedPassword = $row['password'];

    // Verify the old password
    if (password_verify($oldPassword, $storedPassword)) {
        // Generate a hash of the new password
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $updateQuery = "UPDATE admin SET password='$newPasswordHash' WHERE id='$id'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            // Redirect back to the profile page with success message
            header("Location: adminprofile.php?msg=changesuccess");
            exit();
        } else {
            // Redirect back to the profile page with error message
            header("Location: adminprofile.php?msg=changeerror");
            exit();
        }
    } else {
        // Redirect back to the profile page with wrong password message
        header("Location: adminprofile.php?msg=wrongpassword");
        exit();
    }
}

// Delete Account
    if(isset($_POST['delete'])){
        $id = $_GET['id'];
        mysqli_query($con,"DELETE FROM admin WHERE id='$id'");
        include"logout.php";
    }
?>
