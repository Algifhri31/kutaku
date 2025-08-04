$(document).ready(function() {
    // Mobile menu toggle
    $('#hamburger-menu').click(function() {
        $('#nav-list').toggleClass('show');
    });
    
    // Close mobile menu when clicking close button
    $('#close-mobile-menu').click(function() {
        $('#nav-list').removeClass('show');
    });
    
    // Close mobile menu when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('.navbar').length) {
            $('#nav-list').removeClass('show');
        }
    });
    
    // Dropdown functionality
    $('.dropdown').click(function(e) {
        if ($(window).width() <= 900) {
            e.preventDefault();
            $(this).toggleClass('open');
        }
    });
    
    // Navbar scroll effect
    var scroll_pos = 0;
    $(document).scroll(function() {
        scroll_pos = $(this).scrollTop();
        if (scroll_pos > 0) {
            $("nav").addClass("putih");
            $("nav img.hitam").show();
            $("nav img.putih").hide();
        } else {
            $("nav").removeClass("putih");
            $("nav img.hitam").hide();
            $("nav img.putih").show();
        }
    });
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        var target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 70
            }, 800);
        }
    });
});

