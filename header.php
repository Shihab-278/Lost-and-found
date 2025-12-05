<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UITS Lost and Found</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="sticky-top shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="images/UITS.png" alt="UITS" class="me-2">
                <div class="brand-text">
                    <div class="fw-bold fs-5">Lost & Found</div>
                    <small class="text-muted text-uppercase" style="font-size:10px; letter-spacing: 1px;">UITS Campus</small>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="index.php">Home</a>
                    </li>
                    
                    <?php
                        // Check if config is already included to avoid errors
                        if(!defined('DB_SERVER')){
                            include 'admin/config.php';
                        }
                        
                        $cat_id_req = isset($_GET['cid']) ? (int)$_GET['cid'] : 0;
                        
                        // Ensure connection exists before querying
                        if(isset($connection)){
                            $cat_q = "SELECT * FROM category WHERE post > 0 ORDER BY category_name ASC";
                            $cat_res = mysqli_query($connection, $cat_q);
                        }
                    ?>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3 <?php echo $cat_id_req ? 'active' : '';?>" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu shadow border-0" aria-labelledby="categoriesDropdown">
                            <?php 
                            if(isset($cat_res) && mysqli_num_rows($cat_res) > 0) {
                                while($cat = mysqli_fetch_assoc($cat_res)) { 
                                    $active = ($cat_id_req === (int)$cat['category_id']) ? 'active' : '';
                                    echo "<li><a class=\"dropdown-item $active\" href=\"category.php?cid={$cat['category_id']}\"><i class='fa fa-tag me-2 text-muted'></i>{$cat['category_name']}</a></li>";
                                } 
                            } else {
                                echo "<li><a class='dropdown-item disabled' href='#'>No categories</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                </ul>

                <form class="d-flex mx-lg-3 my-2 my-lg-0 position-relative" role="search" action="search.php" method="GET" onsubmit="return submitSearchFromInput(event,this)">
                    <div class="input-group search-group" style="min-width:260px;">
                        <input id="header-search" class="form-control live-search ps-3" type="search" name="search" placeholder="Search for items..." aria-label="Search" autocomplete="off">
                        <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                    <ul class="list-group position-absolute w-100 shadow rounded-3 overflow-hidden" id="header-search-suggestions" style="top:110%; left:0; z-index:1050; display:none;"></ul>
                </form>

                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    <a href="admin/add-post.php" class="btn btn-post-item me-2">
                        <i class="fa fa-plus-circle me-1"></i> Post Item
                    </a>
                    <a href="admin/index.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3 border-0" title="Admin Login">
                        <i class="fa fa-user-shield"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>