:<?php 
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
        $recaptcha_response = $_POST['recaptcha_response'];
    
        // Verify reCAPTCHA response
        $recaptcha_secret = 'your-secret-key'; // Replace with your actual secret key
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_data = [
            'secret' => $recaptcha_secret,
            'response' => $recaptcha_response,
        ];
    
        $recaptcha_options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($recaptcha_data),
            ],
        ];
        $recaptcha_context = stream_context_create($recaptcha_options);
        $recaptcha_verify = file_get_contents($recaptcha_url, false, $recaptcha_context);
        $recaptcha_result = json_decode($recaptcha_verify);
    
        if ($recaptcha_result->success) {
            // Proceed with the login process
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
        } else {
            echo "<script>
                Swal.fire({ 
                    icon: 'error', 
                    title: 'reCAPTCHA verification failed. Please try again.' 
                });
            </script>";
        }
    }
?>

<div class="container">
	<div class="row" style="margin-top: 7% ">
		<div class="col-md-2 col-md-offset-4" style="width: 100%;max-width: 400px;padding: 20px;border: 1px solid #333;background-color: #fff;box-sizing: border-box;text-align: center;">
    <img src="img/pig.png" alt="Jsv" style="width: 120px; height: auto; margin-bottom: 20px;">

    <h1 class="text-center"><?php echo NAME_X; ?></h1><br>
    <form method="post" autocomplete="off" id="loginForm">
    <!-- Email and Password fields -->
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

    <!-- reCAPTCHA field -->
    <div class="g-recaptcha" data-sitekey="6LeuvIsqAAAAABJsgpWNlWrB9vBl1dwI8DpUcZlr" data-callback="recaptchaCallback"></div>
    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

    <div class="container-login100-form-btn">
        <button class="login100-form-btn" name="submit" type="submit" id="Button" disabled>
            Login
        </button>
    </div>

    <div class="text-center p-t-12">
        <a class="txt2" href="index.php">Back To Home</a>
        <span class="txt1">Don't have an account?</span>
        <a class="txt2" href="signup.php">Sign Up</a>
    </div>
    <a href="forgot_portal.php">Forgot Password</a>
</form>

			<?php


if (isset($_POST['submit'])) {
  $username = htmlspecialchars(stripslashes(trim($_POST['username'])));
  $password = htmlspecialchars(stripslashes(trim($_POST['password'])));

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
		</div>
	</div>
</div>

<p class="text-center dont-print" style="margin-top: 6%; color: white;">
	&copy; All Rights Reserved Chad Rhino Quijano 2024
</p>
 <script src="https://www.google.com/recaptcha/api.js" async defer></script>


<script>
  function recaptchaCallback(response) {
    document.getElementById("recaptchaResponse").value = response; // Store the response in the hidden field
    document.getElementById("Button").disabled = false; // Enable the login button
}

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
};ument.getElementById("Button").disabled = false;

</script>

<style>
  body {
    background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.4)), url('https://jsvpiggery.com/users/pages/images/piggery.jpg');
    background-size: cover; 
    background-position: center; 
}
.g-recaptcha {
    display: block; 
    margin: 10px auto; 
    box-sizing: border-box;
    width: 302px;
}
    .wrap-input100 {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
  }

  .input100 {
    font-family: Poppins-Regular;
    font-size: 16px;
    color: #333;
    line-height: 1.2;
    display: block;
    width: 100%;
    background: #e6e6e6;
    height: 55px;
    border-radius: 25px;
    padding: 0 30px 0 68px;
    box-sizing: border-box;
  }

  .symbol-input100 {
    position: absolute;
    font-size: 18px;
    color: #999999;
    top: 50%;
    left: 35px;
    transform: translateY(-50%);
    transition: all 0.4s;
  }
  .txt1 {
    font-size: 14px;
    color: #999999;
    line-height: 1.5;
  }

  .txt2 {
    font-size: 14px;
    color: #333;
    text-decoration: none;
  }
  
  .login100-form-btn {
    font-family: Poppins-Medium;
    font-size: 16px;
    color: white;
    background-color: #333;
    border: none;
    border-radius: 25px;
    width: 100%;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 25px;
    transition: all 0.4s;
    cursor: pointer;
  }
  .footer{
    color: white;
  }
</style>