<?php
// Start the session
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <script>
    $("head").load("header.html");
    function order() {
      $.ajax({
        type: "POST",
        url: "cart.php",
        data: { 'flag': 'order'},
      }).done(function( msg ) {
        console.log("ordered");
      });
    }
    function redirect() {
      window.location.href = "orders.php";
    }
 </script>
</head>
<body>
<?php include("nav-top.html"); ?>
<?php
$uid = $_SESSION['uid'];
if (isset($_POST['flag'])) {
  //to connect to //
    $user = 'root';
    $pass = '';
    $db = 'trail';
    $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
    $sql =  "SELECT * FROM cart WHERE uid = $uid";
    $res =  mysqli_query($db, $sql);
    if (mysqli_num_rows($res) > 0) {
    $sql = "SELECT * FROM `order`";
    $result = mysqli_query($db, $sql); //procedural mysql
    $oid = 0;
    while($row = mysqli_fetch_assoc($result)) {
      if($oid < $row["oid"]) {
        $oid = $row["oid"];
      }
    }
    $oid++;
    date_default_timezone_set('Asia/Kolkata');
    $date = date('h:i:sa');
    $sql = "INSERT INTO `order` (`oid`, `uid`, `time`, `status`) VALUES ('$oid', '$uid', '$date', 'pending')";
    $result = mysqli_query($db, $sql); //procedural mysql
    while($row = mysqli_fetch_assoc($res)) {
        $rid = $row["rid"];
        $mid = $row["mid"];
        $num = $row["num"];
        $sql = "INSERT INTO `order_details` (`oid`, `rid`, `mid`, `num`) VALUES ('$oid', '$rid', '$mid', '$num')";
        $result = mysqli_query($db, $sql); //procedural mysql
    }
    $sql =  "DELETE FROM cart WHERE uid = $uid";
    $res =  mysqli_query($db, $sql);
  }
  else {
    echo "no items in the cart";
  }
  $db->close();
}
?>
<div class="container">
  <div class="py-5 text-center mt-4">
    <h2>Checkout form</h2>
  </div>
  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Your cart</span>
        <span class="badge badge-secondary badge-pill">2</span>
      </h4>
      <ul class="list-group mb-3">
      <?php
      //to connect to db
        $user = 'root';
        $pass = '';
        $db = 'trail';
        $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
        $sql = "SELECT * from menu JOIN cart ON menu.rid = cart.rid AND menu.mid = cart.mid WHERE uid = $uid";
        $result = mysqli_query($db, $sql); //procedural mysql
        $total_price = 0;
        while($row = mysqli_fetch_assoc($result)) {
          $total_price += $row['price']*$row["num"];
          echo '
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">'.$row["mname"].' x'.$row["num"].'</h6>
                <small class="text-muted">'.$row["type"].'</small>
              </div>
              <span class="text-muted">&#x20B9;'.$row["price"].'</span>
            </li>
            ';
        }
    ?>
    <li class="list-group-item d-flex justify-content-between bg-light">
      <div class="text-success">
        <h6 class="my-0">Promo code</h6>
        <small>EXAMPLECODE</small>
      </div>
      <span class="text-success">-&#x20B9;5</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
      <span>Total (INR)</span>
      <strong>&#x20B9;<?php echo $total_price-5 ?></strong>
    </li>
  </ul>

  <form class="card p-2">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Promo code">
      <div class="input-group-append">
        <button type="submit" class="btn btn-secondary">Redeem</button>
      </div>
    </div>
  </form>
</div>
    <div class="col-md-8 order-md-1">
      <h4 class="mb-3">Billing address</h4>
      <form class="needs-validation" novalidate>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
            <div class="invalid-feedback">
              Valid first name is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
            <div class="invalid-feedback">
              Valid last name is required.
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="email">Email <span class="text-muted">(Optional)</span></label>
          <input type="email" class="form-control" id="email" placeholder="you@example.com">
          <div class="invalid-feedback">
            Please enter a valid email address for shipping updates.
          </div>
        </div>
        <div class="mb-3">
          <label for="address">Phone Number</label>
          <input type="text" class="form-control" id="address" placeholder="9xxxxxxxx" required>
          <div class="invalid-feedback">
            Please enter your phone Number.
          </div>
        </div>
        <div class="mb-3">
          <label for="address">Address</label>
          <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
          <div class="invalid-feedback">
            Please enter your shipping address.
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 mb-3">
            <label for="country">Country</label>
            <select class="custom-select d-block w-100" id="country" required>
              <option value="">Choose...</option>
              <option>United States</option>
              <option>U.K</option>
              <option>India</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid country.
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="state">State</label>
            <select class="custom-select d-block w-100" id="state" required>
              <option value="">Choose...</option>
              <option>California</option>
            </select>
            <div class="invalid-feedback">
              Please provide a valid state.
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <label for="zip">Zip</label>
            <input type="text" class="form-control" id="zip" placeholder="" required>
            <div class="invalid-feedback">
              Zip code required.
            </div>
          </div>
        </div>
        <hr class="mb-4">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="same-address">
          <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
        </div>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="save-info">
          <label class="custom-control-label" for="save-info">Save this information for next time</label>
        </div>
        <hr class="mb-4">

        <h4 class="mb-3">Payment</h4>

        <div class="d-block my-3">
          <div class="custom-control custom-radio">
            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
            <label class="custom-control-label" for="credit">Credit card</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
            <label class="custom-control-label" for="debit">Debit card</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required>
            <label class="custom-control-label" for="paypal">PayPal</label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="cc-name">Name on card</label>
            <input type="text" class="form-control" id="cc-name" placeholder="" required>
            <small class="text-muted">Full name as displayed on card</small>
            <div class="invalid-feedback">
              Name on card is required
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="cc-number">Credit card number</label>
            <input type="text" class="form-control" id="cc-number" placeholder="" required>
            <div class="invalid-feedback">
              Credit card number is required
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-3">
            <label for="cc-expiration">Expiration</label>
            <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
            <div class="invalid-feedback">
              Expiration date required
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <label for="cc-cvv">CVV</label>
            <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
            <div class="invalid-feedback">
              Security code required
            </div>
          </div>
        </div>
        <hr class="mb-4">
        <?php echo '<a class="btn btn-primary btn-lg btn-block mb-4 text-white" style="cursor:pointer" role="button" onclick="order()" data-toggle="modal" data-target="#exampleModal">Place Order</a>' ?>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Order Place!</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      Order Placed Successfully
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-success" data-dismiss="modal" onclick="redirect()">Redirect to Orders</button>
    </div>
  </div>
</div>
</div>
</body>
</html>
