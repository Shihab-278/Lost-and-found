<?php 
    session_start();
    if(isset($_SESSION['username'])){
        header("location: post.php");
    }
?>

<!doctype html>
<html lang="en">
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login | UITS Lost and Found</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body class="admin-login-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    
                    <div class="card login-card">
                        <div class="login-header">
                            <img src="images/UITS.png" class="brand-logo" alt="UITS Logo">
                            <h4 class="fw-bold text-dark">Admin Panel</h4>
                            <p class="text-muted small">Please login to continue</p>
                        </div>
                        
                        <div class="card-body p-4 pt-2">
                            
                            <?php 
                                if(isset($_POST['login'])){
                                    include "config.php";
                                    $username = mysqli_real_escape_string($connection, $_POST['username']);
                                    $password = $_POST['password']; 

                                    $query = "SELECT user_id, username, role FROM user WHERE username='{$username}' AND password='{$password}'";
                                    $result = mysqli_query($connection, $query) or die("Query Failed.");

                                    if(mysqli_num_rows($result) > 0){
                                        while($row = mysqli_fetch_assoc($result)){
                                            session_start();
                                            $_SESSION['username'] = $row['username'];
                                            $_SESSION['user_id'] = $row['user_id'];
                                            $_SESSION['user_role'] = $row['role'];
                                            header("location: post.php");
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger text-center py-2 fs-6 mb-3" role="alert"><i class="fa fa-exclamation-circle me-1"></i> Invalid Username or Password</div>';
                                    }
                                }
                            ?>

                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="mb-3">
                                    <label class="form-label small text-secondary fw-bold">USERNAME</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-user text-muted"></i></span>
                                        <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label small text-secondary fw-bold">PASSWORD</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-lock text-muted"></i></span>
                                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Enter password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-left:none; border-color:#dee2e6;">
                                            <i class="fa fa-eye-slash small"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <input type="submit" name="login" class="btn btn-primary fw-bold py-2 rounded-pill" value="LOGIN" />
                                </div>
                            </form>
                            
                            <div class="text-center mt-4">
                                <a href="../index.php" class="text-decoration-none text-muted small hover-link">
                                    <i class="fa fa-arrow-left me-1"></i> Back to Website
                                </a>
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

            if(togglePassword && password && icon) {
                togglePassword.addEventListener('click', function (e) {
                    // toggle the type attribute
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    
                    // toggle the icon
                    if(type === 'text'){
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            }
        </script>
    </body>
</html>