<?php 
include 'setting/system.php';
include 'theme/head.php'; 

if (isset($_POST['remove'])) {
    if (!empty($_POST['selector'])) {
        $ids = $_POST['selector'];
        $status = 1;
        $success = true;

        try {
            // Use prepared statements for better security
            $checkStmt = $db->prepare("SELECT p.id, p.pigno FROM quarantine q INNER JOIN pigs p ON q.pig_no = p.id WHERE q.id = :id");
            $updatePigStmt = $db->prepare("UPDATE pigs SET status = :status WHERE id = :pig_id");
            $deleteQuarantineStmt = $db->prepare("DELETE FROM quarantine WHERE id = :id");

            foreach ($ids as $id) {
                // Fetch pig details
                $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
                $checkStmt->execute();
                $row = $checkStmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    // Update pig status
                    $updatePigStmt->bindParam(':status', $status, PDO::PARAM_INT);
                    $updatePigStmt->bindParam(':pig_id', $row['id'], PDO::PARAM_INT);
                    $updateSuccess = $updatePigStmt->execute();

                    // Delete from quarantine
                    $deleteQuarantineStmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $deleteSuccess = $deleteQuarantineStmt->execute();

                    if (!$updateSuccess || !$deleteSuccess) {
                        $success = false;
                        error_log("Failed to process quarantine removal for ID: $id");
                    }
                }
            }

            if ($success) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Pigs Removed from Quarantine',
                        text: 'Successfully removed selected pigs from quarantine list.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'manage_quarantine.php';
                        }
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Removal Failed',
                        text: 'Some pigs could not be removed from quarantine.',
                        showConfirmButton: true
                    });
                </script>";
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Database Error',
                    text: 'An error occurred while processing your request.',
                    showConfirmButton: true
                });
            </script>";
        }
    } else {
        // No items selected
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one pig to remove from quarantine.',
                showConfirmButton: true
            });
        </script>";
    }
}
?>
