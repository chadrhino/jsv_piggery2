<?php include 'setting/system.php'; 
include 'theme/head.php';
?>
<?php

if (!$_GET['id'] or empty($_GET['id'])) {
	header('location: manage-anay.php');
} else {
	$id = (int)$_GET['id'];
	$query = $db->query("DELETE FROM pigs WHERE id = $id ");
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
				title: "Pig removed successfully"
			}).then(() => {
				window.location.href = "manage-anay.php"
			});
		</script>
<?php
		// header('location: manage-pig.php');
	}
}
