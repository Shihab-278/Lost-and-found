/* =============================
   MAIN JAVASCRIPT
   UITS Lost and Found
   ============================= */

/**
 * Handle Search Form Submission
 * Prevents default submission if empty, and redirects cleanly.
 */
function submitSearchFromInput(event, form) {
    event.preventDefault();
    
    // Find the input within this specific form
    const searchInput = form.querySelector('input[name="search"]');
    const query = searchInput.value.trim();
    
    if(query !== "") {
        // Redirect to search.php
        window.location.href = 'search.php?search=' + encodeURIComponent(query);
    } else {
        // Optional: Add a shake effect or red border to indicate empty input
        searchInput.classList.add('is-invalid');
        setTimeout(() => {
            searchInput.classList.remove('is-invalid');
        }, 2000);
    }
    
    return false;
}

/**
 * Enable Bootstrap Tooltips (Optional, if you use them)
 */
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        // Check if bootstrap is defined (loaded)
        if(typeof bootstrap !== 'undefined') {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        }
    });
});