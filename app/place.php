<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/db_connect.php';
date_default_timezone_set("Asia/Kolkata");
if($_SESSION["loggedin"] != true){
   header("location: /login.php");
   exit();
}
if (isset($_POST['new']))
{
    $mysqli = OpenCon();
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $city = $_POST['city'];
    $remarks = $mysqli->real_escape_string($_POST['remarks']);
    $sql = "INSERT INTO places (city, lat, lon, remarks, timedate)
    VALUES('$city','$lat','$lon','$remarks',now())";

    if($mysqli->query($sql)===TRUE)
    {
      header("location: /place.php?city={$city}&find=");
      exit();
    }
    else {
      $_SESSION['message']= 'Failed';
      header("location: /");
    }
    CloseCon($mysqli);
    exit();
  }

  if (isset($_POST['addreview']))
  {
      $mysqli = OpenCon();
      $pid = $_POST['pid'];
      $city = $_POST['city'];
      $review = $mysqli->real_escape_string($_POST['review']);
      $sql = "INSERT INTO reviews (place_id, review, timedate)
      VALUES('$pid','$review',now())";

      if($mysqli->query($sql)===TRUE)
      {
        header("location: /place.php?city={$city}&find=");
        exit();
      }
      else {
        $_SESSION['message']= 'Failed';
        header("location: /");
      }
      CloseCon($mysqli);
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
    <title>City | Pluto</title>
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
              <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                <button class="btn btn-dark cutebtn" id="find" name="find" type="submit">Find</button>
              </form>
              </div>
            </div>
          </div>
          <div class="row spotdiv thirdbox">
            <div class="col sub-page-title">
              <?php
              if (isset($_GET['find']))
              {
                 $mysqli = OpenCon();
                 $city = $mysqli->real_escape_string($_GET['city']);
                 echo "<h3 class='killihead'>Spots at ".$city."</h3><br>";
                  $sql = "SELECT id,city,lat,lon,remarks,timedate FROM places WHERE city='$city' ORDER BY id desc";
                  $result = mysqli_query($mysqli, $sql);
                  if($result->num_rows === 0)
                  {
                      echo '<br><h6>No results</h6>';
                  }
                  while ($row = mysqli_fetch_assoc($result)) {
                     echo "<div class='killisecondbox'><div><iframe height='300px' style='width: 100%; border-radius:15px; border: 1px solid #4C525B;' frameborder='0' src='https://www.openstreetmap.org/export/embed.html?bbox=".$row['lon']."%2C".$row['lat']."%2C".$row['lon']."%2C".$row['lat']."&marker=".$row['lat']."%2C".$row['lon']."&layers=ND'></iframe></div>";
                     echo "<b>".$row['remarks']."</b><br>".$row['timedate'];
                     $pid = $row['id'];
                     echo "<div style='padding-top:1em;'><button class='btn btn-dark cutebtn' type='button' data-toggle='collapse' data-target='#".$pid."' aria-expanded='false' aria-controls='collapseExample'>Show reviews</button></div>";
                     echo "<div class='collapse reviewslist' id='".$pid."'>";
                     $sql1 = "SELECT review,timedate FROM reviews WHERE place_id=$pid";
                     $result1 = mysqli_query($mysqli, $sql1);
                     if($result1->num_rows === 0)
                     {
                         echo "<div class='card card-body killicard'>No reviews</div>";
                     }
                     while ($row1 = mysqli_fetch_assoc($result1)) {
                        echo "<div class='card card-body killicard'><b>".$row1['review']."</b>".$row1['timedate']."</div>";
                      }
                      echo "<form method='post' action='/place.php'><div class='form-row pt-2'>
                            <div class='col-7'><input class='form-control custom-text' type='text' id='review' name='review' placeholder='Review' required></div>
                            <input type='hidden' id='pid' name='pid' value='".$pid."'>
                            <input type='hidden' id='city' name='city' value='".$city."'>
                            <div class='col-5'><button class='btn btn-dark cutebtn' id='addreview' name='addreview' type='submit'>Add Review</button></div></div></form></div></div><br>";
                  }
                 CloseCon($mysqli);
              }
              ?>
            </div>
          </div>
          <div class="row pt-4 secondbox">
            <div class="col sub-page-title">
              <div class="killitopbox">
              <h6>Add the spot you're at in <?php echo $city; ?> </h6>
              <form method="post" action="/place.php">
                <div class="form-row pt-2">
                  <div class="col"><input class="form-control custom-text" type="text" id="lat" name="lat" placeholder="Latitude" required></div>
                  <div class="col"><input class="form-control custom-text" type="text" id="lon" name="lon" placeholder="Longitude" required></div>
                </div>
                <div class="form-row pt-2">
                  <div class="col"><button class="btn btn-dark nicebtn" id="pos" name="pos" onclick="getLocation()">Check Position</button></div>
                  <script>
                  var lat = document.getElementById("lat");
                  var lon = document.getElementById("lon");
                  var geo_er = document.getElementById("geo_er");
                  function getLocation() {
                    if (navigator.geolocation) {
                      navigator.geolocation.getCurrentPosition(showPosition);
                    } else {
                      geo_er.innerHTML = "Geolocation is not supported by this browser.";
                    }
                  }

                  function showPosition(position) {
                    lat.value = position.coords.latitude;
                    lon.value = position.coords.longitude;
                  }
                  </script>
                </div>
                <div class="form-row pt-3">
                  <div class="col"><input class="form-control custom-text" type="text" id="remarks" name="remarks" placeholder="Remarks" required></div>
                </div>
                 <input type="hidden" id="city" name="city" value="<?php echo $city; ?>">
                 <div class="form-row pt-4">
                   <div class="col"><button class="btn btn-dark cutebtn" id="new" name="new" type="submit">Add spot</button></div>
                </div>
              </form>
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
