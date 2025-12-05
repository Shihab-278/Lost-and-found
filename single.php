<?php include 'header.php'; ?>

<div id="main-content" class="bg-light py-5">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-md-12 mb-4">

                <?php
                include "admin/config.php";

                // Cast to integer to prevent SQL Injection
                $post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

                $query = "SELECT post.post_id, post.title, post.description, post.post_img, post.post_date, post.category, category.category_name, user.username, post.author 
                            FROM post
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                            WHERE post.post_id = {$post_id}";

                $result = mysqli_query($connection, $query) or die("Query Failed");

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>

                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">

                            <div class="bg-dark text-center" style="max-height: 500px; overflow: hidden;">
                                <img src="admin/upload/<?php echo $row['post_img']; ?>"
                                    class="img-fluid w-100"
                                    alt="<?php echo $row['title']; ?>"
                                    style="object-fit: contain; max-height: 500px; backdrop-filter: blur(10px);">
                            </div>

                            <div class="card-body p-4 p-lg-5">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0 small bg-transparent p-0">
                                            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Home</a></li>
                                            <li class="breadcrumb-item"><a href="category.php?cid=<?php echo $row['category']; ?>" class="text-decoration-none"><?php echo $row['category_name']; ?></a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Item Details</li>
                                        </ol>
                                    </nav>
                                    <span class="badge bg-primary rounded-pill px-3 py-2"><?php echo $row['category_name']; ?></span>
                                </div>

                                <h1 class="fw-bold mb-3 text-dark display-6"><?php echo $row['title']; ?></h1>

                                <div class="d-flex align-items-center mb-4 text-muted small border-bottom pb-3">
                                    <div class="me-4">
                                        <i class="fa fa-user-circle fa-lg me-2 text-primary"></i>
                                        Posted by <a href="author.php?author_id=<?php echo $row['author']; ?>" class="fw-bold text-dark text-decoration-none"><?php echo $row['username']; ?></a>
                                    </div>
                                    <div>
                                        <i class="fa fa-calendar-alt fa-lg me-2 text-primary"></i>
                                        <?php echo date('F d, Y', strtotime($row['post_date'])); ?>
                                    </div>
                                </div>

                                <div class="post-description mb-5">
                                    <h5 class="fw-bold text-dark mb-3">Description</h5>
                                    <p class="lead text-secondary" style="font-size: 1.1rem; line-height: 1.8;">
                                        <?php
                                        // Converts new lines in DB to HTML line breaks
                                        echo nl2br($row['description']);
                                        ?>
                                    </p>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="author.php?author_id=<?php echo $row['author']; ?>" class="btn btn-primary px-4 rounded-pill fw-bold">
                                        <i class="fa fa-envelope me-2"></i> Contact Author
                                    </a>
                                    <a href="index.php" class="btn btn-outline-secondary px-4 rounded-pill fw-bold">
                                        <i class="fa fa-arrow-left me-2"></i> Back to Home
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php
                    } // end while
                } else {
                    ?>
                    <div class="alert alert-danger text-center p-5 shadow-sm rounded-3">
                        <i class="fa fa-exclamation-triangle fa-3x mb-3 opacity-50"></i>
                        <h3>Item Not Found</h3>
                        <p>The item you are looking for has been removed or does not exist.</p>
                        <a href="index.php" class="btn btn-primary mt-3 rounded-pill">Go Back Home</a>
                    </div>
                <?php
                }
                ?>

            </div>

            <?php include 'sidebar.php'; ?>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>