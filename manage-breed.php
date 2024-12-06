<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>
<?php
if (isset($_POST['submit'])) {
	$name = $_POST['breed'];

	$query = $db->query("INSERT INTO breed(name)VALUES('$name')");

	if ($query) {

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
				title: "Breed added successfully"
			}).then(() => {
				window.location.href = "manage-breed.php"
			});
		</script>
	<?php
		// header('refresh: 1.5');
	}
}
if (isset($_POST['update'])) {
	$name = $_POST['breed'];
	$id = $_POST['id'];

	$query = $db->query("UPDATE breed SET name = '$name' WHERE id = '$id'");

	if ($query) { ?>
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
				title: "Breed updated successfully"
			}).then(() => {
				window.location.href = "manage-breed.php"
			});
		</script>
	<?php
		// header('refresh: 1.5;url=manage-breed.php');
	}
}
if (isset($_GET['delete'])) {
	$id = $_GET['id'];

	$query = $db->query("DELETE FROM breed WHERE id = '$id'");

	if ($query) {
	?>
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
				title: "Breed deleted successfully"
			}).then(() => {
				window.location.href = "manage-breed.php"
			});
		</script>
<?php
		// header('refresh: 1.5;url=manage-breed.php');
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
			<h2>Pig Breeds</h2>
			<div class="col-md-12">
				<a title="Check to delete from list" data-toggle="modal" data-target="#_removed" id="delete" class="btn btn-danger"><i class="fa fa-trash"></i>
				</a>
				<form method="post" action="delete_breed.php">
					<table class="table table-hover table-bordered" id="table">
						<thead>
							<tr>
								<th></th>
								<th>ID</th>
								<th>Name</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php

							$get = $db->query("SELECT * FROM breed");
							$res = $get->fetchAll(PDO::FETCH_OBJ);
							foreach ($res as $n) { ?>
								<tr>
									<td>
										<input type="checkbox" name="selector[]" value="<?php echo $n->id ?>">
									</td>
									<td> <?php echo $n->id; ?> </td>
									<td> <?php echo $n->name; ?> </td>
									<td class="dropdown">
										<button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i> Option
											<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>
												<a href="?edit&id=<?php echo $n->id ?>"><i class="fa fa-edit"></i> Edit</a>
											</li>
											<li>
												<a onclick="return showDelete(<?= $n->id ?>)" style="cursor: pointer;"><i class="fa fa-trash"></i> Delete</a>
											</li>
										</ul>
									</td>
								</tr>
							<?php }

							?>
						</tbody>
					</table>

					<?php #include('inc/modal-delete.php'); 
					?>
					<div id="_removed" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">

							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									<h3 class="modal-title">Remove From breed List?</h3>
								</div>

								<div class="modal-body">
									<div class="alert alert-danger">
										<p>Are you sure you want to remove breed from list?.</p>
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Close</button>
									<button type="submit" name="removed" class="btn btn-danger"><i class="fa fa-check"></i> Yes</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<?php
			$title = "Add New Breed";
			$name = "";
			$button_name = "submit";
			$id = "";
			if (isset($_GET['edit'])) {
				$id = $_GET['id'];
				$get = $db->query("SELECT * FROM breed WHERE id = '$id'");
				$res = $get->fetch(PDO::FETCH_OBJ);
				$title = "Edit Feed";
				$name = $res->name;
				$button_name = "update";
			}

			?>

			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading"><?= $title ?></div>
					<div class="panel-body">
						<form method="post">
							<?php
							if ($id !== null) {
							?>
								<input type="hidden" name="id" value="<?= $id ?>">
							<?php
							}
							?>
							<div class="form-group">
								<label class="control-label">Breed Name</label>
								<input type="text" name="breed" class="form-control" placeholder="Enter breed name" value="<?= $name ?>">
							</div>

							<button class="btn btn-sm btn-default" type="submit" name="<?= $button_name ?>">Submit</button>


						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
	function showDelete(x) {
		Swal.fire({
			title: "Do you want to delete this to pig?",
			showDenyButton: true,
			confirmButtonText: "Yes",
			denyButtonText: `No`
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				window.location.href = "?delete&id=" + x
			}
		});
	}
</script>

<?php include 'theme/foot.php'; ?>