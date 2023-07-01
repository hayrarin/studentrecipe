<?php $currentPage ='home'; ?>
<?php

require 'connection.php';

//search ditekan
if(isset($_POST["search"])){
    $main = search($_POST["keyword"]);
}
?>

<?php
  include 'header.php';
?>
<br>

        <div class="heading-wrap">
            <h2>Students Web-Based Recipe E-Book </h2>
          </div>

    <!--Start recipe filter-->
    <section class="recipe-filter">
      <ul>
        <li class="list active" data-filter="all">All</li>
        <li class="list" data-filter="appetizer">Appetizer</li>
        <li class="list" data-filter="main_dish">Main Dish</li>
        <li class="list" data-filter="side_dish">Side Dish</li>
        <li class="list" data-filter="drinks">Drinks</li>
        <li class="list" data-filter="dessert">Dessert</li>
      </ul>
      <div class="recipe">
      <?php
    $recipes = "SELECT * FROM recipes;";
    $result = mysqli_query($conn, $recipes);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)){
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
    }

?>
  </div>
    </section>
    
    <script>
      let list = document.querySelectorAll(".list");
      let itemBox =document.querySelectorAll(".itemBox");

      for(let i = 0; i<list.length; i++){
        list[i].addEventListener('click', function(){
          for(let j = 0; j<list.length; j++){
            list[j].classList.remove('active');
          }
          this.classList.add('active');

          let dataFilter = this.getAttribute('data-filter');

          for(let k = 0; k<itemBox.length; k++){
            itemBox[k].classList.remove('active');
            itemBox[k].classList.add('hide');

            if(itemBox[k].getAttribute('data-item') == dataFilter || dataFilter == "all"){
              itemBox[k].classList.remove('hide');
              itemBox[k].classList.add('active');
            }
          }
        })
      }
    </script>
    <!--End recipe filter-->
      
<?php
  include 'footer.php';
?>

