<?php 

if (isset($_GET['cage'])) {
    $id = $_GET['id'];
    $cage = (int)$_GET['cage'];

    $stmt = "UPDATE pigs SET cage_num = $cage WHERE id = $id";
    if ($db->query($stmt)) {
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
                  title: "Pig added to cage <?= $cage ?>"
                }).then(function(){
                  location.reload();
                });
      </script>
        <?php 
    }

}
