<?php 
    include 'config.php';
    session_start();

    if($_SESSION['user_role'] == '0'){
        header("location: post.php");
        exit();
    }

//Get ID and cast to Integer
    $rcv_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    //  Delete Query
    $query = "DELETE FROM category WHERE category_id = {$rcv_id}";

    if(mysqli_query($connection, $query)){
        // Redirect back to list
        header("location: category.php");
    } else {
        //  Show a nice error page instead of plain text
        include 'header.php';
?>

<div id="admin-content" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body text-center p-5">
                        <i class="fa fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                        <h3 class="fw-bold text-dark">Error Deleting Category</h3>
                        <p class="text-muted">
                            The category could not be deleted. It might be in use by existing posts, or there was a database error.
                        </p>
                        <div class="alert alert-light border small text-start">
                            <strong>Debug Info:</strong> <?php echo mysqli_error($connection); ?>
                        </div>
                        <a href="category.php" class="btn btn-primary rounded-pill px-4 fw-bold">
                            <i class="fa fa-arrow-left me-1"></i> Back to Categories
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
        include 'footer.php';
    }

    mysqli_close($connection);
?>