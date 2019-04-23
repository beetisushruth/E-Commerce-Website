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
  <main role="main" class="container">
    <div class="d-flex align-items-center justify-content-between p-3 my-3 rounded shadow-sm">
      <div class="lh-100">
        <h5 class="mb-0 lh-100 ">Your Orders</h5>
      </div>
    </div>
    <div class="p-3 bg-white rounded shadow-sm">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Order Id</th>
            <th scope="col">Order Name</th>
            <th scope="col">Restaurant</th>
            <th scope="col">Time</th>
            <th scope="col">Price</th>
            <th scope="col">Status</th>
            <th scope="col">Rating</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $price = 0;
            $restaurant = '';
            function menu($oid) {
              $user = 'root';
              $pass = '';
              $db = 'trail';
              $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
              $sql = "SELECT * FROM `order_details` JOIN `menu` ON order_details.rid = menu.rid AND order_details.mid = menu.mid WHERE oid = $oid";
              $result = mysqli_query($db, $sql); //procedural mysqli
              $html = '';
              $GLOBALS['price'] = 0;
              while($row = mysqli_fetch_assoc($result)) {
                $GLOBALS['price']  += $row['num']*$row['price'];
                $html .= '<tr><td>'.$row["mname"].'x'.$row["num"].'</td></tr>';
              }
              $sql = "SELECT * FROM `restaurant` WHERE rid = 1"; //temp
              $result = mysqli_query($db, $sql); //procedural mysqli
              $row = mysqli_fetch_assoc($result);
                $GLOBALS['restaurant'] = '';
                $GLOBALS['restaurant'] = $row['rname'];
              return $html;
            }
          //to connect to db
            $uid = $_SESSION['uid'];
            $user = 'root';
            $pass = '';
            $db = 'trail';
            $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
            $sql = "SELECT * FROM `order` WHERE uid=$uid";
            $result = mysqli_query($db, $sql); //procedural mysqli
            while($row = mysqli_fetch_assoc($result)) {
              echo '
              <tr>
                <th scope="row">'.$row['oid'].'</th>
                  <td><table class="table table-sm table-dark">'.menu($row['oid']).'</table></td>
                  <td>'.$restaurant.'</td>
                  <td>'.$row['time'].'pm</td>
                  <td>'.$price.' <i class="fas fa-rupee-sign" style="height:14px;"></i></td>
                  <td class="text-warning">'.$row['status'].'</td>
                  <td>5</td>
                  </tr>';
            }
            $db->close();
          ?>
      </tbody>
    </table>
    </div>
  </main>
</body>
</html>
