<style>
  .card {
    background: #fff;
    box-shadow: 1px 1px 20px 1px rgba(0, 0, 0, 0.2);
  }

  .card .card-body {
    padding: 10px;
  }

  .card .card-body h4 {
    font-weight: bold;
  }

  .card .card-body .d-flex {
    display: flex;
    gap: 10px;
  }

  .card .card-img-top {
    height: 250px;
  }

  .card .card-img-top img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    object-position: center;
  }
</style>

<?php require __DIR__ . '../../navbar.php'; ?>

<div class="d-flex align-items-center justify-content-center" style="height: calc(100vh - 60px); background: linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.3)),url(./users/pages/images/piggery.jpg); background-size: cover; background-position: center;">

  <div class="container">
        <div class="text-center">
            <h1 class="text-light">JSV Piggery</h1>
            <p class="text-light">Piggery where you can find best quality pigs.</p>
            <a href="<?= isset($_SESSION['USER_ID']) ? 'index.php?page=home' : 'login.php' ?>" class="btn btn-light">Buy Now</a>
        </div>
  </div>

</div>

<?php 
    if (isset($_GET['logout'])) {
      ?>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
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
                title: "Account logged out successfully"
            }).then(()=>{
              window.location.href = "login.php"
            });
            })
        </script>
    <?php
        session_destroy();
        
    }
  ?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>