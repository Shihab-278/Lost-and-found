<?php include 'header.php'; ?>

<div id="main-content" class="bg-light py-5">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 col-md-12">
                
                <?php 
                    include "admin/config.php";
                    if(isset($_GET['search'])){
                        $search = mysqli_real_escape_string($connection, $_GET['search']);
                     
                        $display_search = htmlspecialchars($_GET['search']);
                ?>
                
                <div class="card border-0 shadow-sm mb-4 p-4 rounded-3 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                            <i class="fa fa-search fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h2 class="mb-0 fw-bold text-dark">Search: "<?php echo $display_search; ?>"</h2>
                            <p class="text-muted mb-0 small">Showing results matching your query</p>
                        </div>
                    </div>
                </div>

                <div class="post-container">
                    <?php 
                        $limit = 5; // Increased to 5 for better layout
                        $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($page_number - 1) * $limit;

                        // Main Search Query
                        $query = "SELECT post.post_id, post.title, post.description, post.post_img, post.post_date, post.category, category.category_name, user.username, post.author 
                                  FROM post
                                  LEFT JOIN category ON post.category = category.category_id
                                  LEFT JOIN user ON post.author = user.user_id 
                                  WHERE post.title LIKE '%{$search}%' OR post.description LIKE '%{$search}%'
                                  ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";

                        $result = mysqli_query($connection, $query) or die("Failed");
                        $count = mysqli_num_rows($result);

                        if($count > 0){
                            while($row = mysqli_fetch_assoc($result)){
                    ?>

                    <div class="card border-0 shadow-sm mb-4 overflow-hidden hover-up transition-all rounded-3">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative">
                                <a href="single.php?id=<?php echo $row['post_id'] ?>" class="h-100 d-block">
                                    <img src="admin/upload/<?php echo $row['post_img'] ?>" class="img-fluid h-100 w-100" alt="<?php echo $row['title']; ?>" style="object-fit: cover; min-height: 200px;">
                                </a>
                                <span class="badge bg-primary position-absolute top-0 start-0 m-2 shadow-sm"><?php echo $row['category_name']; ?></span>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex flex-column p-4">
                                    <h3 class="card-title fw-bold mb-2">
                                        <a href='single.php?id=<?php echo $row['post_id'] ?>' class="text-dark text-decoration-none">
                                            <?php echo $row['title'] ?>
                                        </a>
                                    </h3>
                                    
                                    <div class="mb-3 text-muted small">
                                        <span class="me-3">
                                            <i class="fa fa-tags me-1 text-primary"></i> 
                                            <a href='category.php?cid=<?php echo $row['category'] ?>' class="text-decoration-none text-muted"><?php echo $row['category_name'] ?></a>
                                        </span>
                                        <span class="me-3">
                                            <i class="fa fa-user me-1 text-primary"></i> 
                                            <a href='author.php?author_id=<?php echo $row['author'] ?>' class="text-decoration-none text-muted"><?php echo $row['username'] ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar-alt me-1 text-primary"></i> 
                                            <?php echo $row['post_date'] ?>
                                        </span>
                                    </div>
                                    
                                    <p class="card-text text-secondary mb-4 flex-grow-1">
                                        <?php echo substr($row['description'], 0, 130)."..." ?>
                                    </p>
                                    
                                    <div class="mt-auto">
                                        <a class='btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold' href='single.php?id=<?php echo $row['post_id'] ?>'>
                                            Read More <i class="fa fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <?php 
                            } // End While
                        } else {
                            echo '<div class="alert alert-warning text-center py-5 shadow-sm rounded-3"><i class="fa fa-search-minus fa-3x mb-3 opacity-50"></i><br>No results found for "<b>'.$display_search.'</b>".<br>Try checking your spelling or use different keywords.</div>';
                        }
                    ?>
                </div>

                <?php
                    $query2 = "SELECT * FROM post WHERE post.title LIKE '%{$search}%' OR post.description LIKE '%{$search}%'";
                    $result2 = mysqli_query($connection, $query2) or die("Failed.");
                    
                    if(mysqli_num_rows($result2) > 0){
                        $total_records = mysqli_num_rows($result2);
                        $total_page = ceil($total_records / $limit);
                        
                        if($total_page > 1){
                ?>
                <nav aria-label="Page navigation" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php 
                        if($page_number > 1){
                            echo '<li class="page-item"><a class="page-link shadow-sm mx-1" href="search.php?search='.$search.'&page='.($page_number-1).'"><i class="fa fa-chevron-left"></i></a></li>';
                        }
                        
                        for($i = 1; $i <= $total_page; $i++){
                            $active = ($i == $page_number) ? "active" : "";
                            echo '<li class="page-item '.$active.'"><a class="page-link shadow-sm mx-1" href="search.php?search='.$search.'&page='.$i.'">'.$i.'</a></li>';
                        }
                        
                        if($total_page > $page_number){
                            echo '<li class="page-item"><a class="page-link shadow-sm mx-1" href="search.php?search='.$search.'&page='.($page_number+1).'"><i class="fa fa-chevron-right"></i></a></li>';
                        }
                        ?>
                    </ul>
                </nav>
                <?php 
                        }
                    }
                ?>

                <?php 
                    } else {
                        echo "<div class='alert alert-danger'>No search term provided.</div>";
                    } // End if isset search
                ?>

            </div>
            
            <?php include 'sidebar.php'; ?>
            
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>