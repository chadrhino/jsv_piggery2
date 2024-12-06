<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>

<div class="container">
	<div class="row" style="margin-top: 10%">

		<h1 class="text-center"><?php echo NAME_X; ?></h1><br>
        <h5 class="text-center">Forgot Password</h5>
   <div class="col-md-2 col-md-offset-2">
     <img src="img/pig.png" class="img img-responsive">
   </div>
		<div class="col-md-4">
			<form method="post" autocomplete="off">
				<div class="form-group">
				   <label class="control-label">Email Account</label>
				   <input type="email" name="email" class="form-control input-sm" required>
			    </div>
                
			    <div style="display: flex; gap: 20px; justify-content: space-between; align-items: center;">
                    <button name="submit" type="submit" class="btn btn-md btn-dark">Submit</button>
                    <a href="reset-password.php">Reset Password</a>
          </div>
			</form>

			<?php
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;
            use PHPMailer\PHPMailer\SMTP;
            
            require "./phpmailer/src/Exception.php";
            require "./phpmailer/src/PHPMailer.php";
            require "./phpmailer/src/SMTP.php";
              if (isset($_POST['submit'])) {
              	$username = trim($_POST['email']);
                $verification = uniqid();
                
                $q = $db->query("SELECT * FROM admin WHERE username = '$username' LIMIT 1 ");
                $count = $q->rowCount();

                if($count > 0){
                  $update = $db->query("UPDATE admin SET verification = '$verification' WHERE username = '$username'");
                  if ($update) {
                    $mail = new PHPMailer(true);
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'sshin8859@gmail.com';
                    $mail->Password = 'trnzsprukfkfzkup';
                    $mail->Port = 587;

                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );

                    $mail->setFrom('jsvpiggery@gmail.com', 'JSV Piggery');

                    $mail->addAddress($username);
                    $mail->Subject = "Reset Password Verification Code";
                    $mail->Body = "This is your verification code: " . $verification;

                    $mail->send();
                  }
                }else{
                	$error = 'incorrect login details';
                }

              }


            if(isset($error)){ ?>
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

  showPass.onclick = () =>{
    if (password.getAttribute("type") == 'password') {
      password.setAttribute("type", "text")
      showPass.classList.replace("fa-eye", "fa-eye-slash")
    }else{
      password.setAttribute("type", "password")
      showPass.classList.replace("fa-eye-slash","fa-eye")
    }
  }

</script>


<?php include 'theme/foot.php'; ?>
