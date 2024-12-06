<?php
include 'setting/system.php';
include 'theme/head.php'; 

if (isset($_POST['remove'])) {
	if (!empty($_POST['selector'])) {
		$id = $_POST['selector'];
		$N = count($id);
		$status = 1;
		for ($i = 0; $i < $N; $i++) {
			$check = $db->query("SELECT p.id,p.pigno FROM sold s INNER JOIN pigs p ON s.pig_id = p.id WHERE s.id = '$id[$i]'");
			$row = $check->fetch(PDO::FETCH_ASSOC);
			$update_pig = $db->query("UPDATE pigs SET status = '$status' WHERE id = " . $row['id'] . "");

			if ($update_pig) {
				$query = $db->query("DELETE FROM sold where id ='$id[$i]'");
			}
		}
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
				title: "Pig removed from sold successfully"
			}).then(() => {
				window.location.href = "manage-sold.php"
			})
		</script>
		<?php 
		// header("location: manage-sold.php");
	}else{
		header("location: manage-sold.php");
	}
}
