<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>

<div class="container">
    <div class="row" style="margin-top: 5%">
        <div class="col-md-2 col-md-offset-4" style="width: 100%;max-width: 400px;padding: 20px;border: 1px solid #333;background-color: #fff;box-sizing: border-box;text-align: center;">
        <h3 class="text-center">Sign Up</h3><br>
            <form method="post" autocomplete="off">

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" maxlength="18" name="name" placeholder="Enter your name" required>
                    <span span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa " aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="email" name="email" placeholder="Enter your email" required>
                    <span span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" name="password" placeholder="Enter your password" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                    <i id="showPass" class="fa fa-eye" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" name="confirm" placeholder="Enter confirm password"required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                    <i id="showPass2" class="fa fa-eye" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>

                <div class="g-recaptcha" 
          data-sitekey="6LeuvIsqAAAAABJsgpWNlWrB9vBl1dwI8DpUcZlr"
          data-callback="recaptchaCallback">
        </div>
      <br>
      <div class="wrap-input100 validate-input" style="text-align: left; margin-top: 20px;">
                    <label>
                        <input type="checkbox" name="terms" required>
                        I agree to the <a href="terms.php" target="_blank">Terms and Conditions</a>.
                    </label>
                </div>
                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" name="submit" type="submit" id="Button" disabled>
                       Submit
                    </button>
                </div>


                    <p>Already have an account? <a href="login.php">Login</a></p>


            </form>

            <?php
            if (isset($_POST['submit'])) {
                $name = htmlspecialchars(stripslashes(trim($_POST['name'])));
                $email = htmlspecialchars(stripslashes(trim($_POST['email'])));
                $password = htmlspecialchars(stripslashes(trim($_POST['password'])));
                $confirm = htmlspecialchars(stripslashes(trim($_POST['confirm'])));

                if (empty($name)) {
            ?>
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });

                        Toast.fire({
                            icon: "error",
                            title: "Please fill name"
                        });
                    </script>
                <?php
                } else if (empty($email)) {
                ?>
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });

                        Toast.fire({
                            icon: "error",
                            title: "Please fill email"
                        });
                    </script>
                <?php
                } else if (empty($password)) {
                ?>
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });

                        Toast.fire({
                            icon: "error",
                            title: "Please fill password"
                        });
                    </script>
                <?php
                } else if (empty($confirm)) {
                ?>
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });

                        Toast.fire({
                            icon: "error",
                            title: "Password dont't match"
                        });
                    </script>
                <?php
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                ?>
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });

                        Toast.fire({
                            icon: "error",
                            title: "Invalid email format"
                        });
                    </script>
                <?php
                } else if (strlen($password) < 8) {
                ?>
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });

                        Toast.fire({
                            icon: "error",
                            title: "Password must not be less than 8 characters"
                        });
                    </script>
                <?php
                } else if ($password !== $confirm) {
                ?>
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });

                        Toast.fire({
                            icon: "error",
                            title: "Password don't match"
                        });
                    </script>
                    <?php
                } else {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);

                    $check = $db->prepare("SELECT * FROM users WHERE email = :email");
                    $check->bindParam(':email', $email, PDO::PARAM_STR);
                    $check->execute();

                    if ($check->rowCount() > 0) {
                    ?>
                        <script>
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });

                            Toast.fire({
                                icon: "error",
                                title: "Email account already exist"
                            });
                        </script>
                <?php
                    } else {
                        $insert = $db->prepare("INSERT INTO users (name,email,password) VALUES(:name, :email, :password)");
                        $insert->bindParam(":name", $name, PDO::PARAM_STR);
                        $insert->bindParam(":email", $email, PDO::PARAM_STR);
                        $insert->bindParam(":password", $hashed, PDO::PARAM_STR);

                        if ($insert->execute()) {
                            ?>
                                <script>
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: "top-end",
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.onmouseenter = Swal.stopTimer;
                                            toast.onmouseleave = Swal.resumeTimer;
                                        }
                                    });

                                    Toast.fire({
                                        icon: "success",
                                        title: "Account created successfully"
                                    }).then(() => {
                                        window.location.href = "login.php"
                                    });
                                </script>
                            <?php
                        }

                    }
                }
            }


            if (isset($error)) { ?>
                <br><br>
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?php echo $error; ?>.</strong>
                </div>
            <?php }
            ?>


        </div>
    </div>
</div>




<p class="text-center dont-print" style="margin-top: 7%; color: white;">
	&copy; All Rights Reserved Chad Rhino Quijano 2024
</p>
<script>
    let password = document.querySelector("input[name='password']")
    let showPass = document.getElementById("showPass")

    showPass.onclick = () => {
        if (password.getAttribute("type") == 'password') {
            password.setAttribute("type", "text")
            showPass.classList.replace("fa-eye", "fa-eye-slash")
        } else {
            password.setAttribute("type", "password")
            showPass.classList.replace("fa-eye-slash", "fa-eye")
        }
    }

    let confirm = document.querySelector("input[name='confirm']")
    let showPass2 = document.getElementById("showPass2")

    showPass2.onclick = () => {
        if (confirm.getAttribute("type") == 'password') {
            confirm.setAttribute("type", "text")
            showPass.classList.replace("fa-eye", "fa-eye-slash")
        } else {
            confirm.setAttribute("type", "password")
            showPass.classList.replace("fa-eye-slash", "fa-eye")
        }
    }
    function recaptchaCallback() {
    document.getElementById("Button").disabled = false;
  }
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>
  body {
    background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.4)), url('https://jsvpiggery.com/users/pages/images/piggery.jpg');
    background-size: cover; 
    background-position: center; 
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
  .g-recaptcha {
    display: block; 
    margin: 10px auto; 
    box-sizing: border-box;
    width: 302px;
}
  .p{
    color: white;
  }
</style>