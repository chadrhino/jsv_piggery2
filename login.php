<?php 
include 'setting/system.php';
include 'theme/head.php';
// Start the session

// Redirect if already logged in
if (isset($_SESSION['USER_ID']) && isset($_SESSION['USER_NAME']) && isset($_SESSION['USER_EMAIL'])) {
  echo "<script>window.location.href = 'index.php?page=product';</script>";
  exit();
} elseif (isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['user'])) {
  echo "<script>window.location.href = 'dashboard.php';</script>";
  exit();
}

function handleFailedAttempt() {
  $_SESSION['login_attempts'] += 1;

  if ($_SESSION['login_attempts'] >= 3) {
      $_SESSION['lockout_time'] = time() + $GLOBALS['lockout_duration'];
      echo "<script>
          Swal.fire({ 
              icon: 'error', 
              title: 'Too many failed attempts. Please wait 3 minutes before trying again.' 
          });
      </script>";
  } else {
      $remaining_attempts = 3 - $_SESSION['login_attempts'];
      echo "<script>
          Swal.fire({ 
              icon: 'error', 
              title: 'Incorrect username or password', 
              text: 'You have $remaining_attempts attempt(s) remaining.' 
          });
      </script>";
  }
}
// Initialize attempt tracking
if (!isset($_SESSION['login_attempts'])) {
  $_SESSION['login_attempts'] = 0;
  $_SESSION['lockout_time'] = 0;
}

$lockout_duration = 180; // Lockout duration in seconds (3 minutes)

if (time() < $_SESSION['lockout_time']) {
  $remaining_time = $_SESSION['lockout_time'] - time();
  echo "<script>
      Swal.fire({ 
          icon: 'error', 
          title: 'Too many attempts. Please wait $remaining_time seconds.' 
      });
  </script>";
  exit();
}

if (isset($_POST['submit'])) {
  $username = htmlspecialchars(stripslashes(trim($_POST['username'])));
  $password = htmlspecialchars(stripslashes(trim($_POST['password'])));
  $recaptcha_response = $_POST['g-recaptcha-response'];

  // Verify reCAPTCHA response with Google
  $secret_key = "YOUR_SECRET_KEY"; // Replace with your reCAPTCHA secret key
  $url = "https://www.google.com/recaptcha/api/siteverify";
  $data = [
    'secret' => $secret_key,
    'response' => $recaptcha_response
  ];

  $options = [
    'http' => [
      'method'  => 'POST',
      'content' => http_build_query($data),
      'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
    ]
  ];
  $context = stream_context_create($options);
  $verify = file_get_contents($url, false, $context);
  $captcha_success = json_decode($verify);

  if (!$captcha_success->success) {
    echo "<script>
        Swal.fire({ 
            icon: 'error', 
            title: 'Please verify that you are not a robot.' 
        });
    </script>";
    exit();
  }

  // Check admin table first
  $get_admin = $db->prepare("SELECT * FROM admin WHERE username = :uname");
  $get_admin->bindParam(':uname', $username, PDO::PARAM_STR);
  $get_admin->execute();

  if ($get_admin->rowCount() > 0) {
      $row = $get_admin->fetch(PDO::FETCH_OBJ);
      if (password_verify($password, $row->password)) {
          $_SESSION['id'] = $row->id;
          $_SESSION['name'] = $row->name;
          $_SESSION['user'] = $row->username;
          $_SESSION['login_attempts'] = 0; // Reset attempts on success
          echo "<script>
              Swal.fire({ icon: 'success', title: 'Account signed in successfully', timer: 1500 }).then(() => {
                  window.location.href = 'dashboard.php';
              });
          </script>";
      } else {
          handleFailedAttempt();
      }
  } else {
      // Check users table
      $get_user = $db->prepare("SELECT * FROM users WHERE email = :email");
      $get_user->bindParam(':email', $username, PDO::PARAM_STR);
      $get_user->execute();

      if ($get_user->rowCount() > 0) {
          $row = $get_user->fetch(PDO::FETCH_OBJ);
          if (password_verify($password, $row->password)) {
              $_SESSION['USER_ID'] = $row->id;
              $_SESSION['USER_NAME'] = $row->name;
              $_SESSION['USER_EMAIL'] = $row->email;
              $_SESSION['login_attempts'] = 0; // Reset attempts on success
              echo "<script>
                  Swal.fire({ icon: 'success', title: 'Account signed in successfully', timer: 1500 }).then(() => {
                      window.location.href = 'index.php?page=product';
                  });
              </script>";
          } else {
              handleFailedAttempt();
          }
      } else {
          handleFailedAttempt();
      }
  }
}
?>

<div class="container">
  <div class="row" style="margin-top: 7%">
    <div class="col-md-2 col-md-offset-4" style="width: 100%;max-width: 400px;padding: 20px;border: 1px solid #333;background-color: #fff;box-sizing: border-box;text-align: center;">
      <img src="img/pig.png" alt="Jsv" style="width: 120px; height: auto; margin-bottom: 20px;">
      <h1 class="text-center"><?php echo NAME_X; ?></h1><br>
      <form method="post" autocomplete="off" id="loginForm">
        <div class="wrap-input100 validate-input">
          <input class="input100" type="email" name="username" placeholder="Enter your email" required>
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
          </span>
        </div>

        <div class="wrap-input100 validate-input">
          <input class="input100" type="password" name="password" placeholder="Enter your password">
          <span class="focus-input100"></span>
          <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
          </span>
          <i id="showPass" class="fa fa-eye" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
        </div>

        <div class="g-recaptcha" data-sitekey="6LeuvIsqAAAAABJsgpWNlWrB9vBl1dwI8DpUcZlr" data-callback="recaptchaCallback"></div>
        <br>

        <div class="container-login100-form-btn">
          <button class="login100-form-btn" name="submit" type="submit" id="Button" disabled>
            Login
          </button>
        </div>

        <div class="text-center p-t-12">
          <a class="txt2" href="index.php">
            Back To Home
          </a>
          <span class="txt1">
            Don't have an account?
          </span>
          <a class="txt2" href="signup.php">
            Sign Up
          </a>
        </div>
        <a href="forgot_portal.php">Forgot Password</a>
      </form>

    </div>
  </div>
</div>

<p class="text-center dont-print" style="margin-top: 6%; color: white;">
  &copy; All Rights Reserved Chad Rhino Quijano 2024
</p>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
  let password = document.querySelector("input[name='password']");
  let showPass = document.getElementById("showPass");

  showPass.onclick = () => {
    if (password.getAttribute("type") == 'password') {
      password.setAttribute("type", "text");
      showPass.classList.replace("fa-eye-slash", "fa-eye");
    } else {
      password.setAttribute("type", "password");
      showPass.classList.replace("fa-eye", "fa-eye-slash");
    }
  }

  function recaptchaCallback() {
    document.getElementById("Button").disabled = false;
  }
</script>

<style>
  /* Your existing styles here */
</style>
