
<script>
    CKEDITOR.replace("ckeditor-desc");
</script>
<script src="/temp/libs/jquery/dist/jquery.min.js"></script>
<script src="/temp/assets/js/bootstrap.bundle.min.js"></script>
<script src="/temp/js/admin.js"></script>
<script src="/temp/js/main.js"></script>
<script src="/temp/js/validate.js"></script>
<script src="/temp/js/owl.carousel.min.js"></script>
<script src="/temp/vendor/libs/jquery/jquery.js"></script>
<script src="/temp/vendor/libs/popper/popper.js"></script>
<script src="/temp/vendor/js/bootstrap.js"></script>
<script src="/temp/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="/temp/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="/temp/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->

<!-- Page JS -->
<script src="/temp/js/dashboards-analytics.js"></script>
<script src="/ckeditor/ckeditor.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.menu-toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            const parentItem = this.closest('.menu-item');
            const submenu = parentItem.querySelector('.menu-sub');

            if (parentItem.classList.contains('open')) {
                parentItem.classList.remove('open');
                submenu.style.display = 'none';
            } else {
                parentItem.classList.add('open');
                submenu.style.display = 'block';
            }
        });
    });

    // Khởi tạo trạng thái ẩn/hiện cho các menu-sub
    document.querySelectorAll('.menu-sub').forEach(ul => {
        const parentItem = ul.closest('.menu-item');
        if (!parentItem.classList.contains('open')) {
            ul.style.display = 'none';
        }
    });
});
</script>
