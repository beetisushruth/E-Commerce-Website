<?php
// Start the session
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script defer src="fontsawesome/js/all.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <script>
    $("head").load("header.html");
 </script>
</head>
<header style="height:54px"><?php include("nav-top.html"); ?></header>
<body>
  <main role="main">
    <section class="jumbotron text-center mb-0" style="background: #dbe6f6; background: -webkit-linear-gradient(to right, #dbe6f6, #c5796d);">
      <div class="container">
        <h1 class="jumbotron-heading">food you love. <i class="fas fa-heart text-danger" style="width: 24px; height: 34px"></i></h1>
        <p class="lead text-muted">Order Tasty Meal Delivered Right On To Your Doorstep.</p>
        <p>
          <a href="#" class="btn btn-primary my-2">Food Blog Reviews  <i class="fas fa-book-reader"></i></a>
          <a href="#" class="btn btn-secondary my-2">Discounts</a>
        </p>
      </div>
    </section>
    <div class="album py-5 bg-light" >
      <div class="container">
        <div class="row">
          <?php
          function myfunction($rid) {
            echo '
           <script>alert("warning")</script>
       ';
          }
          function star($count) {
            $num = 5 - $count;
            $star = '';
            while($count > 0)
            {
              $star .= '<i class="fas fa-star text-warning"></i>';
              $count--;
            }
            while($num > 0) {
              $star .= '<i class="fas fa-star" style="color: lightgrey"></i>';
              $num--;
            }
            return $star;
          }
          $user = 'root';
          $pass = '';
          $db = 'trail';
          $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
          $sql = "SELECT * FROM restaurant";
          $result = mysqli_query($db, $sql); //procedural mysqli
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              echo '<div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                  <div class="container" style="height: 150px; background: #dbe6f6;
     background: -webkit-linear-gradient(to right, #dbe6f6, #c5796d);
   ">
                  </div>
                  <div class="card-body">
                    <h5>'.($row["rname"]).'<h5>
                    <p class="card-text" style="margin-bottom: 4px; font-size: 16px; font-weight: normal; ">'.($row["location"]).'</p>
                    <p class="text-muted" style="margin-bottom: 16px; font-size: 12px; font-weight: normal; color: #6c757d!important">Continental, Asian, Italian, North Indian</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary">'.(($row["aval"] == 0) ? 'Available': 'Not Available').'</button>
                        <a href="menu.php?rid='.$row["rid"].'">
                        <button type="button" class="btn btn-sm btn-outline-success">Order</button>
                        </a>
                      </div>
                      <small class="text-muted">'.(star($row["rating"])).'</small>
                    </div>
                  </div>
                </div>
              </div>';
            }
          }
         ?>
        </div>
      </div>
    </div>

  </main>
</body>
</html>
