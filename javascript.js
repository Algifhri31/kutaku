$(document).ready(function() {
    // Mobile menu toggle
    $('#hamburger-menu').click(function(e) {
        e.stopPropagation();
        $(this).toggleClass('is-active');
        $('#nav-list').toggleClass('show');
        $('body').toggleClass('no-scroll');
    });

    // Close mobile menu when a link is clicked, but only if it's not a dropdown toggle
    $('#nav-list a').click(function(e) {
        // Check if the clicked link is a dropdown toggle (has a caret-down icon)
        if (!$(this).find('.fa-caret-down').length) {
            if ($('#hamburger-menu').hasClass('is-active')) {
                $('#hamburger-menu').removeClass('is-active');
                $('#nav-list').removeClass('show');
                $('body').removeClass('no-scroll'); // Remove no-scroll when menu closes
            }
        }
    });

    // Close mobile menu when clicking outside
    $(document).click(function(event) {
        if ($('#nav-list').hasClass('show') && !$(event.target).closest('#nav-list').length && !$(event.target).closest('#hamburger-menu').length) {
            $('#hamburger-menu').removeClass('is-active');
            $('#nav-list').removeClass('show');
            $('body').removeClass('no-scroll'); // Remove no-scroll when menu closes
        }
    });

    // Dropdown functionality
    $('.dropdown > a').click(function(e) {
        if ($(window).width() <= 900) {
            e.preventDefault();
            // Close other open dropdowns
            $('.dropdown.open').not($(this).parent()).removeClass('open');
            $(this).parent().toggleClass('open');
        }
    });

    // Navbar scroll effect
    var scroll_pos = 0;
    $(document).scroll(function() {
        scroll_pos = $(this).scrollTop();
        if (scroll_pos > 0) {
            $("nav").addClass("putih");
        } else {
            $("nav").removeClass("putih");
        }
    });

    // Smooth scrolling for anchor links
    $('a[href^="#"]').click(function(e) {
        var targetSelector = this.getAttribute('href');
        // Do not prevent default for non-anchor links or the mobile menu button
        if (targetSelector === '#' || $(this).attr('id') === 'hamburger-menu') {
            return;
        }
        e.preventDefault();
        var target = $(targetSelector);
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 70
            }, 800);
        }
    });
});

