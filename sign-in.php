<?php
	require("handle-account.php");
	session_start();

	$accInfo = new Account($pdo);

    $email_error_msg = '';
    $password_error_msg = '';

	if (isset($_POST['signin-button']))
	{
		try {
			// check email field
			if (empty($_POST['email'])) {
                $email_error_msg = 'Email field required!';
            }
            else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $email_error_msg = 'Invalid email address!';
            }

			// check password field
            if (empty($_POST['password'])) {
                $password_error_msg = 'Password field required!';
            }
            else if (!empty($_POST['password']) && $accInfo->passwordValidation($_POST['password']) == false) {
                $password_error_msg = "Passwords must be at least 8 characters long, contain both uppercase and lowercase characters, and contain at least 1 special character e.g. !@#$%^&*()+=._-";
            }

            // if error messages are blank, in other words, if there are no errors on the sign-in page
            if (empty($email_error_msg ) && empty($password_error_msg))
			{
				
				$accInfoQuery = $accInfo->Login($_POST['email'], $_POST['password']);

				if (!empty($accInfoQuery))
				{
					// provide user with a login session
					$_SESSION['user_ID'] = $accInfoQuery['user_ID'];
          $_SESSION['admin_flag'] = $accInfoQuery['admin_flag'];
					$_SESSION['signedin'] = true;

					echo '<script type="text/javascript">alert("Successfully signed in!");</script>';
					
					// header ("Location: index.php?page=home");

					echo '<script>window.location.replace("index.php?page=home")</script>';
				}
				else
				{
					echo '<script type="text/javascript">alert("Error signing in. Please try again.");</script>';
				}
			}			
		} catch (PDOException $e) {
            $error = "Error : " . $e->getMessage();
            // $error = "Error signing in. Please try again.";
            echo '<script type="text/javascript">alert("'.$error.'");</script>';
		}
	}


?>

<?=template_header('Sign In');?>

<script src="assets/js/sign-in.js"></script>

  <div class="container w-50 mx-auto mt-5">
    <h2 class="text-center">Sign In</h2>
    <form method="POST" class="text-center">
      <div class="form-floating mb-3 w-75 mx-auto">
        <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required="required">
        <label for="email">Email</label>
      </div>
      <div class="form-floating w-75 mx-auto">
        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required="required">
        <label for="pwd">Password</label>
      </div>
      <div id="password-message">
      </div>
      <p class="text-left pt-1"><a href="index.php?page=reset-password">Forgot your password?</a></p>
      <!-- <button type="submit" onclick="signInValidation()" class="btn btn-danger w-75">Sign In</button> -->
	  <input type="submit" name="signin-button" class="btn btn-danger w-75" name="signin-button" value="Sign In"></input>
      <p class="text-left pt-1">Don't have an account? <a href="index.php?page=create-account">Create an account</a></p>
	  <?php 
          if ($email_error_msg != "")
          {
              echo '<div class="text-danger mb3">' . $email_error_msg . '</div>';
          }
      ?>
	  <?php 
          if ($password_error_msg != "")
          {
              echo '<div class="text-danger mb3">' . $password_error_msg . '</div>';
          }
      ?>
    </form>
  </div>
  
<?=template_footer()?>
