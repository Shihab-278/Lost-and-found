<footer class="bg-dark text-white mt-auto py-4" style="margin-top: 50px;">
        <div class="container">
            <div class="row gy-4">
                
                <div class="col-lg-4 col-md-6">
                    <h6 class="text-uppercase fw-bold text-warning mb-3">About Admin Panel</h6>
                    <p class="small text-white-50">
                        This is the administrative dashboard for UITS Lost & Found. 
                        Manage posts, categories, and users securely from here.
                    </p>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h6 class="text-uppercase fw-bold text-warning mb-3">Support</h6>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-2">
                            <i class="fa fa-envelope me-2"></i> lostandfound@uits.edu.bd
                        </li>
                        <li class="mb-2">
                            <i class="fa fa-phone me-2"></i> +880 1234-567890
                        </li>
                        <li>
                            <i class="fa fa-map-marker me-2"></i> UITS Campus
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h6 class="text-uppercase fw-bold text-warning mb-3">UITS Lost & Found</h6>
                    <p class="small text-white-50">
                        &copy; <?php echo date('Y'); ?> All Rights Reserved.
                    </p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-white me-3 text-decoration-none"><i class="fa fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3 text-decoration-none"><i class="fa fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-white text-decoration-none"><i class="fa fa-instagram fa-lg"></i></a>
                    </div>
                </div>
                
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>
</html>