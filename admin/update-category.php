<?php include "header.php"; 

// Access Control: Only Admin
if($_SESSION['user_role'] == '0'){
  header("location: post.php");
  exit();
}

// Handle Form Submission
if(isset($_POST['submit'])){
    include 'config.php';

    $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
    $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);

    $query1 = "UPDATE category SET category_name = '{$category_name}' 
               WHERE category_id = '{$category_id}'";

    $result1 = mysqli_query($connection, $query1) or die("Update Query failed.");
    
    if($result1){
      header("location: category.php");
    }
}
?>

<div id="admin-content" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-6 col-lg-5">
                
                <div class="card shadow-lg border-0 rounded-3">
                    
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <h4 class="fw-bold text-dark m-0"><i class="fa fa-edit me-2 text-primary"></i>Update Category</h4>
                        <p class="text-muted small mt-1">Modify the category name.</p>
                    </div>

                    <div class="card-body p-4">
                        
                        <?php 
                            include "config.php";
                            
                            // Cast ID to integer
                            $category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

                            $query = "SELECT * FROM category WHERE category_id = {$category_id}";
                            $result = mysqli_query($connection, $query) or die("Failed");
                            $count = mysqli_num_rows($result);

                            if($count > 0){
                                while($row = mysqli_fetch_assoc($result)){
                        ?>

                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST" autocomplete="off">
                            
                            <div class="form-group">
                                <input type="hidden" name="category_id" class="form-control" value="<?php echo $row['category_id'] ?>">
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary small">CATEGORY NAME</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa fa-tag text-muted"></i></span>
                                    <input type="text" name="category_name" class="form-control border-start-0 ps-0" value="<?php echo $row['category_name'] ?>" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="submit" class="btn btn-primary rounded-pill fw-bold py-2 shadow-sm">
                                    <i class="fa fa-save me-1"></i> Update
                                </button>
                                <a href="category.php" class="btn btn-outline-secondary rounded-pill fw-bold py-2 border-0">Cancel</a>
                            </div>

                        </form>
                        <?php 
                                } // End While
                            } else {
                                echo '<div class="alert alert-danger text-center">Category not found.</div>';
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>