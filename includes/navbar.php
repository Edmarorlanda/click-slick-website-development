<header class="site-header">
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container navbar-inner">
            <a class="navbar-brand" href="./index.php" aria-label="Click Slick Auto Detailing home">
                <img src="./assets/images/click.jpg" alt="Click Slick Auto Detailing logo" class="brand-logo" loading="lazy">
                <div class="brand-text">
                    <span class="brand-name">CLICK SLICK</span>
                    <span class="brand-subtitle">Auto Detailing</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" aria-label="Toggle navigation" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto" data-scroll-nav>
                    <?php
                    $navItems = [
                        ['Home', 'index.php', 'top'],
                        ['Services', 'services.php', 'services'],
                        ['Our Process', 'process.php', 'process'],
                        ['Why Us', 'index.php#why-us', 'why-us'],
                        ['About', 'about.php', 'about'],
                        ['Reviews', 'reviews.php', 'reviews'],
                        ['FAQ', 'index.php#faq', 'faq'],
                        ['Contact', 'contact.php', 'contact']
                    ];
                    foreach ($navItems as $item) {
                        $label = $item[0];
                        $href = $item[1];
                        $section = $item[2];
                        $isActive = ($currentPage === $href) || ($currentPage === 'index.php' && $section === 'top');
                        echo '<li class="nav-item"><a class="nav-link' . ($isActive ? ' active' : '') . '" data-section="' . $section . '" href="' . $href . '">' . $label . '</a></li>';
                    }
                    ?>
                </ul>
                <a href="./booking.php" class="btn btn-primary btn-book"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i><span>Book Your Detail</span></a>
            </div>
        </div>
    </nav>
</header>
