<?php

session_start();
require_once '../config/db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="style.css" />
  <title>Sign in & Sign up Form</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="signin_db.php" method="post" class="sign-in-form">
          <?php if (isset($_SESSION['error'])) { ?>
            <div class=" alert alert-danger" role="alert">
              <?php
              echo $_SESSION['error'];
              unset($_SESSION['error']);
              ?>
            </div>
          <?php } ?>
          <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success" role="alert">
              <?php
              echo $_SESSION['success'];
              unset($_SESSION['success']);
              ?>
            </div>
          <?php } ?>
          <h1 class="title">Sign in</h1>
          <div class="input-field">
            <i class='bx bxs-envelope'></i>
            <input type="email" class="form-control" name="email" placeholder="email">
          </div>
          <div class="input-field">
            <i class='bx bxs-lock'></i>
            <input type="password" class="form-control" name="password" placeholder="password">
          </div>
          <button type="submit" name="signin" class="btn btn-primary">Sign In</button>
          <p class="social-text">Or Sign in with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class='bx bxl-facebook'></i>
            </a>
            <a href="#" class="social-icon">
              <i class='bx bxl-google'></i>
            </a>
            <a href="#" class="social-icon">
              <i class='bx bxl-apple'></i>
            </a>
          </div>
        </form>

        <form action="signup_db.php" method="post" class="sign-up-form">
          <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php
              echo $_SESSION['error'];
              unset($_SESSION['error']);
              ?>
            </div>
          <?php } ?>
          <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success" role="alert">
              <?php
              echo $_SESSION['success'];
              unset($_SESSION['success']);
              ?>
            </div>
          <?php } ?>
          <?php if (isset($_SESSION['warning'])) { ?>
            <div class="alert alert-warning" role="alert">
              <?php
              echo $_SESSION['warning'];
              unset($_SESSION['warning']);
              ?>
            </div>
          <?php } ?>

          <h1 class="title">Sign UP</h1>

          <div class="input-field">
            <i class='bx bxs-user'></i>
            <input type="text" class="form-control" name="firstname" placeholder="Firstname">
          </div>
          <div class="input-field">
            <i class='bx bxs-user'></i>
            <input type="text" class="form-control" name="lastname" placeholder="Lastname">
          </div>
          <div class="input-field">
            <i class='bx bxs-envelope'></i>
            <input type="email" class="form-control" name="email" placeholder="Email">
          </div>
          <div class="input-field">
            <i class='bx bxs-lock'></i>
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <div class="input-field">
            <i class='bx bxs-lock'></i>
            <input type="password" class="form-control" name="c_password" placeholder="Confirm password">
          </div>
          <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
          
          <p class="social-text">Or Sign up with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class='bx bxl-facebook'></i>
            </a>
            <a href="#" class="social-icon">
              <i class='bx bxl-google'></i>
            </a>
            <a href="#" class="social-icon">
              <i class='bx bxl-apple'></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Welcome</h3>
          <p>
            Have you joined our classes yet? If not, sign up now—what are you waiting for? 😊
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Sign up
          </button>
        </div>
        <img src="img/inn.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Welcome to family!</h3>
          <p>
            Have fun learning Japanese—keep going! 💪😊 ファイト！
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="img/tr.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="app.js"></script>
</body>

</html>