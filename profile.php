<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Profile Page</title>
</head>
<body>
<div>
<?php echo(isset($_SESSION['loggedin'])? '<a href="logout.php">Logout</a>' : '<a href="login.php">Login</a>')?>
</div>
<h2>Welcome <?php echo ($_SESSION['username'])?? '' ?> from <?php echo $_SESSION['oauth_provider']?? '' ?></h2>
<p>User ID: <?php echo $_SESSION['user_id']?? '' ?></p>
<p>User name: <?php echo $_SESSION['fullname']?? '' ?></p>
<p>Email: <?php echo $_SESSION['email']?? '' ?></p>
<p><img src="<?php echo $_SESSION['picture']?? '' ?>" width="100px" alt="user profile"/></p>

</body>
</html>
