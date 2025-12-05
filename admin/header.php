<?php 
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    //  Redirect to login if not logged in
    if(!isset($_SESSION['username'])){
        header("location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin Panel | UITS Lost & Found</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">
        
        <style>
            /* Specific Admin Navbar Overrides for Dark Theme */
            .navbar-admin {
                background: linear-gradient(90deg, #1f2327 0%, #2c3e50 100%);
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }
            .navbar-admin .navbar-brand {
                font-weight: 700;
                letter-spacing: 1px;
                font-size: 1.25rem;
                color: #fff;
            }
            .navbar-admin .nav-link {
                color: rgba(255,255,255,0.75) !important;
                font-weight: 500;
                padding: 10px 15px;
                transition: all 0.2s;
                border-radius: 5px;
                margin: 0 2px;
            }
            .navbar-admin .nav-link:hover, 
            .navbar-admin .nav-link.active {
                color: #fff !important;
                background-color: rgba(255,255,255,0.15);
            }
            /* User Dropdown Button Style */
            .user-dropdown-toggle {
                background: rgba(255,255,255,0.1);
                padding: 6px 15px;
                border-radius: 50px;
                color: white !important;
                border: 1px solid rgba(255,255,255,0.1);
            }
            .user-dropdown-toggle:hover {
                background: rgba(255,255,255,0.2);
            }
            /* Main Content Wrapper padding */
            #admin-content {
                min-height: calc(100vh - 160px); /* Pushes footer down */
            }
        </style>
    </head>
    <body class="bg-light d-flex flex-column min-vh-100">
        
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark navbar-admin sticky-top">
                <div class="container">
                    
                    <a class="navbar-brand d-flex align-items-center" href="post.php">
                        <img src="images/UITS.png" alt="UITS" width="40" height="40" class="d-inline-block align-text-top me-2" style="object-fit: contain;">
                        <span>ADMIN PANEL</span>
                    </a>

                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="adminNavbar">
                        
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'post.php' ? 'active' : ''; ?>" href="post.php">
                                    <i class="fa fa-file-text me-1"></i> Posts
                                </a>
                            </li>

                            <?php 
                            // Only show Category and Users to Admin (Role 1)
                            if($_SESSION['user_role'] == '1'){ ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'category.php' ? 'active' : ''; ?>" href="category.php">
                                    <i class="fa fa-tags me-1"></i> Categories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>" href="users.php">
                                    <i class="fa fa-users me-1"></i> Users
                                </a>
                            </li>
                            <?php } ?>
                        </ul>

                        <div class="d-flex align-items-center mt-3 mt-lg-0">
                            <a href="../index.php" target="_blank" class="btn btn-outline-light btn-sm me-3 rounded-pill d-none d-lg-block" title="View Front End">
                                <i class="fa fa-external-link-alt"></i> Website
                            </a>

                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle user-dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user-circle me-1"></i> <?php echo strtoupper($_SESSION['username']); ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                                    <li><h6 class="dropdown-header">Logged in as <?php echo ($_SESSION['user_role'] == 1) ? 'Admin' : 'User'; ?></h6></li>
                                    <li><a class="dropdown-item" href="../index.php" target="_blank"><i class="fa fa-globe me-2 text-primary"></i>Visit Website</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger fw-bold" href="logout.php"><i class="fa fa-sign-out-alt me-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </nav>
        </header>
        ```