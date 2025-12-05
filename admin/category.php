<?php include "header.php"; 

// Access Control: Only Admin (Role 1) can view this page
if($_SESSION['user_role'] == '0'){
  header("location: post.php");
}

?>

<div id="admin-content" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <h4 class="m-0 fw-bold text-dark"><i class="fa fa-list-alt me-2 text-primary"></i>All Categories</h4>
                        <a class="btn btn-primary rounded-pill px-4 fw-bold" href="add-category.php">
                            <i class="fa fa-plus-circle me-1"></i> Add Category
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">

                            <?php 
                                include "config.php";

                                $limit = 5; // Increased limit for better view

                                if(isset($_GET['page'])){
                                    $page_number = (int)$_GET['page'];
                                }else{
                                    $page_number = 1;
                                }
                                
                                $offset = ($page_number - 1) * $limit;

                                $query = "SELECT * FROM category ORDER BY category_id DESC LIMIT {$offset}, {$limit}";
                                $result = mysqli_query($connection, $query) or die("Failed");
                                $count = mysqli_num_rows($result);

                                if($count > 0){
                            ?>

                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="py-3 ps-4">#</th>
                                        <th class="py-3">Category Name</th>
                                        <th class="py-3 text-center">No. of Posts</th>
                                        <th class="py-3 text-center">Edit</th>
                                        <th class="py-3 text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        // Logic to make serial number continuous across pages
                                        $serial_number = $offset + 1;
                                        while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary"><?php echo $serial_number++ ?></td>
                                        
                                        <td class="fw-bold text-dark">
                                            <?php echo strtoupper($row['category_name']); ?>
                                        </td>
                                        
                                        <td class="text-center">
                                            <span class="badge bg-secondary rounded-pill"><?php echo $row['post'] ?></span>
                                        </td>

                                        <td class="text-center">
                                            <a href='update-category.php?id=<?php echo $row['category_id'] ?>' class="btn btn-sm btn-warning text-dark shadow-sm" title="Edit">
                                                <i class='fa fa-edit'></i>
                                            </a>
                                        </td>

                                        <td class="text-center">
                                            <a onclick="return confirm('Are you sure you want to delete this category?')" href='delete-category.php?id=<?php echo $row['category_id'] ?>' class="btn btn-sm btn-danger shadow-sm" title="Delete">
                                                <i class='fa fa-trash-o'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                                <div class="text-center py-5">
                                    <i class="fa fa-tags fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Categories Found</h5>
                                    <a href="add-category.php" class="btn btn-outline-primary btn-sm mt-2">Create New Category</a>
                                </div>
                            <?php } ?>
                        
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top-0 py-3">
                        <?php 
                            $query2 = "SELECT * FROM category";
                            $result2 = mysqli_query($connection, $query2) or die("Failed.");
                            
                            if(mysqli_num_rows($result2) > 0){
                                $total_records = mysqli_num_rows($result2);
                                $total_page = ceil($total_records / $limit);

                                if($total_page > 1){
                                    echo "<nav aria-label='Page navigation'><ul class='pagination justify-content-center mb-0'>";
                                    
                                    if($page_number > 1){
                                        echo '<li class="page-item"><a class="page-link shadow-sm mx-1 rounded-circle" href="category.php?page='.($page_number-1).'"><i class="fa fa-chevron-left"></i></a></li>';
                                    }
                                    
                                    for($i = 1; $i <= $total_page; $i++){
                                        $active = ($i == $page_number) ? "active bg-primary border-primary" : "";
                                        echo '<li class="page-item"><a class="page-link shadow-sm mx-1 rounded-circle '.$active.'" href="category.php?page='.$i.'">'.$i.'</a></li>';
                                    }
                                    
                                    if($total_page > $page_number){
                                        echo '<li class="page-item"><a class="page-link shadow-sm mx-1 rounded-circle" href="category.php?page='.($page_number+1).'"><i class="fa fa-chevron-right"></i></a></li>';
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