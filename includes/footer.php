</div> <!-- End container -->

<footer class="bg-dark text-light mt-5 py-4">
    <div class="container">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-md-4 mb-3">
                <h5>Contact Us</h5>
                <p>Email: <a href="mailto:info@myapp.com" class="text-light">info@myapp.com</a></p>
                <p>Phone: +91 98765 43210</p>
            </div>

            <!-- Address -->
            <div class="col-md-4 mb-3">
                <h5>Address</h5>
                <p>PEKKA Pvt. Ltd.<br>
                   123 Business Street,<br>
                   Bengaluru, India - 560001</p>
            </div>

            <!-- Social Links -->
            <div class="col-md-4 mb-3">
                <h5>Follow Us</h5>
                <a href="#" class="text-light me-3"><i class="bi bi-facebook"></i> Facebook</a><br>
                <a href="#" class="text-light me-3"><i class="bi bi-twitter"></i> Twitter</a><br>
                <a href="#" class="text-light"><i class="bi bi-instagram"></i> Instagram</a>
            </div>
        </div>

        <hr class="bg-light">

        <!-- Copyright -->
        <div class="text-center">
            <p class="mb-0">&copy; <?= date('Y') ?> PEKKA. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional custom JS -->
<!-- <script src="../assets/js/script.js"></script> -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    // ==== Table styling ====
    document.querySelectorAll("table").forEach(table => {
        table.classList.add("table", "table-striped", "table-bordered", "table-hover", "align-middle", "shadow", "rounded");
    });

    // ==== Edit buttons ====
    document.querySelectorAll('a[href*="edit_"]').forEach(link => {
        link.classList.add("btn", "btn-warning", "btn-sm", "me-1");
        link.innerHTML = '<i class="bi bi-pencil"></i> ' + link.innerHTML;
    });

    // ==== Delete buttons ====
    document.querySelectorAll('a[href*="delete_"]').forEach(link => {
        link.classList.add("btn", "btn-danger", "btn-sm", "me-1");
        link.innerHTML = '<i class="bi bi-trash"></i> ' + link.innerHTML;
    });

    // ==== Place Order buttons ====
    document.querySelectorAll('a[href*="place_order"]').forEach(link => {
        link.classList.add("btn", "btn-success", "btn-sm", "me-1");
        link.innerHTML = '<i class="bi bi-cart-plus"></i> ' + link.innerHTML;
    });

    // ==== Approve buttons ====
    document.querySelectorAll('button[name="status"][value="Approved"]').forEach(btn => {
        btn.classList.add("btn", "btn-primary", "btn-sm", "me-1");
        btn.innerHTML = '<i class="bi bi-check-circle"></i> ' + btn.innerHTML;
    });

    // ==== Reject buttons ====
    document.querySelectorAll('button[name="status"][value="Rejected"]').forEach(btn => {
        btn.classList.add("btn", "btn-danger", "btn-sm", "me-1");
        btn.innerHTML = '<i class="bi bi-x-circle"></i> ' + btn.innerHTML;
    });

    // ==== Fulfill buttons ====
    document.querySelectorAll('button[name="status"][value="Fulfilled"]').forEach(btn => {
        btn.classList.add("btn", "btn-success", "btn-sm", "me-1");
        btn.innerHTML = '<i class="bi bi-box-seam"></i> ' + btn.innerHTML;
    });

    // ==== Status Badge ====
    document.querySelectorAll("td").forEach(function(cell) {
        const text = cell.textContent.trim().toLowerCase();

        if (["pending", "approved", "rejected", "fulfilled"].includes(text)) {
            let badgeClass = "bg-secondary"; // default
            switch (text) {
                case "pending":
                    badgeClass = "bg-warning text-dark";
                    break;
                case "approved":
                    badgeClass = "bg-primary";
                    break;
                case "rejected":
                    badgeClass = "bg-danger";
                    break;
                case "fulfilled":
                    badgeClass = "bg-success";
                    break;
            }

            cell.innerHTML = `<span class="badge ${badgeClass}">${text.charAt(0).toUpperCase() + text.slice(1)}</span>`;
        }
    });

    document.querySelectorAll("td").forEach(function(cell) {
        const text = cell.textContent.trim().toLowerCase();

        // Role badges
        if (["admin", "user"].includes(text)) {
            let badgeClass = "bg-secondary"; // default
            switch (text) {
                case "admin":
                    badgeClass = "bg-dark"; // Red for admin
                    break;
                case "user":
                    badgeClass = "bg-light text-dark border border-dark"; // Light blue for user
                    break;
            }
            cell.innerHTML = `<span class="badge ${badgeClass}">${text.charAt(0).toUpperCase() + text.slice(1)}</span>`;
        }
    });

    document.querySelectorAll("table").forEach(function(table) {
        // Wrap table inside a scrollable div
        const wrapper = document.createElement("div");
        wrapper.classList.add("table-responsive");
        wrapper.style.maxHeight = "400px";
        wrapper.style.overflowY = "auto";

        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });

});
</script>


</body>
</html>

