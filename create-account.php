<?php
    // start session
    session_start();
    require("handle-account.php");
    // require("assets/config/dbconnection.php");
    // require("assets/models/functions.php");

    $accInfo = new Account($pdo);

    $firstname_error_msg= '';
    $lastname_error_msg= '';
    $email_error_msg = '';
    $password_error_msg = '';
    $passwordconfirm_error_msg = '';

    $accountsuccess_msg = '';

    if(isset($_POST['create-button']))
    {
        try {
            // check if fields are empty
            if (empty($_POST['first-name'])) {
                $firstname_error_msg = 'First Name field required!';
            }
            if (empty($_POST['last-name'])) {
                $lastname_error_msg = 'Last Name field required!';
            }
            if (empty($_POST['email'])) {
                $email_error_msg = 'Email field required!';
            }
            else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $email_error_msg = 'Invalid email address!';
            }
            else if ($accInfo->doesEmailExist($_POST['email'])) {
                $email_error_msg = 'Email is already in use!';
            }
            if (empty($_POST['password'])) {
                $password_error_msg = 'Password field required!';
            }
            else if (!empty($_POST['password']) && $accInfo->passwordValidation($_POST['password']) == false) {
                $password_error_msg = "Passwords must be at least 8 characters long, contain both uppercase and lowercase characters, and contain at least 1 special character e.g. !@#$%^&*()+=._-";
            }
            if (empty($_POST['password-confirm'])) {
                $passwordconfirm_error_msg = 'Confirm Password field required!';
            }
            else if ($_POST['password'] != $_POST['password-confirm'])
            {
                $passwordconfirm_error_msg = 'Password and Confirm Password fields must match';
            }
            // if error messages are blank, in other words, if there are no errors on the create-account page
            if (empty($firstname_error_msg) &&
                empty($lastname_error_msg) &&
                empty($email_error_msg ) &&
                empty($password_error_msg) &&
                empty($passwordconfirm_error_msg)
                )
            {
				
                if (!empty($_POST['shipping-address']) && !empty($_POST['shipping-city']) && !empty($_POST['shipping-state']) && !empty($_POST['shipping-zipcode']))
                {
                    $accInfo->Register(trim($_POST['first-name']), trim($_POST['last-name']), trim($_POST['email']), trim($_POST['password']), trim($_POST['billing-address']), trim($_POST['billing-city']), trim($_POST['billing-state']), trim($_POST['billing-zipcode']), trim($_POST['shipping-address']), trim($_POST['shipping-city']), trim($_POST['shipping-state']), trim($_POST['shipping-zipcode']));
				
                    echo '<script type="text/javascript">alert("Account successfully created!");</script>';

                    echo '<script>window.location.replace("index.php?page=sign-in")</script>';

                    // $_SESSION['message'] = array("text"=>"Accounted successfully created!","alert"=>"info");

                    // header("location: index.php?page=sign-in");
                }
                else if(empty($_POST['shipping-address']) || empty($_POST['shipping-city']) || empty($_POST['shipping-state']) || empty($_POST['shipping-zipcode']))
                {
                    $accInfo->Register(trim($_POST['first-name']), trim($_POST['last-name']), trim($_POST['email']), trim($_POST['password']), trim($_POST['billing-address']), trim($_POST['billing-city']), trim($_POST['billing-state']), trim($_POST['billing-zipcode']), trim($_POST['billing-address']), trim($_POST['billing-city']), trim($_POST['billing-state']), trim($_POST['billing-zipcode']));

                    echo '<script type="text/javascript">alert("Account successfully created!");</script>';

                    echo '<script>window.location.replace("index.php?page=sign-in")</script>';
                }
                else
                {
                    echo '<script type="text/javascript">alert("Error creating account. Please try again.");</script>';
                }
            }
        } catch (PDOException $e) {
            // $error = "Error : " . $e->getMessage();
            $error = "Error creating account. Please try again.";
            echo '<script type="text/javascript">alert("'.$error.'");</script>';
        }
    }
?>

