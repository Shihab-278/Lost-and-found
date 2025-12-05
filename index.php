<?php include 'header.php'; ?>

<section id="hero-section" class="hero-section text-center">
  <div class="container position-relative z-1">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-7">
        <h1 class="fw-bold display-4 mb-3">Lost Something? Found Something?</h1>
        <p class="lead mb-5 opacity-90">The official platform for UITS Campus. Connect with others to return lost belongings.</p>
        
        <div class="hero-search-container">
            <form action="search.php" method="GET" class="d-flex w-100" onsubmit="return submitSearchFromInput(event,this)">
                <div class="input-group border-0">
                    <span class="input-group-text bg-transparent border-0 ps-3"><i class="fa fa-search text-muted"></i></span>
                    <input id="hero-search" type="text" class="form-control border-0 shadow-none form-control-lg fs-6" name="search" placeholder="What are you looking for? (e.g. ID Card, Wallet)" required autocomplete="off">
                    <button class="btn btn-warning rounded-pill px-4 fw-bold m-1" type="submit">Search</button>
                </div>
                <ul class="list-group position-absolute w-100 text-start" id="hero-search-suggestions" style="top:100%; left:0; z-index:1050; display:none; margin-top: 10px; border-radius: 12px; overflow:hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);"></ul>
            </form>
        </div>
        
        <div class="mt-4">
            <span class="text-white-50 small">Popular: </span>
            <a href="category.php?cid=1" class="badge bg-white bg-opacity-25 text-white text-decoration-none fw-normal ms-1">Electronics</a>
            <a href="category.php?cid=2" class="badge bg-white bg-opacity-25 text-white text-decoration-none fw-normal ms-1">Documents</a>
            <a href="category.php?cid=3" class="badge bg-white bg-opacity-25 text-white text-decoration-none fw-normal ms-1">Keys</a>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="main-content" class="bg-light">
  <div class="container py-5">
    <div class="row">
      
      <div class="col-lg-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark m-0"><i class="fa fa-bolt text-warning me-2"></i>Just Reported</h4>
            <span class="badge bg-danger">Urgent</span>
        </div>

        <div class="row gy-4 mb-5">
          <?php
            include "admin/config.php";
            
            //  Get 3 most recent posts as "Featured"
            $feat_q = "SELECT post.post_id, post.title, post.description, post.post_img, post.post_date, post.category, category.category_name, user.username, post.author FROM post
              LEFT JOIN category ON post.category = category.category_id
              LEFT JOIN user ON post.author = user.user_id
              ORDER BY post.post_date DESC LIMIT 3";
            
            $feat_res = mysqli_query($connection, $feat_q);
            $feat_ids = []; 

            if(mysqli_num_rows($feat_res) > 0){
                while($f = mysqli_fetch_assoc($feat_res)){
                    $feat_ids[] = $f['post_id'];
          ?>
            <div class="col-md-12 col-lg-4">
              <div class="card h-100 border-0 shadow-sm hover-up">
                <div class="position-relative">
                    <a href="single.php?id=<?php echo $f['post_id']; ?>">
                        <img src="admin/upload/<?php echo $f['post_img']; ?>" class="card-img-top" alt="<?php echo $f['title']; ?>" style="height:180px; object-fit:cover;">
                    </a>
                    <span class="position-absolute top-0 end-0 m-2 badge bg-primary shadow-sm">
                        <?php echo $f['category_name']; ?>
                    </span>
                </div>
                
                <div class="card-body p-3 d-flex flex-column">
                  <small class="text-muted mb-1" style="font-size: 11px;">
                      <i class="fa fa-calendar-alt me-1"></i><?php echo date('M d', strtotime($f['post_date'])); ?> 
                      &bull; <?php echo $f['username']; ?>
                  </small>
                  <h6 class="card-title fw-bold mb-2">
                      <a href="single.php?id=<?php echo $f['post_id']; ?>" class="text-dark text-decoration-none stretched-link">
                          <?php echo substr($f['title'], 0, 40); ?>
                      </a>
                  </h6>
                </div>
              </div>
            </div>
          <?php 
                } 
            } else {
                echo "<div class='col-12'><p class='text-muted'>No featured items yet.</p></div>";
            }
          ?>
        </div>

        <div class="section-header mb-4">
            <h2>All Lost & Found Items</h2>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4">
          <?php
            //  Pagination + Exclude the 3 items shown above
            $limit = 8;
            $page_number = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $offset = ($page_number - 1) * $limit;
            
            $exclude_sql = "";
            if(!empty($feat_ids)){
                $ids_string = implode(',', $feat_ids);
                $exclude_sql = "WHERE post.post_id NOT IN ($ids_string)";
            }

            $q = "SELECT post.post_id, post.title, post.description, post.post_img, post.post_date, post.category, category.category_name, user.username, post.author FROM post
              LEFT JOIN category ON post.category = category.category_id
              LEFT JOIN user ON post.author = user.user_id
              {$exclude_sql} 
              ORDER BY post.post_date DESC LIMIT {$offset},{$limit}";

            $res = mysqli_query($connection, $q) or die('Query Failed');
            
            if(mysqli_num_rows($res) > 0){
              while($row = mysqli_fetch_assoc($res)){
          ?>
            <div class="col">
              <div class="card h-100 border-0 shadow-sm hover-up transition-all">
                <div class="row g-0 h-100">
                    <div class="col-12 position-relative">
                         <a href="single.php?id=<?php echo $row['post_id']; ?>">
                             <img src="admin/upload/<?php echo $row['post_img']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>" style="height: 220px; object-fit: cover;">
                         </a>
                         <span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-2 shadow-sm">
                            <?php echo $row['category_name']; ?>
                         </span>
                    </div>
                    <div class="col-12">
                        <div class="card-body d-flex flex-column h-100">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="fa fa-clock me-1"></i><?php echo date('M d, Y', strtotime($row['post_date'])); ?></span>
                                <span><i class="fa fa-user me-1"></i><?php echo $row['username']; ?></span>
                            </div>
                            <h5 class="card-title fw-bold mb-2">
                                <a href="single.php?id=<?php echo $row['post_id']; ?>" class="text-dark text-decoration-none">
                                    <?php echo $row['title']; ?>
                                </a>
                            </h5>
                            <p class="card-text text-secondary small flex-grow-1">
                                <?php echo substr($row['description'],0,90); ?>...
                            </p>
                            <a href="single.php?id=<?php echo $row['post_id']; ?>" class="btn btn-outline-primary btn-sm rounded-pill w-100 mt-2 fw-bold">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          <?php 
              }
            } else {
              echo '<div class="col-12"><div class="alert alert-light border shadow-sm text-center py-5"><i class="fa fa-box-open fa-3x text-muted mb-3"></i><br>No more items found.</div></div>';
            }
          ?>
        </div>

        <?php 
            $count_q = "SELECT COUNT(*) as total FROM post";
            $count_res = mysqli_query($connection, $count_q);
            $total_row = mysqli_fetch_assoc($count_res);
            
            $total_records = intval($total_row['total']) - count($feat_ids);
            if($total_records < 0) $total_records = 0;
            
            $total_page = ceil($total_records / $limit);
            
            if($total_page > 1){ 
        ?>
          <nav aria-label="Page navigation" class="mt-5">
            <ul class="pagination justify-content-center">
              <?php if($page_number > 1){ ?>
                <li class="page-item"><a class="page-link shadow-sm" href="index.php?page=<?php echo $page_number-1;?>"><i class="fa fa-chevron-left"></i></a></li>
              <?php }
                for($i=1;$i<=$total_page;$i++){
                  $act = ($i==$page_number) ? 'active' : '';
                  echo "<li class=\"page-item $act\"><a class=\"page-link shadow-sm\" href=\"index.php?page=$i\">$i</a></li>";
                }
                if($page_number < $total_page){ ?>
                <li class="page-item"><a class="page-link shadow-sm" href="index.php?page=<?php echo $page_number+1; ?>"><i class="fa fa-chevron-right"></i></a></li>
              <?php } ?>
            </ul>
          </nav>
        <?php } ?>

      </div>
      
      <?php include 'sidebar.php'; ?>
      
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
<script src="js/main.js"></script>