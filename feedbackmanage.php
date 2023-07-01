<?php
session_start();////////mula sini
require 'connection.php';

if(!isset($_SESSION["login"])){   /////////////------------>>>>>>>>>jika belum login x bole msuk page ini(ble gune utk store page)
    header("Location: login.php");
    exit;
}/////////// copy smpi sini 1 blok

$review = query("SELECT * FROM review ");
$feedback = query("SELECT * FROM contact");

//search ditekan
if(isset($_POST["search"])){
    $main = search($_POST["keyword"]);
}

?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
</head>
<?php
  include 'sidenavadmin.php';
?>

<div class="content">
        <div class="main">
      <div class="welcome"><br>
          <hr style="border-top: 1px solid #00008B; margin: 0;"><br>
    <h1 style="text-align:center;">Welcome back! <?php echo $_SESSION["username"];?></h1><br>
          <hr style="border-top: 1px solid #00008B; margin: 0;">
          <br><br>
    </div>
             <h1 style="text-align:center;background-color:#00008B;">FEEDBACK AND REVIEW LIST</h1>
 <br>
    <table id="myTable" class="tablemanage">
        <button class="sortbutton"><i class="fa fa-sort" aria-hidden="true"></i> Sort</button>
        <br>
        <div class="search">
          <input type="text" id="myInput" onkeyup="myFunction2()" style="font-size: 17px;" placeholder="Search Feedback" name="search" required>
       </div>
        
     
        <tr>
            <th>No.</th>
            <th>Review ID</th>
            <th>Username</th>
            <th>Review Star</th>
            <th>Message</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>

        <?php $i=1; ?>
        <?php foreach($review as $row) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $row["id"]; ?></td>
            <td><?= $row["userName"]; ?></td>
            <td class="space"><?= $row["userReview"]; ?></td>
            <td class="space"><?= $row["userMessage"]; ?></td>
            <td class="space"><?= $row["dateReviewed"]; ?></td>
            <td>
								<a href="delete.php?id=<?php echo $row['id']; ?>" class="fa fa-trash" style="color: red" onclick="return confirm('Are you sure you want to delete this data?');"></a>
							</td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    <br>
        <table id="myTable" class="tablemanage">
        <button class="sortbutton"><i class="fa fa-sort" aria-hidden="true"></i> Sort</button>
        <br>
        <tr>
            <th>No.</th>
            <th>Email</th>
            <th>Name</th>
            <th>Phone No</th>
            <th>Feedback/Messages</th>
            <th>Sent At</th>
        </tr>

        <?php $i=1; ?>
        <?php foreach($feedback as $row) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td><a href="mailto:<?= $row["email"]; ?>"><?= $row["email"]; ?></a></td>
            <td><?= $row["name"]; ?></td>
            <td><?= $row["phone_no"]; ?></td>
            <td><?= $row["message"]; ?></td>
            <td><?= $row["sent_at"]; ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    </div>
</div>

<script>
<script>
    function myFunction2() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        //assign input to variable 
        input = document.getElementById("myInput");
        //filtering the uppercase for input
        filter = input.value.toUpperCase();
        //assigning table 
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[5]; //the input will search for col 2
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) { //filtering uppercase with index
                    tr[i].style.display = "";	//display the output
                } else {
                    tr[i].style.display = "none"; //return none
                }
            }
        }
    }

    function sortTable() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("myTable");
        switching = true;

        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[0];
                y = rows[i + 1].getElementsByTagName("td")[0];

                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
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