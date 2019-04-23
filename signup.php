<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
          <form class="form-signin"  method="get" action="login.php">
            <button class="btn btn-xs btn-success btn-block" type="submit" style="width:108px; height: 36px; text-align: center" action="login.php">Sign In</button>
        </form>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center" style="height: calc(100vh - 56px)">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto">
            <form class="form-signin"  method="post" action="signup.php">
              <h1 class="h3 mb-3 font-weight-normal">Sign Up</h1>
              <label for="name" class="sr-only">Name</label>
              <input type="name" name ="name" id="name" class="form-control mb-3" placeholder="Name" required autofocus>
              <label for="inputEmail" class="sr-only">Email address</label>
              <input type="email" name ="email" id="inputEmail" class="form-control  mb-3" placeholder="Email address" required autofocus>
              <label for="inputPassword" class="sr-only">Password</label>
              <input type="password" name ="password" id="inputPassword" class="form-control  mb-3" placeholder="Password" required>
              <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign Up</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include("nav-bottom.html"); ?>

    <!-- php script -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST["email"]))
    {
      //form values
      $name = $_POST["name"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      //to connect to db
        $user = 'root';
        $pass = '';
        $db = 'trail';
        $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
        //insert into db
         $last_id = $db->insert_id;
         echo $last_id;
        $sql = "INSERT INTO `user` (`uid`, `uname`, `email`, `password`) VALUES ('$last_id', '$name', '$email', '$password')";
        $db->query($sql);
        $db->close();
        header("Location: login.php");
    }
  }
    ?>
  </body>
</html>
