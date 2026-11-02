        </div> <!-- End .page-body -->
    </main> <!-- End .main-content -->
</div> <!-- End .app-container -->

<script>
    // Toggle sidebar collapse
    const collapseBtn = document.querySelector('.sidebar-collapse-btn');
    if (collapseBtn) {
        collapseBtn.addEventListener('click', () => {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('collapsed');
        });
    }
</script>
</body>
</html>

