<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

	<!-- Header -->
	<header class="w3-container" style="padding-top:22px">
		<h5><b><i class="fa fa-dashboard"></i> Pig Management > Add</b></h5>
	</header>

	<?php #include 'inc/data.php'; 
	?>


	<div class="w3-container" style="padding-top:22px">
		<div class="w3-row">
			<h2>Add New Pig</h2>

			<div class="col-md-12">

				<?php
				if (isset($_POST['submit'])) {
					if (isset($_FILES['pigphoto']['tmp_name'])) {

						$n_pigno = $_POST['pigno'];
						$n_weight = $_POST['weight'];
						$n_arrived = $_POST['arrived'];
						$n_breed = $_POST['breed'];
						$n_classification = $_POST['classification'];
						$n_feed = $_POST['feed'];
						$n_vitamins = $_POST['vitamins'];
						$n_remark = $_POST['remark'];
						$n_status = $_POST['status'];
						$n_gender = $_POST['gender'];
						$n_desc = $_POST['description'];
						$n_month = $_POST['month'];


						$res1_name = basename($_FILES['pigphoto']['name']);
						$tmp_name = $_FILES['pigphoto']['tmp_name'];
						$type = $_FILES['pigphoto']['type'];
						$max_size = 2097152;
						$size = $_FILES['pigphoto']['size'];

						if (isset($res1_name)) {
							$location = 'uploadfolder/';
							$move = move_uploaded_file($tmp_name, $location . $res1_name);
							$path1 = $location . $res1_name;


							if (!$move) {
								$fileerror = $_FILES['pigphoto']['error'];
								$message = $upload_errors[$fileerror];
							}
						}
					}






					$insert = $db->query("INSERT INTO pigs(pigno,weight,arrived,breed_id, classification_id, feed_id, vitamins_id,remark,health_status,img,gender,description,month) VALUES('$n_pigno','$n_weight','$n_arrived','$n_breed','$n_classification', '$n_feed', '$n_vitamins', '$n_remark','$n_status','$path1','$n_gender','$n_desc', '$n_month') ");

					if ($insert) { ?>
						<!-- <div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Pig successfully created <i class="fa fa-check"></i></strong>
						</div> -->

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
								title: "Pig successfully created"
							});
						</script>
					<?php
					} else { ?>
						<!-- <div class="alert alert-danger alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Error creatiing pig data. Please try again <i class="fa fa-times"></i></strong>
						</div> -->

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
								icon: "error",
								title: "Error creatiing pig data. Please try again"
							});
						</script>
				<?php
					}
				}

				?>




				<form method="post" autocomplete="off" enctype="multipart/form-data">
					<div class="form-group">
						<label class="control-label">Pig No.</label>
						<input type="text" name="pigno" class="form-control" value="pig-fms-<?php echo mt_rand(0000, 9999); ?>" readonly="on" required>
					</div>

					<div class="row gap-2">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Pig Weight(kilo)</label>
								<input type="text" name="weight" class="form-control" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group date">
								<label class="control-label">Arrival date</label>
								<input type="text" name="arrived" class="form-control datepicker" required>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">Month</label>
						<select name="month" class="form-control" required>
							<?php 
								for ($i = 1; $i <= 1000 ; $i++) { 
									if ($i == 1) {
										?>
									<option value="<?= $i ?>"><?= $i ?> month</option>
									<?php 
									}else if($i > 1){
										?>
										<option value="<?= $i ?>"><?= $i ?> months</option>
										<?php 
									}
								}
							?>
							
						</select>
					</div>

					<div class="form-group">
						<label class="control-label">Gender</label>
						<select name="gender" class="form-control" required>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
					</div>

					<div class="form-group">
						<label class="control-label">Health Status</label>
						<select name="status" class="form-control" required>
							<option value="active">Active</option>
							<!-- <option value="inactive">Inactive</option> -->
							<option value="on treatment">On treatment</option>
							<option value="sick">Sick</option>
						</select>
					</div>

					<div class="row gap-2">

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Breed</label>
								<select name="breed" class="form-control" required>
									<option value="">Select Breed</option>
									<?php
									$getBreed = $db->query("SELECT * FROM breed");
									$res = $getBreed->fetchAll(PDO::FETCH_OBJ);
									foreach ($res as $r) { ?>
										<option value="<?php echo $r->id; ?>"><?php echo $r->name; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Classification</label>
								<select name="classification" class="form-control" required>
									<option value="">Select Classification</option>
									<?php
									$getClassification = $db->query("SELECT * FROM classification");
									$res = $getClassification->fetchAll(PDO::FETCH_OBJ);
									foreach ($res as $r) { ?>
										<option value="<?php echo $r->id; ?>"><?php echo $r->name; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Feed</label>
								<select name="feed" class="form-control" required>
									<option value="">Select Feed</option>
									<?php
									$getFeed = $db->query("SELECT * FROM feed");
									$res = $getFeed->fetchAll(PDO::FETCH_OBJ);
									foreach ($res as $r) { ?>
										<option value="<?php echo $r->id; ?>"><?php echo $r->name; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Vitamins</label>
								<select name="vitamins" class="form-control" required>
									<option value="">Select Vitamin</option>
									<?php
									$getVitamins = $db->query("SELECT * FROM vitamins");
									$res = $getVitamins->fetchAll(PDO::FETCH_OBJ);
									foreach ($res as $r) { ?>
										<option value="<?php echo $r->id; ?>"><?php echo $r->name; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

					</div>

					<div class="form-group">
						<label class="control-label" style="display: none;">Remark</label>
						<input class="form-control" name="remark" type="hidden">
					</div>

					<div class="form-group">
						<label class="control-label">Description</label>
						<textarea class="form-control" name="description" required></textarea>
					</div>

					<div class="form-group">
						<label class="control-label">Pig photo</label>
						<input type="file" name="pigphoto" class="form-control" required>
					</div>

					<button name="submit" type="submit" class="btn btn-sn btn-default">Submit</button>
				</form>
			</div>
		</div>
	</div>

</div>
<script>
	$(document).ready(function(){
		$('.datepicker').datepicker({
    startDate: '3d'
});
	})
</script>
<?php include 'theme/foot.php'; ?>