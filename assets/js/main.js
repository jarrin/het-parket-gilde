// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    console.log('Mobile menu elements:', { menuToggle, navMenu });
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Menu toggle clicked!');
            navMenu.classList.toggle('active');
            this.classList.toggle('active');
            console.log('Menu active:', navMenu.classList.contains('active'));
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.main-nav')) {
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });
        
        // Close menu when clicking a link
        const navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
            });
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animatedElements = document.querySelectorAll('.feature-card, .service-item, .value-card, .contact-card');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
    
    // Parallax effect for hero sections
    function parallaxEffect() {
        const heroes = document.querySelectorAll('.hero');
        heroes.forEach(hero => {
            const scrolled = window.pageYOffset;
            const heroTop = hero.offsetTop;
            const heroHeight = hero.offsetHeight;
            
            // Only apply parallax when hero is in viewport
            if (scrolled < heroTop + heroHeight && scrolled + window.innerHeight > heroTop) {
                const offset = (scrolled - heroTop) * 0.5;
                hero.style.backgroundPositionY = offset + 'px';
            }
        });
    }
    
    // Apply parallax on scroll
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                parallaxEffect();
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // Initial parallax setup
    parallaxEffect();
});

// Feature boxes horizontal scroll functionality
function scrollFeatures(direction) {
    const container = document.getElementById('featuresContainer');
    if (!container) return;
    
    const scrollAmount = 350; // Scroll by one card width + gap
    
    if (direction === 'left') {
        container.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    } else if (direction === 'right') {
        container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }
    
    // Update button states after scroll
    setTimeout(updateScrollButtons, 300);
}

// Values horizontal scroll functionality
function scrollValues(direction) {
    const container = document.querySelector('.values-grid.scrollable');
    if (!container) return;
    
    const scrollAmount = 330; // Scroll by one card width + gap
    
    if (direction === 'left') {
        container.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    } else if (direction === 'right') {
        container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }
    
    // Update button states after scroll
    setTimeout(updateValuesScrollButtons, 300);
}

// Update scroll button states based on scroll position
function updateScrollButtons() {
    const container = document.getElementById('featuresContainer');
    if (!container) return;
    
    const leftBtn = document.querySelector('.scroll-btn.left');
    const rightBtn = document.querySelector('.scroll-btn.right');
    
    if (!leftBtn || !rightBtn) return;
    
    // Disable left button if at start
    if (container.scrollLeft <= 0) {
        leftBtn.disabled = true;
    } else {
        leftBtn.disabled = false;
    }
    
    // Disable right button if at end
    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 5) {
        rightBtn.disabled = true;
    } else {
        rightBtn.disabled = false;
    }
}

// Update values scroll button states based on scroll position
function updateValuesScrollButtons() {
    const container = document.querySelector('.values-grid.scrollable');
    if (!container) return;
    
    const leftBtn = document.getElementById('scroll-left-values');
    const rightBtn = document.getElementById('scroll-right-values');
    
    if (!leftBtn || !rightBtn) return;
    
    // Disable left button if at start
    if (container.scrollLeft <= 0) {
        leftBtn.disabled = true;
    } else {
        leftBtn.disabled = false;
    }
    
    // Disable right button if at end
    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 5) {
        rightBtn.disabled = true;
    } else {
        rightBtn.disabled = false;
    }
}

// Initialize scroll buttons on page load
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('featuresContainer');
    if (container && container.classList.contains('scrollable')) {
        updateScrollButtons();
        
        // Update buttons on scroll
        container.addEventListener('scroll', updateScrollButtons);
    }
    
    // Initialize values scroll buttons
    const valuesContainer = document.querySelector('.values-grid.scrollable');
    if (valuesContainer) {
        updateValuesScrollButtons();
        
        // Update buttons on scroll
        valuesContainer.addEventListener('scroll', updateValuesScrollButtons);
    }
    
    // Initialize contact cards scroll buttons
    const contactContainer = document.getElementById('contactInfoScroll');
    if (contactContainer) {
        updateContactScrollButtons();
        
        // Update buttons on scroll
        contactContainer.addEventListener('scroll', updateContactScrollButtons);
    }
});

// Contact cards horizontal scroll functionality
function scrollContactCards(direction) {
    const container = document.getElementById('contactInfoScroll');
    if (!container) return;
    
    const scrollAmount = 320; // Scroll by one card width + gap
    
    if (direction === 'left') {
        container.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    } else if (direction === 'right') {
        container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }
    
    // Update button states after scroll
    setTimeout(updateContactScrollButtons, 300);
}

// Update contact scroll button states based on scroll position
function updateContactScrollButtons() {
    const container = document.getElementById('contactInfoScroll');
    if (!container) return;
    
    const leftBtn = document.querySelector('.contact-scroll-left');
    const rightBtn = document.querySelector('.contact-scroll-right');
    
    if (!leftBtn || !rightBtn) return;
    
    // Disable left button if at start
    if (container.scrollLeft <= 0) {
        leftBtn.style.opacity = '0.5';
        leftBtn.style.cursor = 'not-allowed';
        leftBtn.disabled = true;
    } else {
        leftBtn.style.opacity = '1';
        leftBtn.style.cursor = 'pointer';
        leftBtn.disabled = false;
    }
    
    // Disable right button if at end
    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 5) {
        rightBtn.style.opacity = '0.5';
        rightBtn.style.cursor = 'not-allowed';
        rightBtn.disabled = true;
    } else {
        rightBtn.style.opacity = '1';
        rightBtn.style.cursor = 'pointer';
        rightBtn.disabled = false;
    }
}
