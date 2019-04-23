<?php session_start(); ?>

<!doctype html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <script>
    $("head").load("header.html");
 </script>
</head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <h3 class="text-muted">Food Cart</h3>
        </div>
        <div class="col-md-8 d-flex justify-content-end align-items-center">
          <form class="form-signin"  method="post" action="signup.php">
            <button class="btn btn-xs btn-warning btn-block" type="submit" style="width:108px; height: 36px; text-align: center" action="index.php">Sign Up</button>
        </form>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center" style="height: calc(100vh - 56px)">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto">
            <form class="form-signin"  method="post" action="<?php echo  $_SERVER['PHP_SELF'];?>">
              <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
              <label for="inputEmail" class="sr-only">Email address</label>
              <input type="email" name ="email" id="inputEmail" class="form-control  mb-3" placeholder="Email address" required autofocus>
              <label for="inputPassword" class="sr-only">Password</label>
              <input type="password" name ="password" id="inputPassword" class="form-control  mb-3" placeholder="Password" required>
              <div class="checkbox mb-3">
                <label>
                  <input type="checkbox" value="remember-me"> Remember me
                </label>
              </div>
              <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include("nav-bottom.html"); ?>
    <!-- php script -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($_POST["email"])
      {
        //form entered values
        $email = $_POST["email"];
        $password = $_POST["password"];
        //db connection
          $user = 'root';
          $pass = '';
          $db = 'trail';
          $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
          $sql = "SELECT * FROM user";
          $result = mysqli_query($db, $sql); //procedural mysqli
          // $db->query($sql); //mysqli
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              if($row["email"] == $email) {
                if($row["password"] == $password) {
                  $_SESSION['uid'] = $row["uid"];
                  header("Location: home.php");
                }
              }
            }
          } else {
            echo "0 results";
          }
          // $conn->close(); mysqli
          mysqli_close($db);
        }
      }
    ?>
  </body>
</html>
