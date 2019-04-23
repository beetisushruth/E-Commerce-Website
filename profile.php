<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script defer src="fontsawesome/js/all.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <script>
    function edit(id) {
      document.getElementById('input'+id.id).removeAttribute("disabled");
      document.getElementById('input'+id.id).focus();
    }
    function reload() {
      location.reload();
    }
    $(document).ready(function(){
    $('#button').click(function() {
      $.ajax({
        type: "POST",
        url: "profile.php",
        data: { name: $('#inputName').val(), email:  $('#inputEmail').val(), password:  $('#inputPassword').val()},
      }).done(function( msg ) {
        console.log("Data Saved");
      });
    });
    });
 </script>
</head>
<header style="height:54px"><?php include("nav-top.html"); ?></header>
<body>
  <main role="main" class="container">
    <div class="d-flex align-items-center justify-content-between p-3 my-3 rounded shadow-sm">
      <div class="lh-100">
        <h5 class="mb-0 lh-100 ">Profile Details</h5>
      </div>
    </div>
    <?php
    //db connection
    $user = 'root';
    $pass = '';
    $db = 'trail';
    $uid = $_SESSION['uid'];
    $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
    $sql = "SELECT * FROM user WHERE uid = $uid";
    $result = mysqli_query($db, $sql); //procedural mysqli
    mysqli_close($db);
    // $db->query($sql); //mysqli
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $name = $row['uname'];
        $email = $row['email'];
        $password = $row['password'];
      }
    }
    function displaylist($list) {
      $html = '';
      foreach ($list as $key => $value) {
        $html .= '  <tr>
            <th scope="row">'.$key.'</th>
            <td><input type="name" name ="email" id="input'.$key.'" class="form-control  mb-3" value='.$value.' disabled></td>
            <td><i class="fas fa-pen-square" id="'.$key.'" style="height: 40px; cursor: pointer" role="button" onclick="edit('.$key.')"></i></td>
          </tr>';
      }
      return $html;
    }
    if (isset($_POST['name'])) {
      //form values
      $nameEdited = $_POST["name"];
      $emailEdited = $_POST["email"];
      $passwordEdited = $_POST["password"];
      //to connect to db
        $user = 'root';
        $pass = '';
        $db = 'trail';
        $db = new mysqli('localhost', $user, $pass, $db) or die("unable to connect");
        //insert into db
        echo $nameEdited;
        $sql = "UPDATE user SET uname='$nameEdited', email='$emailEdited', password='$passwordEdited' WHERE uid=$uid";
        $db->query($sql);
        $db->close();
  }
      $list = array('Name' => $name, 'Email' => $email, 'Password' => $password);
    echo
    '<div class="p-3 bg-white rounded shadow-sm">
    <table class="table table-hover">
    <tbody>
    '.displaylist($list).'
    </tbody>
    </table>
    <div class="row d-flex justify-content-end">
    <button class="btn btn-md btn-danger mr-2" onclick="reload()" >Cancel</button>
    <button type="button" id="button" class="btn btn-md btn-success mr-2" name="select" value="submit" data-toggle="modal" data-target="#exampleModal">Save</button>
    </div>
    </div>
    ';
    ?>
  </main>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Details Successfully Updated
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Okay</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
