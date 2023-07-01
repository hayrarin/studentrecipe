<?php
session_start();
require 'connection.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$recipe = query("SELECT * FROM recipes;");

if (isset($_POST["search"])) {
    $main = search($_POST["keyword"]);
}

if (isset($_POST["submit"])) {
    if (!empty($_POST['category'])) {
        $selected = $_POST['category'];
    } else {
        echo 'Please select a value.';
    }
    
    if (add($_POST) > 0) {
        echo "<script>alert('New recipe added successfully.');
                document.location.href='dashboard.php';        
        </script>";
    } else {
        echo "<script>alert('Oops! Failed to add a new recipe. Please try again.');
            document.location.href='recipemanage.php';        
        </script>";
    }
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    switch ($sort) {
        case 'name_asc':
            $recipe = query("SELECT * FROM recipes ORDER BY name ASC;");
            break;
        case 'name_desc':
            $recipe = query("SELECT * FROM recipes ORDER BY name DESC;");
            break;
        case 'prep_asc':
            $recipe = query("SELECT * FROM recipes ORDER BY prep_time ASC;");
            break;
        case 'prep_desc':
            $recipe = query("SELECT * FROM recipes ORDER BY prep_time DESC;");
            break;
        case 'cook_asc':
            $recipe = query("SELECT * FROM recipes ORDER BY cook_time ASC;");
            break;
        case 'cook_desc':
            $recipe = query("SELECT * FROM recipes ORDER BY cook_time DESC;");
            break;
        default:
            $recipe = query("SELECT * FROM recipes;");
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <title>Recipe Management</title>
    <style>
        /* Add your custom CSS styles here */
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-gap: 20px;
            margin-top: 20px;
        }
        
        .recipe-card {
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
            text-align: center;
        }
        
        .recipe-card img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .recipe-card h3 {
            margin-top: 10px;
            font-size: 18px;
        }
        
        .recipe-card p {
            margin-top: 5px;
            font-size: 14px;
            color: #777;
        }
        
        .recipe-card .actions {
            margin-top: 10px;
        }
        
        .recipe-card .actions a {
            display: inline-block;
            margin: 5px;
            padding: 5px 10px;
            text-decoration: none;
            background-color: lightgrey;
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .recipe-card .actions a i {
            margin-right: 5px;
        }
        
        .sort {
            text-align: right;
            margin-bottom: 10px;
        }

        .sort label {
            font-weight: bold;
            margin-right: 5px;
        }

        .sort select {
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        
    </style>
</head>
<body>
    <?php include 'sidenavadmin.php'; ?>

    <div class="content">
        <div class="main">
            <div class="welcome"><br>
                <hr style="border-top: 1px solid #00008B; margin: 0;"><br>
                <h1 style="text-align:center;">Welcome back! <?php echo $_SESSION["username"]; ?></h1><br>
                <hr style="border-top: 1px solid #00008B; margin: 0;">
            <br><br>
            </div>
            <h1 style="text-align:center;background-color:#00008B;">Recipe List</h1>
            <br>
            <div class="sort">
                <label for="sort">Sort By:</label>
                <select id="sort" name="sort" onchange="sortRecipes(this.value)">
                    <option value="">-- Select --</option>
                    <option value="name_asc">Name (Ascending)</option>
                    <option value="name_desc">Name (Descending)</option>
                    <option value="prep_asc">Preparation Time (Ascending)</option>
                    <option value="prep_desc">Preparation Time (Descending)</option>
                    <option value="cook_asc">Cooking Time (Ascending)</option>
                    <option value="cook_desc">Cooking Time (Descending)</option>
                </select>
            </div>
            <button id="myBtn" class="addbutton" onclick="document.getElementById('myModal').style.display='block'"><i class="fa fa-plus" aria-hidden="true"></i> Add Recipe</button><br>
            <div class="search">
                <input type="text" id="myInput" onkeyup="myFunction2()" placeholder="Search Recipe" title="Type in a recipe name">
            </div>
             <!-- pop up add -->
<div id="myModal" class="modal">
  <!-- COntent add -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Add Recipe</h2>
    </div>
    <div class="modal-body">
      <form text-decoration: none;action="" method="post" enctype="multipart/form-data">
                <label style="font-weight:bold;font-size:1.5em;" for="category">Recipe category: </label><br>
                <select style="height:50px;width:500px;" id="category" name="category">                      
                    <option value="0">--Select Category--</option>
                    <option value="appetizer">Appetizer</option>
                    <option value="main_dish">Main Dish</option>
                    <option value="side_dish">Side Dish</option>
                    <option value="drinks">Drinks</option>
                    <option value="dessert">Dessert</option>
                </select>
            <br>
            <br>
            
                <label style="font-weight:bold;font-size:1.5em;" for="name">Recipe name: </label><br>   
                <input style="height:50px;width:500px;" type="text" name="name" id="name" required>
            <br>
            <br>
                <label style="font-weight:bold;font-size:1.5em;" for="prep_time">Preparation time: </label><br>
                <input style="height:50px;width:500px;" type="text" name="prep_time" id="prep_time" required>
            <br>
            <br>
                <label style="font-weight:bold;font-size:1.5em;" for="cook_time">Cooking time: </label><br>
                <input style="height:50px;width:500px;" type="text" name="cook_time" id="cook_time" required>
            <br>
            <br>
                <label style="font-weight:bold;font-size:1.5em;" for="ingredient">Ingredients: </label><br>
                <textarea type="text" name="ingredient" id="ingredient" required rows="8" columns="50" style="width:50%"></textarea>
            <br>
            <br>
                <label style="font-weight:bold;font-size:1.5em;" for="steps">Steps: </label><br>
                <textarea type="text" name="steps" id="steps" required rows="8" columns="50" style="width:50%"></textarea>
            <br>
            <br>
                <label style="font-weight:bold;font-size:1.5em;" for="picture">Image: </label>
                <input style="text-align:center;background-color:#cd4a4a;font-size:1.5em;border-radius: 12px;padding:5px;" type="file" name="picture" id="picture" required>
            <br>
            <br>
                <label style="font-weight:bold;font-size:1.5em;" for="picture">Video: </label>
                <input style="text-align:center;background-color:#cd4a4a;font-size:1.5em;border-radius: 12px;padding:5px;" type="file" name="video" id="video" required>
            <br>
            <br>
                <label style="font-weight:bold;font-size:1.5em;" for="url">Video URL: </label><br>
                <input style="height:50px;width:500px;" type="text" name="video_url" id="url" required>
            <br>
            <br>
                <button style="text-align:center;background-color:#cd4a4a;font-size:1.5em;border-radius: 12px;padding:5px;" type="submit" name="submit" onclick="return confirm('Are you sure you want to add this recipe?');">Add New Recipe</button>
        </form>
    </div>
  </div>
</div> 

            <div class="recipe-grid">
                <?php foreach ($recipe as $row) : ?>
                    <div class="recipe-card">
                        <img src="img/<?php echo $row['picture']; ?>" alt="Recipe Image">
                        <h3><?php echo $row['name']; ?></h3>
                        <p>Preparation Time: <?php echo $row['prep_time']; ?></p>
                        <p>Cooking Time: <?php echo $row['cook_time']; ?></p>
                        <div class="actions">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" style="color: green"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this recipe?');" style="color: red"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form method="post" action="recipemanage.php">
                        <label for="name">Recipe Name:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="prep_time">Preparation Time:</label>
                        <input type="text" id="prep_time" name="prep_time" required>

                        <label for="cook_time">Cooking Time:</label>
                        <input type="text" id="cook_time" name="cook_time" required>

                        <label for="ingredient">Ingredients:</label>
                        <textarea id="ingredient" name="ingredient" required></textarea>

                        <label for="steps">Steps:</label>
                        <textarea id="steps" name="steps" required></textarea>

                        <label for="videoname">Video Name:</label>
                        <input type="text" id="videoname" name="videoname" required>

                        <label for="picture">Picture:</label>
                        <input type="file" id="picture" name="picture" required>

                        <button type="submit" name="submit" class="btn-submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
        // Function to sort recipes based on the selected option
            function sortRecipes(value) {
                window.location.href = 'recipemanage.php?sort=' + value;
            }
        function myFunction2() {
            var input, filter, cards, cardContainer, h3, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            cardContainer = document.getElementsByClassName("recipe-grid")[0];
            cards = cardContainer.getElementsByClassName("recipe-card");
            for (i = 0; i < cards.length; i++) {
                h3 = cards[i].getElementsByTagName("h3")[0];
                txtValue = h3.textContent || h3.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    </script>
</body>
</html>
