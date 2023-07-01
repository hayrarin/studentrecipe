<?php $currentPage ='contact'; ?>

<title>Student Recipe | Contact Us</title>

<?php
  include 'header.php';
?>
    <!--Start breadcrumb-->
    <ul class="breadcrumb">
    </ul>
    <!--End breadcrumb-->

    <!--Start contact form-->
    <section id="heading">
          <div class="heading-wrap">
            <h2>Do have Suggestion? Free to tell Us !</h2>
          </div>
    </section>

    <section id="form-box" class="">
    <div class="wrapper">
      <div class="form-box form-box-grid">
        <div class="form-info">
            <h3>Contact information</h3>
            <ul>
              <li><i class="fas fa-map-marker-alt"></i>Student Recipe, Malaysia</li>
              <li><i class="fas fa-mobile-alt"></i>(+60)1127634253</li>
              <li><i class="fas fa-envelope"></i>recipeebook@gmail.com</li>
            </ul>
        </div>
        <div class="form-input">
            <h3 style="text-align: center;">Send us a message</h3>
            <form action="contact_sent.php" method="POST">
                <p class="full">
                    <label for="name">Your Name</label>
                    <input type="text" name="name" id="name" placeholder="Ahmad bin Abu" required>
                  </p>
                  <p class="half">
                    <label for="email">Your Email Address</label>
                    <input type="email" name="email" id="email" placeholder="ahmad1234@mail.com" required>
                  </p>
                  <p class="half">
                    <label for="phone">Your Phone No</label>
                    <input type="tel" name="phone" id="phone" placeholder="0132578904" pattern="[0-9]{10}" required>
                  </p>
                  <p class="full">
                    <label for="message">Your Message</label>
                    <textarea name="message" id="message" placeholder="Enter your message here..." required></textarea>
                  </p>
                  <p class="full">
                    <button type="submit" onclick="error()">Send Message!</button>
                  </p>
            </form>
            <script>
            function error(){////////////////////VALIDATION

              var name = document.getElementById("name").value;
              var email = document.getElementById("email").value;
              var phone = document.getElementById("phone").value;
              var message = document.getElementById("message").value;

              ///condition
              var letters = /^[A-Za-z]+$/;
	          	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

              if (name==''){
                  alert('Please enter your name');
              }

              else if(!letters.test(name)){
                  alert('Name in alphabet only');
              }
              else if(email==''){
                  alert('Please enter your email');
              }
              else if(!filter.test(email)){
                  alert('Valid email only');
              }
              else if (phone == ''){
                alert('Please enter phone number')
              }

              else if(message == ''){
                alert('Please enter the message');
              }
              else if(letters.test(phone)){
                alert('Please enter valid phone number');
                document.location.href='contactus.php';   
              }
            }
            </script>
        </div>
    </div>
    </div>
</section>
<?php
  include 'footer.php';
?>
