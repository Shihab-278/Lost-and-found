<?php include "header.php"; ?>

<div id="admin-content" class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <h4 class="m-0 fw-bold text-dark"><i class="fa fa-file-text me-2 text-primary"></i>All Posts</h4>
                        <a class="btn btn-primary rounded-pill px-4 fw-bold" href="add-post.php">
                            <i class="fa fa-plus-circle me-1"></i> Add Post
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            
                            <?php 
                                include "config.php";
                                $limit = 5; // Increased limit slightly for better view

                                if(isset($_GET['page'])){
                                    $page_number = (int)$_GET['page'];
                                }else{
                                    $page_number = 1;
                                }
                                
                                $offset = ($page_number - 1) * $limit;

                                // Logic: Admin sees all, User sees own
                                if($_SESSION['user_role'] == '1'){
                                    $query = "SELECT post.post_id, post.title, post.description, post.post_img, post.post_date, post.category, category.category_name, user.username 
                                              FROM post
                                              LEFT JOIN category ON post.category = category.category_id
                                              LEFT JOIN user ON post.author = user.user_id
                                              ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                                } elseif ($_SESSION['user_role'] == '0') {
                                    $query = "SELECT post.post_id, post.title, post.description, post.post_img, post.post_date, post.category, category.category_name, user.username 
                                              FROM post
                                              LEFT JOIN category ON post.category = category.category_id
                                              LEFT JOIN user ON post.author = user.user_id
                                              WHERE post.author = {$_SESSION['user_id']}
                                              ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                                }

                                $result = mysqli_query($connection, $query) or die("Query Failed.");
                                $count = mysqli_num_rows($result);

                                if($count > 0){
                            ?>
                            
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="py-3 ps-3">#</th>
                                        <th class="py-3">Image</th>
                                        <th class="py-3">Title</th>
                                        <th class="py-3">Category</th>
                                        <th class="py-3">Date</th>
                                        <th class="py-3">Author</th>
                                        <th class="text-center py-3">Edit</th>
                                        <th class="text-center py-3">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $serial_number = $offset + 1;
                                        while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    <tr>
                                        <td class="ps-3 fw-bold text-secondary"><?php echo $serial_number++ ?></td>
                                        
                                        <td>
                                            <img class="img-thumbnail rounded shadow-sm" src="upload/<?php echo $row['post_img'] ?>" style="width: 60px; height: 60px; object-fit: cover;">
                                        </td>
                                        
                                        <td style="min-width: 200px;">
                                            <h6 class="mb-0 text-dark fw-bold"><?php echo substr($row['title'], 0, 40) . (strlen($row['title']) > 40 ? '...' : ''); ?></h6>
                                        </td>
                                        
                                        <td>
                                            <span class="badge bg-secondary text-white"><?php echo $row['category_name'] ?></span>
                                        </td>
                                        
                                        <td>
                                            <small class="text-muted"><i class="fa fa-clock-o me-1"></i><?php echo $row['post_date'] ?></small>
                                        </td>
                                        
                                        <td>
                                            <span class="text-dark fw-semibold"><i class="fa fa-user-circle me-1 text-secondary"></i><?php echo $row['username'] ?></span>
                                        </td>

                                        <td class="text-center">
                                            <a href='update-post.php?id=<?php echo $row['post_id'] ?>' class="btn btn-sm btn-warning text-dark shadow-sm" title="Edit">
                                                <i class='fa fa-edit'></i>
                                            </a>
                                        </td>
                                        
                                        <td class="text-center">
                                            <a onclick="return confirm('Are you sure you want to delete this post?')" href='delete-post.php?id=<?php echo $row['post_id'] ?>&catid=<?php echo $row['category'] ?>' class="btn btn-sm btn-danger shadow-sm" title="Delete">
                                                <i class='fa fa-trash-o'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                                <div class="text-center py-5">
                                    <i class="fa fa-folder-open-o fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Posts Found</h5>
                                    <a href="add-post.php" class="btn btn-outline-primary btn-sm mt-2">Create New Post</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-top-0 py-3">
                        <?php 
                            // Pagination Logic Adjusted for Role
                            if($_SESSION['user_role'] == '1'){
                                $query2 = "SELECT * FROM post";
                            } else {
                                $query2 = "SELECT * FROM post WHERE author = {$_SESSION['user_id']}";
                            }
                            
                            $result2 = mysqli_query($connection, $query2) or die("Failed.");
                            
                            if(mysqli_num_rows($result2) > 0){
                                $total_records = mysqli_num_rows($result2);
                                $total_page = ceil($total_records/$limit);

                                if($total_page > 1){
                                    echo "<nav aria-label='Page navigation'><ul class='pagination justify-content-center mb-0'>";
                                    
                                    if($page_number > 1){
                                        echo '<li class="page-item"><a class="page-link shadow-sm mx-1 rounded-circle" href="post.php?page='.($page_number-1).'"><i class="fa fa-chevron-left"></i></a></li>';
                                    }
                                    
                                    for($i = 1; $i <= $total_page; $i++){
                                        $active = ($i == $page_number) ? "active bg-primary border-primary" : "";
                                        echo '<li class="page-item"><a class="page-link shadow-sm mx-1 rounded-circle '.$active.'" href="post.php?page='.$i.'">'.$i.'</a></li>';
                                    }
                                    
                                    if($total_page > $page_number){
                                        echo '<li class="page-item"><a class="page-link shadow-sm mx-1 rounded-circle" href="post.php?page='.($page_number+1).'"><i class="fa fa-chevron-right"></i></a></li>';
                                    }
                                    echo "</ul></nav>";
                                }
                            }
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>