<?php
// update_profile.php

require 'connection.php';

if (isset($_POST['updateProfile'])) {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Perform the update query
    $query = "UPDATE user SET name='$name', phone='$phone', email='$email' WHERE userID='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect back to the profile page with success message
        header("Location: profile.php?msg=updatesuccess");
        exit();
    } else {
        // Redirect back to the profile page with error message
        header("Location: profile.php?msg=updateerror");
        exit();
    }
}

if (isset($_POST['changePass'])) {
    $id = $_GET['id'];
    $oldPassword = $_POST['oldpass'];
    $newPassword = $_POST['newpass'];

    // Fetch the current user's information from the database
    $query = mysqli_query($conn, "SELECT * FROM user WHERE userID='$id'");
    $row = mysqli_fetch_array($query);
    $storedPassword = $row['password'];

    // Verify the old password
    if (password_verify($oldPassword, $storedPassword)) {
        // Generate a hash of the new password
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $updateQuery = "UPDATE user SET password='$newPasswordHash' WHERE userID='$id'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            // Redirect back to the profile page with success message
            header("Location: profile.php?msg=changesuccess");
            exit();
        } else {
            // Redirect back to the profile page with error message
            header("Location: profile.php?msg=changeerror");
            exit();
        }
    } else {
        // Redirect back to the profile page with wrong password message
        header("Location: profile.php?msg=wrongpassword");
        exit();
    }
}

// Delete Account
    if(isset($_POST['delete'])){
        $id = $_GET['id'];
        mysqli_query($con,"DELETE FROM user WHERE userID='$id'");
        include"logout.php";
    }
?>
