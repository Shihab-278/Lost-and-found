<?php include "header.php"; ?>

<div id="admin-content" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-8 col-lg-6">
                
                <div class="card shadow-lg border-0 rounded-3">
                    
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <h4 class="fw-bold text-dark m-0"><i class="fa fa-user-plus me-2 text-primary"></i>Add New User</h4>
                        <p class="text-muted small mt-1">Create a new account for an admin or moderator.</p>
                    </div>

                    <div class="card-body p-4">
                        
                        <?php 
                            if(isset($_POST['submit'])){
                                include 'config.php';

                                $fname = mysqli_real_escape_string($connection, $_POST['fname']);
                                $lname = mysqli_real_escape_string($connection, $_POST['lname']);
                                $user = mysqli_real_escape_string($connection, $_POST['user']);
                                $password = mysqli_real_escape_string($connection, $_POST['password']); // Hint: Consider using password_hash() here in future
                                $role = mysqli_real_escape_string($connection, $_POST['role']);

                                $query = "SELECT username FROM user WHERE username='$user'";
                                $result = mysqli_query($connection, $query) or die("Query failed.");

                                $count = mysqli_num_rows($result);
                                
                                if($count > 0){
                                    echo '<div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4" role="alert">
                                            <i class="fa fa-exclamation-circle me-2"></i> Username <b>"'.$user.'"</b> already exists.
                                          </div>';
                                } else {
                                    $query1 = "INSERT INTO user (first_name,last_name,username,password,role) 
                                               VALUES ('$fname','$lname','$user','$password','$role')";
                                    $result = mysqli_query($connection, $query1) or die("Query Failed.");

                                    if($result){
                                        header("location: users.php");
                                    }
                                }
                            }
                        ?>

                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                            
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-bold text-secondary small">FIRST NAME</label>
                                    <input type="text" name="fname" class="form-control" placeholder="e.g. John" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-secondary small">LAST NAME</label>
                                    <input type="text" name="lname" class="form-control" placeholder="e.g. Doe" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary small">USERNAME</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-user text-muted"></i></span>
                                    <input type="text" name="user" class="form-control" placeholder="Choose a unique username" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary small">PASSWORD</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-lock text-muted"></i></span>
                                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Set a strong password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fa fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary small">USER ROLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-id-badge text-muted"></i></span>
                                    <select class="form-select" name="role" required>
                                        <option value="0">Moderator (Can only manage own posts)</option>
                                        <option value="1">Admin (Full Access)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2">
                                <a href="users.php" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">Cancel</a>
                                <button type="submit" name="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                    <i class="fa fa-check me-1"></i> Add User
                                </button>
                            </div>

                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#passwordInput');
    const icon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        if(type === 'text'){
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
</script>

<?php include "footer.php"; ?>