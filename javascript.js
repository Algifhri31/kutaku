$(document).ready(function() {
    // Hamburger menu functionality
    $('#hamburger-menu').click(function() {
        $('#nav-list').toggleClass('active');
    });

    // Smooth scroll for navigation links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.hash);
        if (target.length) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 800);
        }
    });

    // Navbar scroll effect
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('scrolled');
            $('#main-logo').attr('src', 'logo/primary-logo.png'); // Change to black logo
        } else {
            $('.navbar').removeClass('scrolled');
            $('#main-logo').attr('src', 'logo/primary-logo.png'); // Change back to white logo
        }
    });

    // Inovasi Carousel
    const inovasiCarousel = $('.inovasi-carousel-container');
    let scrollAmount = 0;
    const scrollSpeed = 2000; // Scroll every 2 seconds

    let autoScrollInterval = setInterval(() => {
        scrollAmount = inovasiCarousel.scrollLeft() + inovasiCarousel.width();
        if (scrollAmount >= inovasiCarousel[0].scrollWidth) {
            scrollAmount = 0; // Reset to beginning if end is reached
        }
        inovasiCarousel.animate({ scrollLeft: scrollAmount }, 800);
    }, scrollSpeed);

    // Pause auto-scroll on hover
    inovasiCarousel.hover(
        function() {
            clearInterval(autoScrollInterval);
        },
        function() {
            autoScrollInterval = setInterval(() => {
                scrollAmount = inovasiCarousel.scrollLeft() + inovasiCarousel.width();
                if (scrollAmount >= inovasiCarousel[0].scrollWidth) {
                    scrollAmount = 0;
                }
                inovasiCarousel.animate({ scrollLeft: scrollAmount }, 800);
            }, scrollSpeed);
        }
    );

    // Adjust scrollAmount if user manually scrolls
    inovasiCarousel.on('scroll', function() {
        scrollAmount = inovasiCarousel.scrollLeft();
    });
});