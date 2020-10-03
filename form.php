<?php

$name = $relationship = $email = $passwd = $gender = $birthdate = "";
$ERRORS = array("name"=>"", "relationship"=>"", "email"=>"", "passwd"=>"", "gender"=>"", "birthdate"=>"");

function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // check name
  if (empty($_POST['name'])) {
    $ERRORS['name'] = "Enter your name";
  } else {
    $name = test_input($_POST['name']);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
      $ERRORS['name'] = "Enter a valid name";
      $name = "";
    }
  }

  // check relationship
  if (empty($_POST['relationship'])) {
    $ERRORS['relationship'] = "What is your relationship with Mufid";
  } else {
    $relationship = test_input($_POST['relationship']);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $relationship)) {
      $ERRORS['relationship'] = "NULL";
      $relationship = "";
    }
  }

  // check email
  if (empty($_POST['email'])) {
    $ERRORS['email'] = "Enter your email";
  } else {
    $email = test_input($_POST['email']);
    if (FILTER_VAR($name, FILTER_VALIDATE_EMAIL)) {
      $ERRORS['email'] = "Enter a valid email";
      $email = "";
    }
  }

  // check password
  if (empty($_POST['passwd'])) {
    $ERRORS['passwd'] = "Create password";
  } else {
    $passwd = test_input($_POST['passwd']);
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $passwd)) {
      $ERRORS['passwd'] = "Password must contain atleast an upper case, a lower case, a digit. Minimun 8 characters";
      $passwd = "";
    }
  }

  // check gender
  if (empty($_POST['gender'])) {
    $ERRORS['gender'] = "Choose your gender";
  } else {
    $gender = $_POST['gender'];
  }


  if (!array_filter($ERRORS)) {

    $conn = mysqli_connect("localhost", "mufid", "mohammed", "myDB");
    if (!$conn) {
      die("Error connecting to database: " . mysqli_connect_error());
    }
  
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $relationship = mysqli_real_escape_string($conn, $_POST['relationship']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $birthdate = date($_POST['birthdate']);

    $sql = "INSERT INTO family (name, relationship, email, password, gender, birthdate) VALUES('$name', '$relationship', '$email', '$passwd', '$gender', '$birthdate')";
  
    if (mysqli_query($conn, $sql)) {
      echo "record added successfully.";
    } else {
      echo mysqli_error($conn);
    }
  
    mysqli_close($conn);
  }
  
}

?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">House Record</h1>
    <p class="lead">Record of people in my house</p>
    </div>
  </div>
  <div class="container">
    <form action="form.php" method="POST">
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Name</label>
        <div class="col-sm-10 col-md-6 col-lg-3">
          <input type="text" name="name" class="form-control">
          <div class="text-danger"><?php echo $ERRORS['name'] ;?></div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Relationship</label>
        <div class="col-sm-10 col-md-6 col-lg-3">
          <input type="text" name="relationship" class="form-control">
          <div class="text-danger"><?php echo $ERRORS['relationship'] ;?></div>
        </div>
      </div>  
      <div class="form-group row">
        <label for="inputEmail3" class="col-sm-1 col-form-label">Email</label>
        <div class="col-sm-10 col-md-6 col-lg-3">
          <input type="email" name="email" class="form-control" id="inputEmail3">
          <div class="text-danger"><?php echo $ERRORS['email'] ;?></div>
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-1 col-form-label">Password</label>
        <div class="col-sm-10 col-md-6 col-lg-3">
          <input type="password" name="passwd" class="form-control" id="inputPassword3">
          <div class="text-danger"><?php echo $ERRORS['passwd'] ;?></div>
        </div>
      </div>
      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-1 pt-0">Gender</legend>
          <div class="col-sm-10 col-md-6 col-lg-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="male" checked>
              <label class="form-check-label" for="gridRadios1">Male</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="female">
              <label class="form-check-label" for="gridRadios2">Female</label>
            </div>
            <div class="form-check disabled">
              <input class="form-check-input" type="radio" name="gender" id="gridRadios3" value="other" disabled>
              <label class="form-check-label" for="gridRadios3">Prefer not to say</label>
            </div>
            <div class="text-danger"><?php echo $ERRORS['gender'] ;?></div>
          </div>
        </div>
      </fieldset>
      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-1 pt-0">Birthdate</legend>
          <div class="col-sm-10 col-md-6 col-lg-3">
            <input type="date" name="birthdate" class="form-control" required="">
          </div>
        </div>
      </fieldset>
      <div class="form-group row">
        <div class="col-sm-2">Please check</div>
        <div class="col-sm-10 col-md-6 col-lg-3">
          <div class="form-check">
            <input class="form-check-input" name="human" type="checkbox" id="gridCheck1" required="">
            <label class="form-check-label" for="gridCheck1">I am not a robot</label>
  
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-10 col-md-6 col-lg-3">
          <button type="submit" name="submit" class="btn btn-primary">Record</button>
        </div>
      </div>
    </form>    
  </div>

  <div class="center text-muted bg-dark py-3">Copyright 2020</div>
</body>
</html>