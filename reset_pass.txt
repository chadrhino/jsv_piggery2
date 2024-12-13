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
				   <label class="control-label">Verification</label>
				   <input type="text" name="verification" class="form-control input-sm" required>
			    </div>

                <div class="form-group">
				   <label class="control-label">New Password</label>
				   <input type="password" name="new" class="form-control input-sm" required>
			    </div>

                <div class="form-group">
				   <label class="control-label">Confirm Password</label>
				   <input type="password" name="confirm" class="form-control input-sm" required>
			    </div>
                
			    <div style="display: flex; gap: 20px; justify-content: space-between; align-items: center;">
                    <button name="submit" type="submit" class="btn btn-md btn-dark">Submit</button>
          </div>
			</form>

			<?php

              if (isset($_POST['submit'])) {
              	$verification = trim($_POST['verification']);
                $new = $_POST['new'];
                $confirm = $_POST['confirm'];
                
                
                $q = $db->query("SELECT * FROM admin WHERE verification = '$verification' LIMIT 1 ");
                $count = $q->rowCount();

                if($count > 0){

                    if (strlen($new) < 8) {
                        $error = 'Password must be equal or greater than 8 characters';
                    }else if ($new !== $confirm) {
                        $error = 'Password don\'t match';
                    }else{
                        $md5 = sha1($new);
                        $update = $db->query("UPDATE admin SET password = '$md5' WHERE verification = '$verification'");
                        if ($update) {
                            $message = "Password changer successfully, Redirecting in 3seconds...";
                            ?>
                            <script>
                                setTimeout(() => {
                                    window.location.href = "index.php"
                                }, 3000);
                            </script>
                            <?php 
                        }
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

            <?php if(isset($message)){ ?>
            <br><br>
               <div class="alert alert-success alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong><?php echo $message; ?>.</strong>
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
