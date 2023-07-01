<!DOCTYPE html>
<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
?>
<html lang="en">
<head>
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" media="print" href="css/print.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <title>Student Recipe</title>
</head>
<style>
    .popup-form {
    display: none;
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    z-index: 9999;
    }

    .popup-form h2 {
        margin-top: 0;
    }

    .popup-form label {
        display: block;
        margin-bottom: 10px;
    }

    .popup-form input[type="text"],
    .popup-form input[type="email"] {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
    }

    .popup-form button[type="submit"] {
        background-color: steelblue;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="file"] {
            display: none;
        }

        .upload-btn {
            background-color: steelblue;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .upload-btn:hover {
            background-color: lightblue;
        }

        .file-label {
            background-color: #f2f2f2;
            padding: 10px 20px;
            display: inline-block;
            cursor: pointer;
        }
    </style>
<body>
        <hr style="border-top: 1px solid steelblue; margin: 0;">
     <!--Start navigation-->
     <nav>
        <div class="navbar-links">
            <ul>  
                <span style="border: 1px solid steelblue;border-width: 0 1px 0 0;"></span>
                <li><a href="index.php">Top Page</a></li>
                <div class="dropdown">
                    <li><a href="recipe.php" >Recipes <i class="fa fa-caret-down"></i></a>
                      <ul class="dropdown-content">
                          <li><a href="recipe.php?type=appetizer">Appetizer</a></li>
                          <li><a href="recipe.php?type=main_dish" >Main Dish</a></li>
                          <li><a href="recipe.php?type=side_dish" >Side Dish</a></li>
                          <li><a href="recipe.php?type=drinks" >Drinks</a></li>
                          <li><a href="recipe.php?type=dessert" >Dessert</a></li>
                      </ul>
                    </li>               
                </div>
                <li><a href="contactus.php" >Contact Us</a></li>
            </ul>
        </div>
        <div class="search-container">
        <button type="button" name="new-button" ><i class="fa fa-camera"></i></button>
        <div id="popup-form" class="popup-form">
            <form action="search_result.php" method="POST" enctype="multipart/form-data">
                <label for="photo" class="file-label">
                    Choose a photo
                </label>
                <input type="file" name="photo" id="photo" accept="image/*">
                <input type="submit" value="Search" class="upload-btn">
            </form>

        </div>
          <form action="search_result.php" method="GET" class="search-container">
          <input type="text" style="font-size: 17px;" placeholder="Search recipe here " name="search" required>
          <button type="submit" name="submit-search"><i class="fa fa-search"></i></button>
            
          </form>
       </div>

        <div class="navbar-links">
            <ul> 
                <span style="border: 1px solid steelblue;border-width: 0 1px 0 0;"></span>
                <!--<div class="dropdown">-->
                <?php
                        if(isset($_SESSION["login"]) && $_SESSION["login"] ){
                            echo"<li><a href='Profile.php'>Profile</a></li>";
                            echo"<li><a href='logout.php'>Logout</a></li>";
                        }
                        else{
                            echo"<li><a href='login.php'>Login</a></li>";
                        }
                    ?>
                <!--</div>-->
                <!--<div class="dropdown">
                    <li><a href="recipe.php" >Profile <i class="fa fa-caret-down"></i></a>
                      <ul class="dropdown-content">
                          <li><a href="likepage.php" >Like Recipe</a></li>
                          <li><a href="logout.php" >Logout</a></li>
                      </ul>
                    </li>               
                </div>-->
            </ul>
        </div>
    </nav>
    <script>
        // Add an event listener to the button
document.querySelector('button[name="new-button"]').addEventListener('click', function() {
    // Show the popup form
    document.getElementById('popup-form').style.display = 'block';
});

// Close the popup form when the user clicks outside of it
window.addEventListener('click', function(event) {
    var popupForm = document.getElementById('popup-form');
    if (event.target == popupForm) {
        popupForm.style.display = 'none';
    }
});

    </script>
    <!--End navigation-->
    <hr style="border-top: 1px solid steelblue; margin: 0;">
 