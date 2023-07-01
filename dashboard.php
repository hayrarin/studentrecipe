<?php
session_start();
require 'connection.php';

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$appetizer = query("SELECT * FROM recipes WHERE category = 'appetizer';");
$main = query("SELECT * FROM recipes WHERE category = 'main_dish';");
$side = query("SELECT * FROM recipes WHERE category = 'side_dish';");
$drink = query("SELECT * FROM recipes WHERE category = 'drinks';");
$dessert = query("SELECT * FROM recipes WHERE category = 'dessert';");

//search ditekan
if (isset($_POST["search"])) {
  $main = search($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Recipe Page</title>
  <style>

    .welcome {
      text-align: center;
    }

    .page-heading {
      text-align: center;
      background-color: #00008B;
      color: #fff;
      padding: 10px;
    }

    .recipe-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-gap: 10px;
      margin-top: 20px;
      justify-items: center;
    }

    .recipe-item {
      background-color: #f5f5f5;
      border-radius: 5px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 350px; /* Fixed width */
      height: 300px; /* Fixed height */
    }

    .recipe-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 5px;
    }

    .recipe-item h3 {
      font-size: 18px;
      margin-top: 10px;
    }

    .recipe-item p {
      margin: 0;
      color: #777;
    }
  </style>
</head>
<body>
  <?php include 'sidenavadmin.php'; ?>

  <div class="content">
    <div class="main">
      <div class="welcome">
        <hr>
        <h1>Welcome back, <?php echo $_SESSION["username"]; ?></h1>
        <hr>
      </div>
      <h1 class="page-heading">All Data Recipe</h1>

      <div class="recipe-grid">
        <?php
        $recipes = "SELECT * FROM recipes;";
        $result = mysqli_query($conn, $recipes);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $picture = $row['picture'];
            $id = $row['id'];
            $category = $row['category'];
            $name = $row['name'];
            $prep_time = $row['prep_time'];
            $cook_time = $row['cook_time'];
            $ingredient = $row['ingredient'];
            $steps = $row['steps'];
            ?>
            <div class="recipe-item" data-category="<?php echo $category; ?>">
                <img src="img/<?php echo $picture; ?>"/>
                <h3><?php echo $name; ?></h3>
                <p>Prep: <?php echo $prep_time; ?> | Cook: <?php echo $cook_time; ?></p>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>

</body>
</html>
