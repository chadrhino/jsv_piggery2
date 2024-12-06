<?php 
include 'setting/system.php';
include 'theme/head.php';

if(isset($_POST['removed'])){
	$id=$_POST['selector'];
    $N = count($id);
	for($i=0; $i < $N; $i++)
	{
		 $query = $db->query("DELETE FROM vitamins where id ='$id[$i]'");
	}
    // header("location: manage-vitamins.php");

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
			title: "Vitamins removed successfully"
		}).then(() => {
			window.location.href = "manage-vitamins.php"
		});
	</script>
<?php
}
?>
