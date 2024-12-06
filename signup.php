<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>

<div class="container">
    <div class="row" style="margin-top: 10%">

        <h3 class="text-center">Sign Up</h3><br>
        <div class="col-md-2 col-md-offset-2">
            <img src="img/pig.png" class="img img-responsive">
        </div>
        <div class="col-md-4">
            <form method="post" autocomplete="off">
                <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" name="name" class="form-control input-sm" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="email" name="email" class="form-control input-sm" required>
                </div>

                <div class="form-group">
                    <label class="control-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" class="form-control input-sm" required>
                        <i class="fa fa-eye " id="showPass" data-target="password" style="position: absolute; top: 7px; right:10px;cursor: pointer;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">Confirm Password</label>
                    <div style="position: relative;">
                        <input type="password" name="confirm" class="form-control input-sm" required>
                        <i class="fa fa-eye " id="showPass2" data-target="confirm" style="position: absolute; top: 7px; right:10px;cursor: pointer;"></i>
                    </div>
                </div>

                <div style="display: flex; gap: 20px; justify-content: space-between; align-items: center;">
                    <button name="submit" type="submit" class="btn btn-md btn-dark">Submit</button>
                    <!-- <a href="forgot.php">Forgot Password</a> -->
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>


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
</script>


<?php include 'theme/foot.php'; ?>