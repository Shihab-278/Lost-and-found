<?php include "header.php"; ?>

<div id="admin-content" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-8 col-lg-7">
                
                <div class="card shadow-lg border-0 rounded-3">
                    
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <h4 class="fw-bold text-dark m-0"><i class="fa fa-pencil-square-o me-2 text-primary"></i>Add New Post</h4>
                        <p class="text-muted small mt-1">Fill in the details below to publish a new item.</p>
                    </div>

                    <div class="card-body p-4">
                        
                        <form action="save-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            
                            <div class="mb-4">
                                <label for="post_title" class="form-label fw-bold text-secondary small">TITLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-header text-muted"></i></span>
                                    <input type="text" name="post_title" class="form-control" placeholder="e.g. Lost Black Wallet" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="postdesc" class="form-label fw-bold text-secondary small">DESCRIPTION</label>
                                <textarea name="postdesc" class="form-control" rows="5" placeholder="Describe the item, where it was found/lost, and contact details..." required style="resize: none;"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="category" class="form-label fw-bold text-secondary small">CATEGORY</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa fa-tags text-muted"></i></span>
                                    <select name="category" class="form-select" required>
                                        <option disabled selected>Select Category</option>
                                        <?php  
                                            include "config.php";
                                            $query = "SELECT * FROM category";
                                            $result = mysqli_query($connection, $query) or die("Query failed.");

                                            if(mysqli_num_rows($result) > 0 ){
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="fileToUpload" class="form-label fw-bold text-secondary small">ITEM IMAGE</label>
                                <input type="file" name="fileToUpload" class="form-control" id="imgInput" required accept="image/*">
                                
                                <div class="mt-3 text-center d-none" id="previewContainer">
                                    <img id="imgPreview" src="#" alt="Image Preview" class="img-thumbnail rounded shadow-sm" style="max-height: 200px; max-width: 100%;">
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2">
                                <a href="post.php" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">Cancel</a>
                                <button type="submit" name="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                    <i class="fa fa-save me-1"></i> Save Post
                                </button>
                            </div>

                        </form>
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
        }
    }
</script>

<?php include "footer.php"; ?>