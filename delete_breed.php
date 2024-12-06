<?php
include 'setting/system.php';
include 'theme/head.php';

if (isset($_POST['removed'])) {
	$id = $_POST['selector'];
	$N = count($id);
	for ($i = 0; $i < $N; $i++) {
		$query = $db->query("DELETE FROM breed where id ='$id[$i]'");
	}
?>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
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
			title: "Breed removed successfully"
		}).then(()=>{
			window.location.href = "manage-breed.php"
		});
	</script>
<?php
	// header("location: manage-breed.php");
}
?>