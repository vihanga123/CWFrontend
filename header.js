document.addEventListener('DOMContentLoaded', function () {
    var lastScrollTop = 0;
    var header = document.getElementById('main-header');
    
    window.addEventListener('scroll', function () {
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop) {
            // Scrolling down
            header.style.top = '-100px'; // Hide the header
        } else {
            // Scrolling up
            header.style.top = '0'; // Show the header
        }
        
        lastScrollTop = scrollTop;
    });
});