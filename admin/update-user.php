<?php include "header.php"; 

// Access Control: Only Admin
if($_SESSION['user_role'] == '0'){
  header("location: post.php");
  exit();
}

// Handle Form Submission
if(isset($_POST['submit'])){
    include 'config.php';

    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $fname = mysqli_real_escape_string($connection, $_POST['f_name']);
    $lname = mysqli_real_escape_string($connection, $_POST['l_name']);
    $user = mysqli_real_escape_string($connection, $_POST['username']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);

    $query1 = "UPDATE user SET 
    first_name = '{$fname}', 
    last_name = '{$lname}',
    username = '{$user}',
    role = '{$role}' WHERE user_id = '{$user_id}'";

    $result1 = mysqli_query($connection, $query1) or die("Query failed.");
    if($result1){
      header("location: users.php");
    }
}
?>

<div id="admin-content" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-8 col-lg-6">
                
                <div class="card shadow-lg border-0 rounded-3">
                    
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <h4 class="fw-bold text-dark m-0"><i class="fa fa-user-edit me-2 text-primary"></i>Modify User Details</h4>
                        <p class="text-muted small mt-1">Update account information and permissions.</p>
                    </div>

                    <div class="card-body p-4">

                        <?php 
                            include "config.php";
                            // Cast ID to integer
                            $user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

                            $query = "SELECT * FROM user WHERE user_id = {$user_id}";
                            $result = mysqli_query($connection, $query) or die("Failed");
                            $count = mysqli_num_rows($result);

                            if($count > 0){
                                while($row = mysqli_fetch_assoc($result)){
                        ?>

                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST" autocomplete="off">
                            
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-bold text-secondary small">FIRST NAME</label>
                                    <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary small">LAST NAME</label>
                                    <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'] ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary small">USERNAME</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-user text-muted"></i></span>
                                    <input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary small">USER ROLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-id-badge text-muted"></i></span>
                                    <select class="form-select" name="role">
                                        <option value='0' <?php echo ($row['role'] == 0) ? 'selected' : ''; ?>>Moderator</option>
                                        <option value='1' <?php echo ($row['role'] == 1) ? 'selected' : ''; ?>>Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2">
                                <a href="users.php" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">Cancel</a>
                                <button type="submit" name="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                    <i class="fa fa-save me-1"></i> Update
                                </button>
                            </div>

                        </form>
                        <?php 
                                } // End While
                            } else {
                                echo '<div class="alert alert-danger text-center">User Not Found.</div>';
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>