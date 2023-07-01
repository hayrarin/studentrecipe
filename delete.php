<?php

require'connection.php';

    $id = $_GET["id"];

    if(deleteuser($id) > 0){
        echo "<script>alert('User deleted successfully.')
                    document.location.href='userlist.php'        
            </script>";
    }else if(deleterecipe($id) > 0){
        echo "<script>alert('Recipe deleted successfully.')
                    document.location.href='dashboard.php'        
            </script>";
    }else if(deleteadmin($id) > 0){
        echo "<script>alert('Admin deleted successfully.')
                document.location.href='adminmanage.php'        
            </script>";
    }else if(deletedesigner($id) > 0){
        echo "<script>alert('Designer deleted successfully.')
                document.location.href='designerlist.php'        
            </script>";
    }else if(deletefeedback($id) > 0){
        echo "<script>alert('Feedback deleted successfully.')
                    document.location.href='feedbackmanage.php'        
            </script>";
    }else{
        echo "<script>alert('Oops! Data failed to be deleted. Try again. ')
                    document.location.href='userlist.php'        
            </script>";
    }

?>