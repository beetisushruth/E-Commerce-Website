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
    function toggle(num, uid, rid, mid) {
      if(document.getElementById(num).innerHTML == "Add To Cart" && document.getElementById("badge"+num).innerHTML > 0)
      {
          $.ajax({
            type: "POST",
            url: "menu.php",
            data: { 'num': document.getElementById("badge"+num).innerHTML, 'uid': uid, 'rid': rid, 'mid': mid, 'operation': 'add'},
          }).done(function( msg ) {
            console.log("Data Saved");
            document.getElementById(num).className = "btn btn-danger btn-sm";
            document.getElementById(num).innerHTML = "Cancel";
          });
      }
      else
      {
        $.ajax({
          type: "POST",
          url: "menu.php",
          data: { 'num':  document.getElementById("badge"+num).innerHTML, 'uid': uid, 'rid': rid, 'mid': mid, 'operation': 'delete'},
        }).done(function( msg ) {
          console.log("Data Saved");
          document.getElementById(num).className = "btn btn-primary btn-sm";
          document.getElementById(num).innerHTML = "Add To Cart";
        });
      }
    }
    function add(num) {
      document.getElementById("badge"+num).innerHTML++;
      document.getElementById(num).className = "btn btn-primary btn-sm";
      document.getElementById(num).innerHTML = "Add To Cart";
    }
    function minus(num) {
      if(document.getElementById("badge"+num).innerHTML > 0)
      document.getElementById("badge"+num).innerHTML--;
      document.getElementById(num).innerHTML = "Add To Cart";
      document.getElementById(num).className = "btn btn-primary btn-sm";
    }
 </script>
</head>
<header style="height:54px"><?php include("nav-top.html"); ?></header>
<body>
  <main role="main" class="container">

    <?php
    if (isset($_POST['num'])) {
      //form values
      $num = $_POST["num"];
      $uid = $_POST["uid"];
      $rid = $_POST["rid"];
      $mid = $_POST["mid"];
      $oper = $_POST["operation"];
      //to connect to db
        $user = 'root';
        $pass = '';
        $db = 'trail';
        $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
        if($oper == 'delete') {
          echo $uid, $rid, $mid;
          $sql = "DELETE FROM cart WHERE uid=$uid AND rid=$rid AND mid=$mid";
          $result = mysqli_query($db, $sql); //procedural mysql
        }
        else {
          $sql = "SELECT * FROM cart WHERE uid=$uid AND rid=$rid AND mid=$mid";
          $result = mysqli_query($db, $sql); //procedural mysql
          if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE cart SET num = '$num' WHERE uid = $uid AND rid = $rid AND mid = $mid";
            $result = mysqli_query($db, $sql); //procedural mysql
          }
          else {
            $sql = "INSERT INTO `cart` (`uid`, `rid`, `mid`, `num`) VALUES ('$uid', '$rid', '$mid', '$num')";
            $result = mysqli_query($db, $sql); //procedural mysql
          }
        }
        $db->close();
  }

    function menu() {
    //db connection
      $rid = $_GET["rid"];
      $user = 'root';
      $pass = '';
      $db = 'trail';
      $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
      $sql = "SELECT * FROM restaurant WHERE rid=$rid";
      $result = mysqli_query($db, $sql); //procedural mysqli
      while($row = mysqli_fetch_assoc($result)) {
        $rname = $row["rname"];
        $location = $row["location"];
      }
      echo '<div class="d-flex align-items-center justify-content-between p-3 my-3 rounded shadow-sm">
        <div class="lh-100">
          <h5 class="mb-0 lh-100 ">'.$rname.'</h5>
        </div>
        <div class="lh-100">
          <samll class="mb-0 lh-100 text-muted">'.$location.'</small>
        </div>
      </div>';
      $uid = $_SESSION['uid'];
      $sql =  "SELECT mid, num FROM cart WHERE rid = $rid AND uid = $uid";
      $res =  mysqli_query($db, $sql);
      $cart = array();
      while($row = mysqli_fetch_assoc($res)) {
          $cart[$row['mid']] = $row['num'];
      }
      $sql = "SELECT * FROM menu WHERE rid=$rid";
      $result = mysqli_query($db, $sql); //procedural mysqli
      // $conn->close(); mysqli
      mysqli_close($db);
      if (mysqli_num_rows($result) > 0) {
        $num = 0;
        $html = '<div class="my-3 p-3 bg-white rounded shadow-sm">
          <h6 class="border-bottom border-gray pb-2 mb-0">Quick Bites
            <span class="badge badge-pill bg-light align-text-bottom text-primary ">27</span>
          </h6>';
        while($row = mysqli_fetch_assoc($result)) {
          $applied = false;
          foreach($cart as $key => $value) {
            if($row['mid'] == $key) {
              $html .= '
                  <div class="media text-muted pt-3 d-flex justify-content-between align-items-center">
                    <p class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                      <strong class="d-block text-gray-dark">'.$row["mname"].'</strong>
                      '.$row["mdesc"].'
                    </p>
                    <i class="fas fa-minus text-danger  mr-2" style="cursor: pointer" onclick="minus('.$num.')" role="button"></i>
                    <span class="badge badge-pill bg-light align-text-bottom text-primary" id = "badge'.$num.'" style="height:20px; width: 40px">'.$value.'</span>
                    <i class="fas fa-plus text-success ml-2 mr-4" style="cursor: pointer" onclick="add('.$num.')" role="button"></i>
                    <button class="btn btn-danger btn-sm" id='.$num.' onclick="toggle('.$num.','.$uid.','.$rid.','.$row["mid"].')" role="button">Cancel</button>
                  </div>';
                  $applied = true;
            }
          }
          if(!$applied)
          {
            $html .=  '
            <div class="media text-muted pt-3 d-flex justify-content-between align-items-center">
              <p class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                <strong class="d-block text-gray-dark">'.$row["mname"].'</strong>
                '.$row["mdesc"].'
              </p>
              <i class="fas fa-minus text-danger  mr-2" style="cursor: pointer" onclick="minus('.$num.')" role="button"></i>
              <span class="badge badge-pill bg-light align-text-bottom text-primary" id = "badge'.$num.'" style="height:20px; width: 40px">0</span>
              <i class="fas fa-plus text-success ml-2 mr-4" style="cursor: pointer" onclick="add('.$num.')" role="button"></i>
              <button class="btn btn-primary btn-sm" id='.$num.' onclick="toggle('.$num.','.$uid.','.$rid.','.$row["mid"].')" role="button">Add To Cart</button>
            </div>';
          }
            $num++;
        }
        $html .= '
        <small class="d-block text-right mt-3">
          <a href="#">All</a>
        </small>
      </div>';
        return $html;
      } else {
        echo '<div class="media text-danger pt-3 d-flex justify-content-center align-items-center">
        <h5>No Items Available</h5>
      </div>';
      }
    }
    echo menu();
    ?>
  </main>
</body>
</html>
