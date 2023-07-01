<?php $currentPage ='appetizer'; ?>
<?php

session_start();
require 'connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Recipe | Appetizer</title>
    <style>
        .like-btn {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            float: right; /* Added float right */
        }
        
        .like-btn:hover {
            background-color: var(--primary-color-dark);
        }
    </style>
</head>
<body>

<?php
  include 'header.php';
?>
<?php
    $id = $_GET["id"];
    $appetizer = "SELECT picture, name, prep_time, cook_time, ingredient, steps, video_url, videoname FROM recipes WHERE $id = id AND category='appetizer'" ;
    $result = mysqli_query($conn, $appetizer);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0) {
        ($row = mysqli_fetch_assoc($result));
        $videoname = $row['videoname'];
    }
?>
<div><br>
      <h1 style="text-align: center; font-size: 2.5rem; margin-top: 10px; text-shadow: 2px 2px #000000; color: var(--primary-color);"> </h1><br>
  </div>
    <div class="single-recipe">
        <header>
        <h2 style="padding-bottom: 10px;">
          <?php echo $row['name']?>
          <button class="like-btn">Like</button>
        </h2>
        </header>
        
        <div class="single-recipe-img">
            <img src="img/<?php echo $row['picture'] ?>" width=400px; height=350px;/>
        </div><br>
        
        <div class="single-recipe-video">
            <?php
            if(isset($_SESSION["login"]) && $_SESSION["login"] ){
                echo "<video src='videos/".$videoname."' controls width='400px' height='350px' >";
            } else {
                echo '<h3 style="margin:auto; width:73%; border:2px solid steelblue; text-align: center;padding: 40px; color:solid black;">Please sign in to watch the videos<br><br><a href="login.php" class=""> Login</a></h3>';
            }
            ?>
        </div>
        
        <div class="recipe-icons">
            <article>
                <i class="fas fa-clock"></i>
                <h5>Preparation time</h5>
                <p><?php echo $row['prep_time']?></p>
            </article>

            <article>
                <i class="far fa-clock"></i>
                <h5>Cooking time</h5>
                <p><?php echo $row['cook_time']?></p>
            </article>
        </div>
      
        <section class="recipe-content">
            <br>
            <article>
                <h4>Ingredients</h4><br>
                <p class="space">
                    <?php echo $row['ingredient']?>
                </p>
            </article>
            <br>
            <article>
                <h4>Instructions</h4><br>
                <p class="space">
                    <?php echo $row['steps'];?>
                </p>
            </article>
            
            <div class="print-btn">
                <button onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i>  Print this recipe</button>
            </div>
            
            <?php
            if(isset($_SESSION["login"]) && $_SESSION["login"] ){
                echo '<h3 style="text-align:center; padding-top: 30px;">Scan this QR code to watch tutorial video</h3>';
                echo '<div class="qr-code">';
                echo '<img style="display:none;" id="qrcode-img">';
                echo '</div>';
            }
            ?> 
        </section>
    </div>

<script>
    let img  = document.getElementById("qrcode-img");
    img.setAttribute("src", "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl="+"<?php echo $row['video_url'] ?>"+"%26d="+Date.now()+"&chld=L|1&choe=UTF-8")
    img.style.display='block';
    setInterval(() => { 
        img.setAttribute("src", "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl="+"<?php echo $row['video_url'] ?>"+"%26d="+Date.now()+"&chld=L|1&choe=UTF-8")
    }, 3000);
</script>

<script>
    const likeBtn = document.querySelector(".like-btn");

    likeBtn.addEventListener("click", function() {
        // Perform the action when the like button is clicked
        // You can add your logic here, such as sending an AJAX request to update the like count in the database
    });
</script>

<script src="js/main-vanila.js"></script>
<script src="js/script.js"></script>

<?php
    if(isset($_SESSION["login"]) && $_SESSION["login"] ){
        include 'rating_recipe.php';
    } else {
        echo "<br>";
        echo '<h3 style="margin:auto; width:80%; border:2px solid steelblue; text-align: center;padding: 40px; color:solid black;">Please Login to Rate and Review the recipes<br><br><a href="login.php" class=""> Login</a></h3>';
        echo "<br>";
    } 
?>

<?php
  include 'footer.php';
?>
