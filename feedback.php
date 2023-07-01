<?php

require 'connection.php';

session_start();////////mula sini

if(!isset($_SESSION["login"])){   /////////////------------>>>>>>>>>jika belum login x bole msuk page ini(ble gune utk store page)
    header("Location: login.php");
    exit;
}/////////// copy smpi sini 1 blok

$feedback = query("SELECT * FROM contact");//////diisi dgn kotak tadi $rows[]

?>


<?php
  include 'sidenav.php';
?>

  <div class="main">
    <h1 style="text-align:center;background-color:steelblue;">Feedback/ Messages </h1>

<br>
    <table border="1" cellpadding="10" cellspacing="0" margin= "auto">
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
</body>
</html>