<?php include "header.php"; 

// Access Control: Admin check
if($_SESSION['user_role'] == '0'){
  header("location: post.php");
  exit();
}
?>

<div id="admin-content" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-8 col-lg-7">
                
                <div class="card shadow-lg border-0 rounded-3">
                    
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <h4 class="fw-bold text-dark m-0"><i class="fa fa-edit me-2 text-primary"></i>Update Post</h4>
                        <p class="text-muted small mt-1">Edit the details of your existing post.</p>
                    </div>

                    <div class="card-body p-4">
                        
                        <?php 
                            include "config.php";
                            
                            // Cast ID to integer
                            $post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

                            $query = "SELECT post.post_id, post.title, post.description, post.post_img, post.category, category.category_name 
                                      FROM post
                                      LEFT JOIN category ON post.category = category.category_id
                                      LEFT JOIN user ON post.author = user.user_id
                                      WHERE post.post_id = {$post_id}";

                            $result = mysqli_query($connection, $query) or die("Failed");
                            $count = mysqli_num_rows($result);

                            if($count > 0){
                                while($row = mysqli_fetch_assoc($result)){
                        ?>

                        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            
                            <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">

                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary small">TITLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-header text-muted"></i></span>
                                    <input type="text" name="post_title" class="form-control" value="<?php echo $row['title']; ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary small">DESCRIPTION</label>
                                <textarea name="postdesc" class="form-control" rows="6" required style="resize: none;"><?php echo $row['description']; ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary small">CATEGORY</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-tags text-muted"></i></span>
                                    <select name="category" class="form-select" required>
                                        <option disabled>Select Category</option>
                                        <?php  
                                            include "config.php";
                                            $query1 = "SELECT * FROM category";
                                            $result1 = mysqli_query($connection, $query1) or die("Query failed.");

                                            if(mysqli_num_rows($result1) > 0 ){
                                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                                    $selected = ($row['category'] == $row1['category_id']) ? "selected" : "";
                                                    echo "<option {$selected} value='{$row1['category_id']}'>{$row1['category_name']}</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <input type="hidden" name="old_category" value="<?php echo $row['category']; ?>">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-md-5 mb-3 mb-md-0">
                                        <label class="form-label fw-bold text-secondary small d-block">CURRENT IMAGE</label>
                                        <img src="upload/<?php echo $row['post_img']; ?>" class="img-thumbnail rounded shadow-sm" style="height: 150px; width: 100%; object-fit: cover;">
                                        <input type="hidden" name="old_image" value="<?php echo $row['post_img']; ?>">
                                    </div>

                                    <div class="col-md-7">
                                        <label class="form-label fw-bold text-secondary small">CHANGE IMAGE</label>
                                        <input type="file" name="new-image" class="form-control" id="imgInput">
                                        <div class="form-text text-muted">Leave blank to keep current image.</div>
                                        
                                        <div class="mt-2 d-none" id="previewContainer">
                                            <p class="small text-success fw-bold mb-1">New Selection Preview:</p>
                                            <img id="imgPreview" src="#" class="img-thumbnail rounded" style="height: 120px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3 border-top">
                                <a href="post.php" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">Cancel</a>
                                <button type="submit" name="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                    <i class="fa fa-refresh me-1"></i> Update Post
                                </button>
                            </div>

                        </form>
                        <?php 
                                } // End While
                            } else {
                                echo '<div class="alert alert-danger text-center">Post not found.</div>';
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const imgInput = document.getElementById('imgInput');
    const previewContainer = document.getElementById('previewContainer');
    const imgPreview = document.getElementById('imgPreview');

    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            imgPreview.src = URL.createObjectURL(file);
            previewContainer.classList.remove('d-none');
        } else {
            previewContainer.classList.add('d-none');
        }
    }
</script>

<?php include "footer.php"; ?>