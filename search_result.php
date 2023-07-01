<?php

require 'connection.php';
?>

<?php
  include 'header.php';
?>
<br>
<div class="searchingResult"><h2 style="text-align: center; color: black; font-weight: lighter; margin-top: 10px;">Here is your searching result: </h2></div>
<hr style="border-top: 1px solid steelblue; margin: 0;">
<hr style="border-top: 1px solid steelblue; margin: 0;"><br><br>
<div class="recipe recipe-search">
<?php
//search ditekan
if(isset($_GET["submit-search"])){
    //     $main = search($_POST["keyword"]);
        $search = mysqli_real_escape_string($conn, $_GET['search']);//prevent sql injection
        $sql = "SELECT * FROM recipes WHERE name LIKE '%$search%' OR category LIKE '%$search%' OR
        prep_time LIKE '%$search%' OR cook_time LIKE '%$search%' OR ingredient LIKE '%$search%'";
    
        $result = mysqli_query($conn, $sql);
        $queryResult = mysqli_num_rows($result);

        if ($queryResult > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $picture = $row['picture'];
                $id = $row['id'];
                $category = $row['category'];
                $name = $row['name'];
                $prep_time = $row['prep_time'];
                $cook_time = $row['cook_time'];
                $ingredient = $row['ingredient'];
                $steps = $row['steps'];
                
                echo"<div class=\"itemBox\" data-item=\"$category\">";
                    echo"<a href=\"$category.php?id=$id&type=$category\">";
                    echo"<img src=\"img/$picture\"/>";
                        echo"<h3>$name</h3>";
                        echo"<p>Prep : $prep_time | Cook : $cook_time</p>";
                    echo"</a>";
                echo"</div>";
            }
        } else if ($queryResult == 0){
            echo "Oops! There are no recipe matching your search. Try again with other keywords.";
        }
    }
    
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo']['tmp_name'])) {
    // Get the name of the uploaded picture file
    $uploadedFilePath = $_FILES['photo']['tmp_name'];
    $uploadedFileName = pathinfo($_FILES['photo']['name'], PATHINFO_FILENAME);

    // Connect to your MySQL database
    $conn = mysqli_connect("localhost","root","","recipebook");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to search for similar images
    $sql = "SELECT * FROM recipes WHERE name LIKE '%$uploadedFileName%' OR category LIKE '%$uploadedFileName%' OR
        prep_time LIKE '%$uploadedFileName%' OR cook_time LIKE '%$uploadedFileName%' OR ingredient LIKE '%$uploadedFileName%' OR picture LIKE '%$uploadedFileName%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the matching recipes
        while ($row = $result->fetch_assoc()) {
            $picture = $row['picture'];
                $id = $row['id'];
                $category = $row['category'];
                $name = $row['name'];
                $prep_time = $row['prep_time'];
                $cook_time = $row['cook_time'];
                $ingredient = $row['ingredient'];
                $steps = $row['steps'];
                
                echo"<div class=\"itemBox\" data-item=\"$category\">";
                    echo"<a href=\"$category.php?id=$id&type=$category\">";
                    echo"<img src=\"img/$picture\"/>";
                        echo"<h3>$name</h3>";
                        echo"<p>Prep : $prep_time | Cook : $cook_time</p>";
                    echo"</a>";
                echo"</div>";
            // Display other recipe details as needed
        }
    } else {
        echo "No matching recipes found.";
        echo $uploadedFileName;
    }

    $conn->close();
}
    
?>
  </div>
<br><br> 
<hr style="border-top: 1px solid steelblue; margin: 0;">
<hr style="border-top: 1px solid steelblue; margin: 0;">      
<?php
  include 'footer.php';
?>