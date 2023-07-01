<?php
session_start();
require 'connection.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$designer = query("SELECT * FROM designer");

// search button is clicked
if (isset($_POST["search"])) {
    $main = search($_POST["keyword"]);
}

if (isset($_POST["adddesigner"])) {
    if (adddesigner($_POST) > 0) {
        echo "<script>
                alert('New Designer has been added successfully.');
                window.location.href = 'designerlist.php';
            </script>";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["update"])) {
    $designerID = $_POST["designerID"];
    $username = $_POST["username"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $status = $_POST["status"];

    if (updatedesigner($designerID, $username, $name, $email, $phone, $status)) {
        echo "<script>
                alert('Designer information has been updated successfully.');
                window.location.href = 'designerlist.php';
            </script>";
        exit;
    } else {
        echo mysqli_error($conn);
    }
}

?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
</head>
<style>
    /* Grid Layout */
    .designer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        grid-gap: 20px;
    }

    .designer-card {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    .designer-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .designer-name {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .designer-username,.designer-phone,.designer-email
    {
        color: #777;
        margin-bottom: 10px;
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

<?php
include 'sidenavadmin.php';
?>

<div class="content">
    <div class="main">
        <div class="welcome"><br>
            <hr style="border-top: 1px solid #00008B; margin: 0;"><br>
            <h1 style="text-align:center;">Welcome back! <?php echo $_SESSION["username"]; ?></h1><br>
            <hr style="border-top: 1px solid #00008B; margin: 0;">
            <br><br>
        </div>
        <h1 style="text-align:center;background-color:#00008B;">DESIGNER LIST</h1>
        <br>
        
        <div class="sort">
            <label for="sort">Sort by:</label>
            <select name="sort" id="sort" onchange="sortDesigner(this.value)">
                <option value="">-- Select --</option>
                <option value="name_asc">Name (Ascending)</option>
                <option value="name_desc">Name (Descending)</option>
                <option value="username_asc">Username (Ascending)</option>
                <option value="username_desc">Username (Descending)</option>
                <option value="phone_asc">Phone (Ascending)</option>
                <option value="phone_desc">Phone (Descending)</option>
                <option value="email_asc">Email (Ascending)</option>
                <option value="email_desc">Email (Descending)</option>
            </select>
        </div>

            <button id="myBtn" class="addbutton" onclick="document.getElementById('myModal').style.display='block'"><i class="fa fa-plus" aria-hidden="true"></i> Add Designer</button>
            <br>
            <div class="search">
                <input type="text" id="myInput" onkeyup="myFunction2()" placeholder="Search Designer" title="Type in a designer name">
            </div>

            <!-- pop up add -->
            <div id="myModal" class="modal">
                <!-- Content add -->
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                        <h2>Add Designer</h2>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" action="">
                            <br>
                            <div class="row">
                                <div class="colTitle"><label>Username: </label></div>
                                <div class="colInput"><input type="text" name="username" id="username"
                                        placeholder="username" required></div>
                            </div>
                            <div class="row">
                                <div class="colTitle"><label>Password: </label></div>
                                <div class="colInput"><input type="password" name="password" placeholder="password"
                                        id="password" required></div>
                            </div>
                            <div class="row">
                                <div class="colTitle"><label>Confirm Password: </label></div>
                                <div class="colInput"><input type="password" name="password2"
                                        placeholder="Confirm Password" id="password2" required></div>
                            </div>
                            <div class="row">
                                <input class="btnAdd" type="submit" value="Add New Designer" name="adddesigner">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<br>
        <div class="designer-grid">
                <?php foreach ($designer as $row) : ?>
                    <div class="designer-card">
                        <img src="img/user.jpg" alt="Designer Profile" class="designer-image">
                        <div class="designer-name"><?php echo $row['name']; ?></div>
                        <div class="designer-username"><?php echo $row['username']; ?></div>
                        <div class="designer-email"><?php echo $row['email']; ?></div>
                        <div class="designer-phone"><?php echo $row['phone']; ?></div>
                        <a href="#" class="fa fa-edit" style="color: green"
                        onclick="openEditModal('<?php echo $row['designerID']; ?>', '<?php echo $row['username']; ?>','<?php echo $row['name']; ?>','<?php echo $row['phone']; ?>','<?php echo $row['email']; ?>','<?php echo $row['status']; ?>')"></a>
                        <a href="delete.php?id=<?php echo $row['designerID']; ?>"
                        class="fa fa-trash" style="color: red"
                        onclick="return confirm('Are you sure you want to delete this Designer?');"></a>
                    </div>
                <?php endforeach; ?>
            </div>
        
            <!-- pop up edit -->
            <div id="editModal" class="modal">
                <!-- Content edit -->
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                        <h2>Edit Designer</h2>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" action="">
                            <br>
                            <input type="hidden" name="designerID" id="editDesignerID">
                            <div class="row">
                                <div class="colTitle"><label>Username: </label></div>
                                <div class="colInput"><input type="text" name="username" id="editUsername"
                                        placeholder="username" required></div>
                            </div>
                            <div class="row">
                                <div class="colTitle"><label>Name: </label></div>
                                <div class="colInput"><input type="text" name="name" id="editName"
                                        placeholder="name" required></div>
                            </div>
                            <div class="row">
                                <div class="colTitle"><label>Phone </label></div>
                                <div class="colInput"><input type="tel" name="phone" id="editPhone"
                                        placeholder="phone number" required></div>
                            </div>
                            <div class="row">
                                <div class="colTitle"><label>Email: </label></div>
                                <div class="colInput"><input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" id="editEmail"
                                        placeholder="email" required></div>
                            </div>
                            <input type="hidden" name="status" id="editStatus">
                            <div class="row">
                                <input class="btnAdd" type="submit" value="Update Designer" name="update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <br>
    </div>
</div>

<script src="js/script.js"></script>
    <script>
        // Function to sort recipes based on the selected option
           function sortDesigner(sortValue) {
    let designerGrid = document.querySelector('.designer-grid');
    let designerCards = Array.from(designerGrid.querySelectorAll('.designer-card'));

    designerCards.sort((cardA, cardB) => {
        let valueA, valueB;

        switch (sortValue) {
            case 'name_asc':
                valueA = cardA.querySelector('.designer-name').textContent;
                valueB = cardB.querySelector('.designer-name').textContent;
                return valueA.localeCompare(valueB);
            case 'name_desc':
                valueA = cardA.querySelector('.designer-name').textContent;
                valueB = cardB.querySelector('.designer-name').textContent;
                return valueB.localeCompare(valueA);
            case 'username_asc':
                valueA = cardA.querySelector('.designer-username').textContent;
                valueB = cardB.querySelector('.designer-username').textContent;
                return valueA.localeCompare(valueB);
            case 'username_desc':
                valueA = cardA.querySelector('.designer-username').textContent;
                valueB = cardB.querySelector('.designer-username').textContent;
                return valueB.localeCompare(valueA);
            case 'phone_asc':
                valueA = cardA.querySelector('.designer-phone').textContent;
                valueB = cardB.querySelector('.designer-phone').textContent;
                return valueA.localeCompare(valueB);
            case 'phone_desc':
                valueA = cardA.querySelector('.designer-phone').textContent;
                valueB = cardB.querySelector('.designer-phone').textContent;
                return valueB.localeCompare(valueA);
            case 'email_asc':
                valueA = cardA.querySelector('.designer-email').textContent;
                valueB = cardB.querySelector('.designer-email').textContent;
                return valueA.localeCompare(valueB);
            case 'email_desc':
                valueA = cardA.querySelector('.designer-email').textContent;
                valueB = cardB.querySelector('.designer-email').textContent;
                return valueB.localeCompare(valueA);
            default:
                return 0;
        }
    });

    designerCards.forEach((card) => {
        designerGrid.appendChild(card);
    });
}

        function myFunction2() {
    let input = document.getElementById('myInput');
    let filter = input.value.toLowerCase();
    let designerCards = document.getElementsByClassName('designer-card');

    for (let i = 0; i < designerCards.length; i++) {
        let card = designerCards[i];
        let designerName = card.querySelector('.designer-name');

        if (designerName.textContent.toLowerCase().indexOf(filter) > -1) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
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

    // Get the modal
    var modal = document.getElementById("myModal");
    var editModal = document.getElementById("editModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        } else if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }

    // Open the edit modal and populate the fields with existing data
    function openEditModal(designerID, username, name, phone, email, status) {
        var editDesignerIDField = document.getElementById("editDesignerID");
        var editUsernameField = document.getElementById("editUsername");
        var editNameField = document.getElementById("editName");
        var editPhoneField = document.getElementById("editPhone");
        var editEmailField = document.getElementById("editEmail");
        var editStatusField = document.getElementById("editStatus");

        editDesignerIDField.value = designerID;
        editUsernameField.value = username;
        editNameField.value = name;
        editPhoneField.value = phone;
        editEmailField.value = email;
        editStatusField.value = status;

        editModal.style.display = "block";
    }
</script>
