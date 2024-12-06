<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<?php
if (!$_GET['id'] or empty($_GET['id']) or $_GET['id'] == '') {
	header('location: manage-pig.php');
} else {

	$pigno = $bname = $b_id = $health = "";
	$id = (int)$_GET['id'];
	$query = $db->query("SELECT * FROM pigs WHERE id = '$id' ");
	$fetchObj = $query->fetchAll(PDO::FETCH_OBJ);

	foreach ($fetchObj as $obj) {
		$pigno = $obj->pigno;
		$pid = $obj->id;
		$b_id = $obj->breed_id;
		$c_id = $obj->classification_id;
		$health = $obj->health_status;

		$k = $db->query("SELECT * FROM breed WHERE id = '$b_id' ");
		$k = $db->query("SELECT * FROM classification WHERE id = '$c_id' ");
		$ks = $k->fetchAll(PDO::FETCH_OBJ);
		foreach ($ks as $r) {
			$bname = $r->name;
			$cname = $r->name;
		}
	}
}

?>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

	<!-- Header -->
	<header class="w3-container" style="padding-top:22px">
		<h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
	</header>

	<?php #include 'inc/data.php'; 
	?>


	<div class="w3-container" style="padding-top:22px">
		<div class="w3-row">
			<h2>Quarantine List</h2>
			<div class="col-md-6 table-responsive">
				<table class="table table-hover" id="table">
					<thead>
						<tr>
							<th>Pig No</th>
							<th>Date quarantined</th>
							<th>Reason</th>
						</tr>
					</thead>
					<tbody>
						<?php

						$get = $db->query("SELECT * FROM quarantine");
						$res = $get->fetchAll(PDO::FETCH_OBJ);
						foreach ($res as $n) { ?>
							<tr>
								<td> <?php echo $n->pig_no; ?> </td>
								<td> <?php echo $n->date_q; ?> </td>
								<td> <?php echo $n->reason; ?> </td>
							</tr>
						<?php }

						?>
					</tbody>
				</table>
			</div>

			<div class="col-md-6">

				<?php
				if (isset($_POST['submit'])) {
					$id = $_POST['id'];
					$n_remark = $_POST['reason'];
					$now = date('Y-m-d');
					$date_end = $_POST['date_end'];
					$date_start = $_POST['date_start'];
					$n_id = $_GET['id'];
					$status = 2;

					$insert_query = $db->query("INSERT INTO quarantine(pig_no,reason,date_q,date_end,date_start)VALUES('$id','$n_remark','$now', '$date_end','$date_start') ");

					$update_pig = $db->query("UPDATE pigs SET status = '$status' WHERE id = '$id'");

					if ($insert_query) { ?>
						<script>
							const Toast = Swal.mixin({
								toast: true,
								position: "top-end",
								showConfirmButton: false,
								timer: 2000,
								timerProgressBar: true,
								didOpen: (toast) => {
									toast.onmouseenter = Swal.stopTimer;
									toast.onmouseleave = Swal.resumeTimer;
								}
							});

							Toast.fire({
								icon: "success",
								title: "Pig added to quarantine successfully"
							}).then(() => {
								window.location.href = "manage-pig.php"
							});
						</script>
					<?php
						//  header('refresh: .5');
					} else { ?>
						<div class="alert alert-danger alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Error inserting pig data. Please try again <i class="fa fa-times"></i></strong>
						</div>
				<?php
					}
				}

				?>


				<form role='form' method="post">
					<input type="hidden" name="id" value="<?= $pid ?>">
					<div class="form-group">
						<label class="control-label">Pig No</label>
						<input type="text" name="pigno" readonly="on" class="form-control" value="<?php echo $pigno; ?>">
					</div>

					<div class="form-group">
						<label class="control-label">Breed</label>
						<input type="text" name="breed" readonly="on" class="form-control" value="<?php echo $bname; ?>">
					</div>

					<div class="form-group">
						<label class="control-label">Quarantine Start</label>
						<input type="text" name="date_start" class="form-control datepicker" value="<?= date('Y-m-d') ?>" required>
					</div>

					<div class="form-group">
						<label class="control-label">Quarantine End</label>
						<input type="text" name="date_end" class="form-control datepicker" required>
					</div>

					<div class="form-group">
						<label class="control-label">Reason</label>
						<textarea name="reason" placeholder="Enter reason for quarantine" class="form-control" value=""></textarea>
					</div>

					<button name="submit" type="submit" class="btn btn-sm  btn-default">Add to list</button>
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