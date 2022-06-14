<?php

?>

<?=template_header('Reset Password');?>

    <script src="assets/js/reset-password.js"></script>

    <h2 class="text-center mt-5" id="header">Reset Your Password</h2>
    <p class="text-center" id="description">Please enter your email address.</p>
    <div class="container w-50">
        <form class="text-center w-75 mx-auto">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
                <label id = "label" for="email">Email</label>
            </div>
            <div class="mb-3" id="messageCollapse">
                <div id="message">
                </div>
              </div>
            <button onclick="resetPasswordValidation()" type="button" class=" btn btn-danger w-100" id = "reset-button">Reset</button>
            <p class="pt-1 text-center" ><a href="index.php?page=sign-in" id="cancel-link">Cancel</a></p>
        </form>
    </div>
    
<?=template_footer()?>
