<?php include('connection.php'); ?>

<body>
<?php
  include 'header.php';
?>
    <div class="login-container">
  <div class="login-wrapper">
    <div class="login-box">
        <div class="heading-wrap">
        <form class="login-form" action="login.php" method="post" style="text-align: center;">
		<p>
			We sent an email to  <b><?php echo $_GET['email'] ?></b> to help you recover your account. 
		</p>
	    <p>Please login into your email account and click on the link we sent to reset your password</p>
	</form>
        </div>
      </div>
        </div>
    </div>
</body>
	

<?php
  include 'footer.php';
?>