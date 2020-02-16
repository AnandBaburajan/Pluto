<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/db_connect.php';
date_default_timezone_set("Asia/Kolkata");
if($_SESSION["loggedin"] != true){
   header("location: /login.php");
   exit();
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
    <link rel="stylesheet" href="/style.css">
    <title>Pluto</title>
  </head>
  <body>

    <nav class="navbar navbar-dark navbar-expand-lg customnav">
    <div class="container">
      <a class="navbar-brand" href="/">
        Pluto
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <div class="navbar-nav ml-auto phone_menu">
          <a class="nav-item nav-link" href="/logout.php"><b>Logout</b></a>
        </div>
      </div>
    </div>
  </nav>

    <div class="container maincontent">
      <div class="row">
        <div class="col-3 sidenav pr-5">
          <a href="/" class="text-decoration-none navbutton"><div>Home</div></a>
          <a href="/logout.php" class="text-decoration-none navlink">Logout</a>
        </div>
        <div class="col customcontent">
          <div class="row">
            <div class="col sub-page-title topbox">
                <h6> Welcome, <?php echo $_SESSION["username"]; ?> </h6>
            </div>
          </div>
          <div class="row pt-4 secondbox">
            <div class="col">
              <div class="killitopbox">
              <h3>Find spots</h3><br>
              <form method="get" action="/place.php">
                <div class="form-group">
                  <select class="custom-select form-control" id="city" name="city">
                    <option value="" disabled selected hidden>Select city</option>
                    <?php
                      $loc = array("Thiruvananthapuram","Kochi","Kozhikode","Kollam","Thrissur","Kannur","Alappuzha","Palakkad","Malappuram","Manjeri","Kodungallur","Thalassery","Thrippunithura","Ponnani","Thrikkakkara","Vatakara","Kanhangad","Taliparamba","Koyilandy","Neyyattinkara","Kalamassery","Kayamkulam","Beypore");
                      for($i=0;$i<count($loc);$i++)
                      {
                        echo "<option>".$loc[$i]."</option>";
                      }
                     ?>
                  </select>
                </div>
                <button class="btn btn-dark cutebtn" name="find" type="submit">Find</button>
              </form>
            </div>
            </div>
          </div>
          <div class="row pt-4 thirdbox">
            <div class="col">
              <div class="killisecondbox">
              <h3>What is Pluto?</h3><br>
              <p>Pluto lets you find spots in cities to share privacy with your loved one and share spots you come across.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script defer src="https://smashsdgs.me/site.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