<?=template_header('Create Account');?>

  <script src="assets/js/create-account.js"></script>

  <div class="container col-4 w-50 mx-auto mt-5">
    <form method="POST" class="text-center" id="form">    
    <h2 class="text-center" id="header">Create an Account</h2>
        <div class="row g-2 mb-2">
            <div class="form-floating col-6">
                <input type="text" class="form-control" id="first-name" required="required" placeholder="Enter first name" name="first-name" value="<?php if(isset($_POST['first-name'])) { echo htmlentities ($_POST['first-name']); }?>">
                <label for="first-name" id="first-name-label">First Name</label>
            </div>

            <div class="form-floating col-6">
                <input type="text" class="form-control" id="last-name" required="required" placeholder="Enter last name" name="last-name" value="<?php if(isset($_POST['last-name'])) { echo htmlentities ($_POST['last-name']); }?>">
                <label for="last-name" id="last-name-label">Last Name</label>
            </div>
        </div> 
		<?php 
			if ($firstname_error_msg != "")
			{
				echo '<div class="text-danger mb3">' . $firstname_error_msg . '</div>';
			}
        ?> 
      	<?php 
			if ($lastname_error_msg != "")
			{
				echo '<div class="text-danger mb3">' . $lastname_error_msg . '</div>';
			}
      	?>
      <div class="form-floating mb-2 mx-auto">
        <input type="text" class="form-control" id="email" required="required" placeholder="Enter email" name="email" value="<?php if(isset($_POST['email'])) { echo htmlentities ($_POST['email']); }?>">
        <label for="pwd" id="email-label">Email</label>
      </div>
      <?php 
          if ($email_error_msg != "")
          {
              echo '<div class="text-danger mb3">' . $email_error_msg . '</div>';
          }
      ?>
      <div class="form-floating mb-2 mx-auto">
        <input type="password" class="form-control" id="password" required="required" placeholder="Enter password" name="password">
        <label for="pwd" id="password-label">Password</label>
      </div>
      <div class="form-floating mb-2 mx-auto">
        <input type="password" class="form-control" id="password-confirm" required="required" placeholder="Confirm password" name="password-confirm">
        <label for="pwd" id="password-confirm-label">Confirm Password</label>
      </div>
      <?php 
          if ($password_error_msg != "")
          {
              echo '<div class="text-danger mb3">' . $password_error_msg . '</div>';
          }
      ?>
      <?php 
          if ($passwordconfirm_error_msg != "")
          {
              echo '<div class="text-danger mb3">' . $passwordconfirm_error_msg . '</div>';
          }
      ?>
    
    <h2 class="text-center" id="header-2">Billing Address</h2>
        <!-- Address -->
        <div class="form-floating mb-2 mx-auto">
            <input type="text" class="form-control" id="billing-address" name="billing-address" required="required" placeholder="Street address or P.O. Box" value="<?php if(isset($_POST['billing-address'])) { echo htmlentities ($_POST['billing-address']); }?>">
            <label class="form-label" for="address">Address</label>
        </div>
        <!-- City, State, Zip Code -->
        <div class="row g-2 mb-2">
            <!-- City -->
            <div class="form-floating col-5 mx-auto">
                <input type="text" class="form-control" id="billing-city" name="billing-city" required="required" placeholder="City" value="<?php if(isset($_POST['billing-city'])) { echo htmlentities ($_POST['billing-city']); }?>">
                <label class="form-label" for="billing-city">City</label>
            </div>
            <!-- State -->
            <div class="form-floating col-4">
                <input type="text" class="form-control" id="billing-state" name="billing-state" required="required" placeholder="State" value="<?php if(isset($_POST['billing-state'])) { echo htmlentities ($_POST['billing-state']); }?>">
                <label for="state">State</label>
            </div>
            <!-- Zip Code -->
            <div class="form-floating col-3">
                <input type="text" class="form-control" id="billing-zipcode" name="billing-zipcode" required="required" placeholder="Zip Code" pattern="[0-9]{5}" title="5 numeric characters only" value="<?php if(isset($_POST['billing-zipcode'])) { echo htmlentities ($_POST['billing-zipcode']); }?>">
                <label class="form-label" for="billing-zipcode">Zip Code</label>
            </div>
        </div> <!-- row -->
        <div class="form-check form-switch mb-2">
            <label class="form-check-label">Same address as billing address <input onclick="hideShipping()" data-bs-toggle="collapse" data-bs-target="#shipping-address-form-div" class="form-check-input" type="checkbox" id="shipping-address-check" name="shipping-address-check"checked></label>
        </div>
    <div class="collapse" id="shipping-address-form-div">
        <hr>
        <h2 class="text-center" id="header-2">Shipping Address</h2>
            <!-- Address -->
            <div class="form-floating mb-2 mx-auto">
                <input type="text" class="form-control" id="shipping" name="shipping-address" placeholder="Street address or P.O. Box" value="<?php if(isset($_POST['shipping-address'])) { echo htmlentities ($_POST['shipping-address']); }?>">
                <label class="form-label" for="address">Address</label>
            </div>
            <!-- City, State, Zip Code -->
            <div class="row g-2 mb-2">
                <!-- City -->
                <div class="form-floating col-5 mx-auto">
                    <input type="text" class="form-control" id="shipping-city"  name="shipping-city" placeholder="City" value="<?php if(isset($_POST['shipping-city'])) { echo htmlentities ($_POST['shipping-city']); }?>">
                    <label class="form-label" for="shipping-city">City</label>
                </div>
                <!-- State -->
                <div class="form-floating col-4">
                    <input type="text" class="form-control" id="shipping-state" name="shipping-state" placeholder="State" value="<?php if(isset($_POST['shipping-state'])) { echo htmlentities ($_POST['shipping-state']); }?>">
                    <label for="state">State</label>
                </div>
                <!-- Zip Code -->
                <div class="form-floating col-3">
                    <input type="text" class="form-control" id="shipping-zipcode"  name="shipping-zipcode" placeholder="Zip Code" pattern="[0-9]{5}" title="5 numeric characters only" value="<?php if(isset($_POST['shipping-zipcode'])) { echo htmlentities ($_POST['shipping-zipcode']); }?>">
                    <label class="form-label" for="shipping-zipcode">Zip Code</label>
                </div>
            </div> <!-- row -->
    </div>
      <input type="submit" name="create-button" class="btn btn-danger w-75" name="create-button" value="Create"/>
      <?php 
          if ($blank_error_msg != "")
          {
              echo '<div class="text-danger mb3">' . $blank_error_msg . '</div>';
          }
      ?>
      <p class="pt-1">Already have an account? <a href="index.php?page=sign-in" id="sign-in-link">Sign In</a></p>
    </form>
  </div>
  
<?=template_footer()?>
