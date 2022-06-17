<div class="container-fluid">
    <nav>
        <ul class="footer-menu">
            <li>
                <a href="#">
                    Home
                </a>
            </li>
            <li>
                <a href="#">
                    Company
                </a>
            </li>
            <li>
                <a href="#">
                    Portfolio
                </a>
            </li>
            <li>
                <a href="#">
                    Blog
                </a>
            </li>
        </ul>
        <p class="copyright text-center">

            <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
        </p>
    </nav>
</div>
<script src="/php_basic_2/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="/php_basic_2/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="/php_basic_2/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script>
    $(".nav .nav-link").on("click", function() {
        $(".nav").find(".active").removeClass("active");
        $(this).addClass("active");
    });
</script>