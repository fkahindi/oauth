<?php
header("Referrer-Policy: no-referrer-when-downgrade");//localhost testing
header("Access-Control-Allow-Origin: same-origin-allow-popups");
header("Access-Control-Allow-Headers: HASH, Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Security-Policy-Report-Only: frame-ancestors 'self' https://web.facebook.com; ");
header("Set-Cookie: cross-site-cookie=whatever; SameSite=None; Secure");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Francis Kahindi" />
    <meta http-equiv="Content-Security-Policy" content="default-src 'none';form-action 'self'; style-src 'self' 'unsafe-inline' https://accounts.google.com/gsi/ https://connect.facebook.net/ https://cdnjs.cloudflare.com/; img-src 'self'; font-src 'self'; script-src 'self' 'unsafe-eval' 'unsafe-inline' https://accounts.google.com/gsi/client https://connect.facebook.net https://cdnjs.cloudflare.com/; frame-src https://accounts.google.com/gsi/ https://web.facebook.com/  https://www.facebook.com;  connect-src 'self' https://accounts.google.com/gsi/ https://web.facebook.com https://www.facebook.com;" />

    <link rel="canonical" href="">
    <title>Login</title>
    <meta name="description" content="Use email and password to login to developerspot system.">
    <meta name="keywords" content="login, email address, password, developerspot">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>
  <body>
    <div id="sign-option">
       <div class="banner-bar">
        <h2>Login</h2>
      </div>

      <div class="sign-options-btns">
        
        <button class="current-button">  Sign in</button>
      </div>
      <div>
        <h4 class="successMsg"><?php echo (!empty($_SESSION['success_msg']) ? $_SESSION['success_msg'] : ''); ?></h4>
        <h4 class="errorMsg"><?php echo (isset($form_error) ? $form_error : ''); ?></h4>
      </div>
        <!-- Facebook sdk -->
        <!-- Load the JS SDK asynchronously -->
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

       <!-- Google client -->
        <script src="https://accounts.google.com/gsi/client" async defer></script>

        <!-- Facebook login button-->
        <div class="oauth-login-btn">
          <button class="fb btn" id="loginbutton""><i class="fa fa-facebook"></i> Login with Facebook </button>

        </div>
        <!-- Google login button -->
        <div class="oauth-login-btn">
          <div id="g_id_onload"
              data-client_id="1007627739117-mmn92vm3mqjimnbap1pmm2r32fq50fe4.apps.googleusercontent.com"
              data-context="signin"
              data-ux_mode="popup"
              data-callback="handleCredentialResponse"
              data-nonce=""
              data-auto_prompt="false">
          </div>

          <div class="g_id_signin"
              data-type="standard"
              data-shape="rectangular"
              data-theme="outline"
              data-text="signin_with"
              data-size="large"
              data-logo_alignment="left">
          </div>
        </div>
        <form method="POST" action="">
          <fieldset>
            <legend>Or Use Email</legend>

            <div class="group-form">
              <label for="email">Email address:</label>
              <input type="email" name="email" value="<?php echo (!empty($email) ? $email : ''); ?>" placeholder="Enter email address..." autocomplete="off">
              <span class="errorMsg"><?php echo (!empty($errors['email']) ? $errors['email'] : ''); ?></span>
            </div>
            <div class="group-form">
              <label for="password">Password: <span class="right-align"> </span></label>
              <input type="password" name="password" placeholder="Enter password..." autocomplete="off" id="password_1" data-id="1">
              <i class="fa fa-eye" id="toggle_view1" data-id="1"></i>
              <span class="errorMsg"><?php echo (!empty($errors['password']) ? $errors['password'] : ''); ?></span>
            </div>
            <input type="submit" name="login" class="button" value="Sign in">

          </fieldset>
        </form>
        
        

<script src="js/facebook.js"></script>
      
<script src="js/google.js"></script>

</body>
</html>