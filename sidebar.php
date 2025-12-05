<div id="sidebar" class="col-lg-4 col-md-12">
    <div style="position: sticky; top: 100px;">
        
        <div class="search-box-container bg-white shadow-sm rounded-3 p-4 mb-4 border-0">
            <h5 class="fw-bold mb-3 text-dark border-start border-4 border-primary ps-3">Search Items</h5>
            <form class="search-post position-relative" action="search.php" method="GET" onsubmit="return submitSearchFromInput(event,this)">
                <div class="input-group">
                    <input id="sidebar-search" type="text" name="search" class="form-control bg-light border-0 py-2 ps-3" placeholder="What are you looking for?" autocomplete="off" style="border-radius: 50px 0 0 50px;">
                    <button type="submit" class="btn btn-primary px-3" style="border-radius: 0 50px 50px 0;">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <ul class="list-group position-absolute w-100 mt-2 shadow" id="sidebar-search-suggestions" style="top:100%; z-index:1050; display:none; border-radius: 8px; overflow:hidden;"></ul>
            </form>
        </div>
        
        <div class="recent-post-container bg-white shadow-sm rounded-3 p-4 border-0">
            <h5 class="fw-bold mb-4 text-dark border-start border-4 border-primary ps-3">Recent Items</h5>
            
            <div class="d-flex flex-column gap-3">
            <?php
                include "admin/config.php";
                $limit = 5; 

                $query = "SELECT post.post_id, post.title, post.post_img, post.post_date, post.category, category.category_name 
                          FROM post
                          LEFT JOIN category ON post.category = category.category_id
                          ORDER BY post.post_id DESC 
                          LIMIT {$limit}";

                $result = mysqli_query($connection, $query) or die("Query Failed");
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
            
            <div class="recent-post d-flex align-items-center position-relative pb-3 border-bottom" style="border-color: #f1f3f5 !important;">
                <div class="flex-shrink-0 me-3">
                    <img src="admin/upload/<?php echo $row['post_img']; ?>" alt="<?php echo $row['title']; ?>" 
                         class="rounded-3 shadow-sm object-fit-cover" 
                         style="width: 70px; height: 70px;">
                </div>
                
                <div class="flex-grow-1 min-width-0">
                    <h6 class="mb-1 fw-bold" style="font-size: 15px; line-height: 1.3;">
                        <a href="single.php?id=<?php echo $row['post_id']; ?>" class="text-dark text-decoration-none stretched-link">
                            <?php echo substr($row['title'], 0, 35) . (strlen($row['title']) > 35 ? '...' : ''); ?>
                        </a>
                    </h6>
                    <div class="d-flex align-items-center text-muted small">
                        <span class="badge bg-light text-secondary border me-2 fw-normal" style="font-size: 10px;">
                            <?php echo $row['category_name']; ?>
                        </span>
                        <span style="font-size: 11px;">
                            <i class="fa fa-clock me-1 text-primary opacity-50"></i>
                            <?php echo date('M d, Y', strtotime($row['post_date'])); ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <?php 
                    }
                } else {
                    echo '<div class="text-center text-muted py-3"><i class="fa fa-folder-open mb-2"></i><br>No recent items found.</div>';
                }
            ?>
            </div>
        </div>
        
    </div>
</div>