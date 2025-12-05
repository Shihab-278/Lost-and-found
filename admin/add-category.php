<?php include "header.php"; ?>

<div id="admin-content" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-6 col-lg-5">
                
                <div class="card shadow-lg border-0 rounded-3">
                    
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <h4 class="fw-bold text-dark m-0"><i class="fa fa-plus-square me-2 text-primary"></i>Add Category</h4>
                        <p class="text-muted small mt-1">Create a new category for your posts.</p>
                    </div>

                    <div class="card-body p-4">
                        
                        <?php 
                            if(isset($_POST['save'])){
                                include 'config.php';

                                $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);

                                // Check if category exists
                                $query = "SELECT category_name FROM category WHERE category_name='{$category_name}'";
                                $result = mysqli_query($connection, $query) or die("Query failed.");

                                $count = mysqli_num_rows($result);
                                
                                if($count > 0){
                                    // Error Alert
                                    echo '<div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4" role="alert">
                                            <i class="fa fa-exclamation-circle me-2"></i> Category <b>"'.$category_name.'"</b> already exists.
                                          </div>';
                                } else {
                                    // Insert Query
                                    $query1 = "INSERT INTO category (category_name) VALUES ('$category_name')";
                                    $result = mysqli_query($connection, $query1) or die("Query Failed.");

                                    if($result){
                                        header("location: category.php");
                                    }
                                }
                            }
                        ?>

                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary small">CATEGORY NAME</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa fa-tag text-muted"></i></span>
                                    <input type="text" name="category_name" class="form-control border-start-0 ps-0" placeholder="e.g. Electronics, ID Cards" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <input type="submit" name="save" class="btn btn-primary rounded-pill fw-bold py-2 shadow-sm" value="Create Category" />
                                <a href="category.php" class="btn btn-outline-secondary rounded-pill fw-bold py-2 border-0">Cancel</a>
                            </div>
                            
                        </form>
                        </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include "footer.php"; ?>