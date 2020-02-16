<?php
 session_start();
 date_default_timezone_set("Asia/Kolkata");
 require $_SERVER['DOCUMENT_ROOT'].'/db_connect.php';
 $_SESSION['message']='';
 $reg_flag=0;
if (isset($_POST['register']))
{
  $mysqli = OpenCon();
  $username = $mysqli->real_escape_string($_POST['username']);
  $password = $_POST['password'];
  $passwordc = $_POST['passwordc'];
  $hashpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
  if($password === $passwordc){

  $user_check = "SELECT id FROM users WHERE username = ?";

  if($stmt = $mysqli->prepare($user_check)){
    $stmt->bind_param("s", $param_username);
    $param_username = $username;
    if($stmt->execute())
    {
        $stmt->store_result();
        if($stmt->num_rows != 1)
        {
          $sql = "INSERT INTO users (username, password, points)
          VALUES('$username','$hashpassword',0)";

          if($mysqli->query($sql)===TRUE)
          {
            header("location: /login.php");
            exit();
          }
          else {
            $_SESSION['message']= 'Failed';
          }

        } else
        {
          $reg_flag=1;
        }
    } else{
          $reg_flag=2;
          }
  }

  $stmt->close();
}else{
      $reg_flag=3;
      }

CloseCon($mysqli);
}
?>

<!doctype html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <link rel="manifest" href="https://smashsdgs.me/manifest.json">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/style-lr.css">
    <title>Register | Pluto</title>
  </head>
  <body>
    <?php
    if($reg_flag==1){echo "<div class='alert alert-warning logauth alert-dismissible fade show'>Username already taken.<button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>&times;</span></button></div>";}
    if($reg_flag==2){echo "<div class='alert alert-warning logauth alert-dismissible fade show'>Oops! Something went wrong. Please try again later.<button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>&times;</span></button></div>";}
    if($reg_flag==3){echo "<div class='alert alert-warning logauth alert-dismissible fade show'>Password and confirmed password didn't match.<button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>&times;</span></button></div>";}
     ?>
  <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<span class="login100-form-title p-b-26">
						Register
					</span><br><br>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" id="username" name="username" placeholder="Username" required>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="password" id="password" name="password" placeholder="Password" required>
					</div>

          <div class="wrap-input100 validate-input">
						<input class="input100" type="password" id="passwordc" name="passwordc" placeholder="Confirm Password" required>
					</div>

					<button class="login100-form-btn" id="register" name="register" type="submit">Register</button>

					<div class="text-center newreg">
						<a href="/index.php">Login</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script defer src="https://smashsdgs.me/site.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
