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
              window.location.href = "index.php"
            });
            })
        </script>
    <?php
        session_destroy();
        
    }
  ?>
    
    <footer class="container py-3">
      <p class="text-center dont-print" style="margin-top: 5%">
        &copy; All Rights Reserved Chad Rhino Quijano 2024
      </p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>