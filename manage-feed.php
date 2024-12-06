<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>
<?php
if (isset($_POST['submit'])) {
	$name = $_POST['feed'];
	$stock = $_POST['stock'];
	$brand = $_POST['brand'];
	$kilo = $_POST['kilo'];

	if (!empty($name) && !empty($stock)) {

		$check_feed = $db->query("SELECT * FROM feed WHERE name = '$name'");

		if ($check_feed->rowCount() > 0) {
			$get_data = $check_feed->fetch(PDO::FETCH_OBJ);
			$old_stock = $get_data->stock + (int)$stock;
			$query = $db->query("UPDATE feed SET stock = '$old_stock' ,brand = '$brand', kilo='$kilo' WHERE name = '$name'");
		}else{
			$query = $db->query("INSERT INTO feed(name,stock,brand,kilo)VALUES('$name', '$stock','$brand','$kilo')");
		}


		if ($query) { ?>
			<!-- <script>
				alert('Feed Added. Click OK to close dialogue.')
			</script> -->
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
					title: "Feed added successfully"
				});
			</script>
		<?php
			// header('refresh: 1.5');
		}
	}
}

if (isset($_POST['update'])) {
	$name = $_POST['feed'];
	$brand = $_POST['brand'];
	$stock = $_POST['stock'];
	$id = $_POST['id'];
	$kilo = $_POST['kilo'];

	if (!empty($name) && !empty($stock) && !empty($brand)) {
		$query = $db->query("UPDATE feed SET name = '$name', stock = '$stock', brand = '$brand',kilo='$kilo' WHERE id = '$id'");

		if ($query) {
		?>
			<!-- <script>
				alert('Feed updated successfully. Click OK to close dialogue.')
			</script> -->
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
					title: "Feed updated successfully"
				}).then(() => {
					window.location.href = "manage-feed.php"
				});
			</script>
		<?php
			header('refresh: 1.5; url=manage-feed.php');
		}
	}
}

if (isset($_GET['delete'])) {
	$id = $_GET['id'];

	$query = $db->query("DELETE FROM feed WHERE id = '$id'");

	if ($query) {
		?>
		<!-- <script>
				alert('Feed deleted successfully. Click OK to close dialogue.')
			</script> -->
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
				title: "Feed deleted successfully"
			}).then(() => {
				window.location.href = "manage-feed.php"
			});
		</script>
<?php
		// header('refresh: 1.5: url=manage-vitamins.php');
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
			<h2>Pig Feeds</h2>
			<div class="col-md-12">
				<a title="Check to delete from list" data-toggle="modal" data-target="#_removefeed" id="delete" class="btn btn-danger"><i class="fa fa-trash"></i>
				</a>
				<form method="post" action="delete_feed.php">
					<table class="table table-hover table-bordered" id="table">
						<thead>
							<tr>
								<th></th>
								<th>ID</th>
								<th>Name</th>
								<th>Brand</th>
								<th>Kilo</th>
								<th>Stock</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php

							$get = $db->query("SELECT * FROM feed");
							$res = $get->fetchAll(PDO::FETCH_OBJ);
							foreach ($res as $n) { ?>
								<tr>
									<td>
										<input type="checkbox" name="selector[]" value="<?php echo $n->id ?>">
									</td>
									<td> <?php echo $n->id; ?> </td>
									<td> <?php echo $n->name; ?> </td>
									<td> <?php echo $n->brand; ?> </td>
									<td> <?php echo $n->kilo; ?> </td>
									<td> <?php echo $n->stock; ?> </td>
									<td class="dropdown">
										<button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i> Option
											<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>
												<a href="?edit&id=<?php echo $n->id ?>"><i class="fa fa-edit"></i> Edit</a>
											</li>
											<li>
												<a onclick="return showDelete(<?= $n->id ?>)" href="#"><i class="fa fa-trash"></i> Delete</a>
											</li>
										</ul>
									</td>
								</tr>
							<?php }

							?>
						</tbody>
					</table>

					<div id="_removefeed" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">

							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									<h3 class="modal-title">Remove From Feeds List ?</h3>
								</div>

								<div class="modal-body">
									<div class="alert alert-danger">
										<p>Are you sure you want to remove this from feed list?.</p>
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Close</button>
									<button type="submit" name="removed" class="btn btn-danger"><i class="fa fa-check"></i> Yes</button>
								</div>
							</div>
						</div>
					</div>
					<?php #include('inc/modal-delete.php'); 
					?>
				</form>
			</div>

			<?php
			$title = "Add New Feed";
			$name = "";
			$brand = "";
			$stock = null;
			$button_name = "submit";
			$id = "";
			$kilo = "";
			if (isset($_GET['edit'])) {
				$id = $_GET['id'];
				$get = $db->query("SELECT * FROM feed WHERE id = '$id'");
				$res = $get->fetch(PDO::FETCH_OBJ);
				$title = "Edit Feed";
				$name = $res->name;
				$brand = $res->brand;
				$stock = $res->stock;
				$kilo = $res->kilo;
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
								<label class="control-label">Feed Name</label>
								<input type="text" name="feed" class="form-control" placeholder="Enter feed name" value="<?= $name ?>">

								<label class="control-label">Feed Brand</label>
								<input type="text" name="brand" class="form-control" placeholder="Enter feed name" value="<?= $brand ?>">

								<label class="control-label">Feed Kilograms</label>
								<input type="text" name="kilo" class="form-control" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" placeholder="0.0" value="<?= $kilo ?>">

								<label class="control-label">Feed Stock</label>
								<input type="number" name="stock" class="form-control" min="0" onkeyup="validateMin()" value="<?= $stock ?? 1 ?>">

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
			title: "Do you want to delete this to feed?",
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

	function validateMin(){
		let input = document.querySelector("input[name='stock']");
		if (input.value <= -1) {
			input.value = 0;
		}
	}
</script>

<?php include 'theme/foot.php'; ?>