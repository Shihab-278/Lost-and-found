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
                        <h4 class="m-0 fw-bold text-dark"><i class="fa fa-users me-2 text-primary"></i>All Users</h4>
                        <a class="btn btn-primary rounded-pill px-4 fw-bold" href="add-user.php">
                            <i class="fa fa-user-plus me-1"></i> Add User
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

                                $query = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset}, {$limit}";
                                $result = mysqli_query($connection, $query) or die("Failed");
                                $count = mysqli_num_rows($result);

                                if($count > 0){
                            ?>

                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="py-3 ps-4">ID</th>
                                        <th class="py-3">Full Name</th>
                                        <th class="py-3">Username</th>
                                        <th class="py-3 text-center">Role</th>
                                        <th class="py-3 text-center">Edit</th>
                                        <th class="py-3 text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary">#<?php echo $row['user_id'] ?></td>
                                        
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                    <i class="fa fa-user text-secondary"></i>
                                                </div>
                                                <span class="fw-semibold text-dark"><?php echo $row['first_name']." ".$row['last_name'] ?></span>
                                            </div>
                                        </td>
                                        
                                        <td class="text-muted">
                                            @<?php echo $row['username'] ?>
                                        </td>
                                        
                                        <td class="text-center">
                                            <?php 
                                                if($row['role'] == 1){
                                                    echo '<span class="badge bg-success rounded-pill px-3">Admin</span>';
                                                }else{
                                                    echo '<span class="badge bg-secondary rounded-pill px-3">Moderator</span>';
                                                }
                                            ?>
                                        </td>

                                        <td class="text-center">
                                            <a href='update-user.php?id=<?php echo $row['user_id'] ?>' class="btn btn-sm btn-warning text-dark shadow-sm" title="Edit User">
                                                <i class='fa fa-edit'></i>
                                            </a>
                                        </td>

                                        <td class="text-center">
                                            <a onclick="return confirm('Are you sure you want to delete this user?')" href='delete-user.php?id=<?php echo $row['user_id'] ?>' class="btn btn-sm btn-danger shadow-sm" title="Delete User">
                                                <i class='fa fa-trash-o'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                                <div class="text-center py-5">
                                    <i class="fa fa-users fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Users Found</h5>
                                    <a href="add-user.php" class="btn btn-outline-primary btn-sm mt-2">Create New User</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top-0 py-3">
                        <?php 
                            $query2 = "SELECT * FROM user";
                            $result2 = mysqli_query($connection, $query2) or die("Failed.");
                            
                            if(mysqli_num_rows($result2) > 0){
                                $total_records = mysqli_num_rows($result2);
                                $total_page = ceil($total_records / $limit);

                                if($total_page > 1){
                                    echo "<nav aria-label='Page navigation'><ul class='pagination justify-content-center mb-0'>";
                                    
                                    if($page_number > 1){
                                        echo '<li class="page-item"><a class="page-link shadow-sm mx-1 rounded-circle" href="users.php?page='.($page_number-1).'"><i class="fa fa-chevron-left"></i></a></li>';
                                    }
                                    
                                    for($i = 1; $i <= $total_page; $i++){
                                        $active = ($i == $page_number) ? "active bg-primary border-primary" : "";
                                        echo '<li class="page-item"><a class="page-link shadow-sm mx-1 rounded-circle '.$active.'" href="users.php?page='.$i.'">'.$i.'</a></li>';
                                    }
                                    
                                    if($total_page > $page_number){
                                        echo '<li class="page-item"><a class="page-link shadow-sm mx-1 rounded-circle" href="users.php?page='.($page_number+1).'"><i class="fa fa-chevron-right"></i></a></li>';
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