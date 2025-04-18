<?php
include 'header.php';

// Check if user just logged in (using session)
$freshLogin = false;
if (isset($_SESSION['fresh_login']) && $_SESSION['fresh_login'] === true) {
    $freshLogin = true;
    // Reset the flag
    $_SESSION['fresh_login'] = false;
}

// Get user profile
$userProfile = null;
if (isset($_COOKIE['userProfile'])) {
    $userProfile = json_decode($_COOKIE['userProfile'], true);
}
?>

<style>
    /* Hero section styles */
    .hero-section {
        position: relative;
        overflow: hidden;
        padding: 0;
        height: 450px;
        border-radius: 16px;
        margin-bottom: 30px;
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        z-index: 2;
    }
    
    .welcome-alert {
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        margin: 0 auto;
        width: 90%;
        max-width: 600px;
        background-color: var(--primary-color);
        color: white;
        padding: 15px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 6px 20px rgba(230, 57, 70, 0.3);
        z-index: 10;
        animation: fadeInDown 0.8s ease forwards;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .welcome-alert i {
        font-size: 1.8rem;
        margin-right: 15px;
    }
    
    .welcome-alert-content {
        flex: 1;
    }
    
    .welcome-alert h3 {
        margin: 0 0 5px 0;
        font-size: 1.2rem;
    }
    
    .welcome-alert p {
        margin: 0;
        font-size: 0.95rem;
        opacity: 0.9;
    }
    
    .close-alert {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 1.2rem;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }
    
    .close-alert:hover {
        opacity: 1;
    }
    
    .hero-content {
        color: white;
        max-width: 700px;
    }
    
    .hero-title {
        font-size: 2.5rem;
        margin: 0 0 10px 0;
        font-weight: 700;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
        margin: 0 0 30px 0;
        font-weight: 400;
        opacity: 0.9;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }
    
    /* Video carousel */
    .video-carousel {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    
    .carousel-video {
        position: absolute;
        object-fit: cover;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1.5s ease;
    }
    
    .carousel-video.active {
        opacity: 1;
    }
    
    /* CTA buttons */
    .cta-buttons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    
    .cta-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 24px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
    }
    
    .cta-primary {
        background-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 15px rgba(230, 57, 70, 0.3);
    }
    
    .cta-primary:hover {
        background-color: #d02c39;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230, 57, 70, 0.4);
    }
    
    .cta-secondary {
        background-color: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .cta-secondary:hover {
        background-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
    
    .cta-tertiary {
        background-color: var(--secondary-color);
        color: white;
        box-shadow: 0 4px 15px rgba(29, 53, 87, 0.3);
    }
    
    .cta-tertiary:hover {
        background-color: #152842;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(29, 53, 87, 0.4);
    }
    
    /* Features section */
    .features-section {
        padding: 30px 0;
    }
    
    .section-title {
        font-size: 1.8rem;
        color: var(--secondary-color);
        margin-bottom: 30px;
        text-align: center;
        position: relative;
    }
    
    .section-title:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--primary-color);
        border-radius: 3px;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }
    
    .feature-card {
        background-color: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background-color: rgba(230, 57, 70, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .feature-icon i {
        font-size: 2rem;
        color: var(--primary-color);
    }
    
    .feature-title {
        font-size: 1.2rem;
        color: var(--dark-color);
        margin-bottom: 10px;
    }
    
    .feature-desc {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    /* Responsive adjustments */
    @media screen and (max-width: 768px) {
        .hero-section {
            height: 500px;
        }
        
        .hero-overlay {
            padding: 30px;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }
        
        .cta-buttons {
            flex-direction: column;
        }
        
        .welcome-alert {
            width: 85%;
            padding: 12px 15px;
        }
        
        .welcome-alert h3 {
            font-size: 1.1rem;
        }
        
        .welcome-alert p {
            font-size: 0.9rem;
        }
    }
    
    @media screen and (max-width: 480px) {
        .hero-section {
            height: 450px;
            border-radius: 12px;
        }
        
        .hero-overlay {
            padding: 25px;
        }
        
        .hero-title {
            font-size: 1.8rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
            margin-bottom: 20px;
        }
        
        .feature-card {
            padding: 20px;
        }
    }
    
    /* How It Works Section */
    .how-it-works-section {
        padding: 60px 0;
        background-color: #f9f9f9;
        border-radius: 16px;
        margin: 40px 0;
    }
    
    .steps-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 40px;
        gap: 30px;
    }
    
    .step-card {
        flex: 1;
        min-width: 250px;
        max-width: 280px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .step-number {
        background-color: var(--primary-color);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(230, 57, 70, 0.3);
    }
    
    .step-icon {
        font-size: 3rem;
        color: var(--secondary-color);
        margin-bottom: 15px;
    }
    
    .step-title {
        font-size: 1.2rem;
        color: var(--dark-color);
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .step-desc {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    /* Popular Vendors Section */
    .popular-vendors-section {
        padding: 40px 0;
    }
    
    .vendors-slider {
        margin-top: 30px;
        display: flex;
        overflow-x: auto;
        padding: 10px 0 20px;
        gap: 20px;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Firefox */
    }
    
    .vendors-slider::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Edge */
    }
    
    .vendor-card {
        min-width: 280px;
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .vendor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }
    
    .vendor-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
    
    .vendor-info {
        padding: 20px;
    }
    
    .vendor-name {
        font-size: 1.2rem;
        color: var(--secondary-color);
        margin-bottom: 8px;
        font-weight: 600;
    }
    
    .vendor-location {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
    
    .vendor-rating {
        display: flex;
        align-items: center;
        gap: 3px;
        margin-bottom: 15px;
    }
    
    .rating-stars {
        color: #f1c40f;
        font-size: 0.9rem;
    }
    
    .rating-count {
        color: #888;
        font-size: 0.85rem;
    }
    
    .vendor-specialty {
        font-size: 0.9rem;
        color: #444;
    }
    
    .vendor-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-top: 10px;
    }
    
    .vendor-open {
        background-color: #e8f5e9;
        color: #4caf50;
    }
    
    .vendor-closed {
        background-color: #ffebee;
        color: #f44336;
    }
    
    .slider-controls {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 25px;
    }
    
    .slider-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: white;
        border: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .slider-btn:hover {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    /* Testimonials Section */
    .testimonials-section {
        padding: 60px 0;
        background-color: var(--light-color);
        border-radius: 16px;
        margin: 40px 0;
    }
    
    .testimonials-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin-top: 40px;
        justify-content: center;
    }
    
    .testimonial-card {
        background-color: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        max-width: 350px;
        position: relative;
    }
    
    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 5rem;
        line-height: 1;
        color: rgba(230, 57, 70, 0.1);
        font-family: Georgia, serif;
    }
    
    .testimonial-content {
        font-style: italic;
        color: #555;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }
    
    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .author-image {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary-color);
    }
    
    .author-info {
        display: flex;
        flex-direction: column;
    }
    
    .author-name {
        font-weight: 600;
        color: var(--secondary-color);
        font-size: 1.1rem;
    }
    
    .author-title {
        color: #777;
        font-size: 0.9rem;
    }
    
    /* Responsive Adjustments */
    @media screen and (max-width: 768px) {
        .steps-container {
            flex-direction: column;
            align-items: center;
        }
        
        .testimonials-container {
            flex-direction: column;
            align-items: center;
        }
        
        .vendor-card {
            min-width: 260px;
        }
    }
</style>

<main>
    <!-- Hero Section with Video Carousel -->
    <section class="hero-section">
        <!-- Welcome Alert -->
        <?php if ($freshLogin && $userProfile): ?>
        <div class="welcome-alert" id="welcome-alert">
            <i class="fas fa-hand-sparkles"></i>
            <div class="welcome-alert-content">
                <h3>Welcome back, <?php echo htmlspecialchars($userProfile['name']); ?>!</h3>
                <p>Ready to discover delicious meals around campus?</p>
            </div>
            <button class="close-alert" onclick="document.getElementById('welcome-alert').style.display = 'none';">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endif; ?>
        
        <!-- Video Carousel -->
        <div class="video-carousel">
            <video class="carousel-video active" autoplay muted>
                <source src="burger.mp4" type="video/mp4">
            </video>
            <video class="carousel-video" muted>
                <source src="frying.mp4" type="video/mp4">
            </video>
            <video class="carousel-video" muted>
                <source src="cutting-bread.mp4" type="video/mp4">
            </video>
            <video class="carousel-video" muted>
                <source src="pork-roasting.mp4" type="video/mp4">
            </video>
        </div>
        
        <!-- Hero Content Overlay -->
        <div class="hero-overlay">
            <div class="hero-content">
                <h1 class="hero-title">Hungry? We've Got You Covered!</h1>
                <p class="hero-subtitle">Discover and order from the best food vendors around Makerere Business School — right at your fingertips.</p>
                
                <!-- CTA Buttons -->
                <div class="cta-buttons">
                    <a href="vendors.php" class="cta-btn cta-primary">
                        <i class="fas fa-store"></i> View Vendors
                    </a>
                    <a href="map.php" class="cta-btn cta-secondary">
                        <i class="fas fa-map-marked-alt"></i> See Map
                    </a>
                    <a href="my-orders.php" class="cta-btn cta-tertiary">
                        <i class="fas fa-list"></i> My Orders
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features-section">
        <h2 class="section-title">Why SapaSpots?</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3 class="feature-title">Variety of Options</h3>
                <p class="feature-desc">Explore different vendors across campus serving a wide range of delicious meals.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="feature-title">Easy Ordering</h3>
                <p class="feature-desc">Just a few clicks to place your order from any vendor on campus.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3 class="feature-title">Interactive Map</h3>
                <p class="feature-desc">Locate your favorite food spots easily with our campus map.</p>
            </div>
        </div>
    </section>
    
    <!-- How It Works Section -->
    <section class="how-it-works-section">
        <h2 class="section-title">How It Works</h2>
        
        <div class="steps-container">
            <div class="step-card">
                <div class="step-number">1</div>
                <i class="fas fa-search step-icon"></i>
                <h3 class="step-title">Find Vendors</h3>
                <p class="step-desc">Browse through our list of vendors or locate them on the interactive map.</p>
            </div>
            
            <div class="step-card">
                <div class="step-number">2</div>
                <i class="fas fa-hamburger step-icon"></i>
                <h3 class="step-title">Select Your Food</h3>
                <p class="step-desc">Check out menus and add your favorite items to your tray.</p>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <i class="fas fa-check-circle step-icon"></i>
                <h3 class="step-title">Place Your Order</h3>
                <p class="step-desc">Review your selections and place your order in just a few clicks.</p>
            </div>
            
            <div class="step-card">
                <div class="step-number">4</div>
                <i class="fas fa-smile-beam step-icon"></i>
                <h3 class="step-title">Enjoy Your Meal</h3>
                <p class="step-desc">Pick up your order when it's ready and enjoy your delicious meal!</p>
            </div>
        </div>
    </section>
    
    <!-- Popular Vendors Section -->
    <section class="popular-vendors-section">
        <h2 class="section-title">Popular Vendors</h2>
        
        <div class="vendors-slider" id="vendors-slider">
            <!-- Vendor cards will be dynamically loaded here -->
        </div>
        
        <div class="slider-controls">
            <button class="slider-btn" id="prev-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-btn" id="next-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <h2 class="section-title">What Our Users Say</h2>
        
        <div class="testimonials-container">
            <div class="testimonial-card">
                <p class="testimonial-content">SapaSpots has been a game-changer for me! No more long waits in line during lunch breaks. I can order my food in advance and pick it up when it's ready.</p>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah" class="author-image">
                    <div class="author-info">
                        <div class="author-name">Sarah Namukasa</div>
                        <div class="author-title">Business Administration Student</div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-content">As a final year student with a tight schedule, SapaSpots helps me save time. The map feature is brilliant for finding new food spots around campus!</p>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="David" class="author-image">
                    <div class="author-info">
                        <div class="author-name">David Muhwezi</div>
                        <div class="author-title">Economics Student</div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-content">I love being able to see what's available before heading out for lunch. The app has introduced me to some amazing vendors I wouldn't have discovered otherwise.</p>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/women/67.jpg" alt="Grace" class="author-image">
                    <div class="author-info">
                        <div class="author-name">Grace Nakitto</div>
                        <div class="author-title">Marketing Student</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    // Video carousel functionality
    document.addEventListener('DOMContentLoaded', function() {
        const videos = document.querySelectorAll('.carousel-video');
        let currentVideo = 0;
        
        // Function to play the next video
        function playNextVideo() {
            // Hide all videos
            videos.forEach(video => {
                video.classList.remove('active');
                video.pause();
                video.currentTime = 0;
            });
            
            // Increment counter and wrap around if needed
            currentVideo = (currentVideo + 1) % videos.length;
            
            // Show and play the next video
            videos[currentVideo].classList.add('active');
            videos[currentVideo].play();
        }
        
        // Set up event listeners for videos
        videos.forEach(video => {
            video.addEventListener('ended', playNextVideo);
        });
        
        // Start playing the first video
        videos[0].play();
        
        // For demonstration purposes, let's automatically close the welcome message after 5 seconds
        const welcomeAlert = document.getElementById('welcome-alert');
        if (welcomeAlert) {
            setTimeout(() => {
                welcomeAlert.style.opacity = '0';
                welcomeAlert.style.transform = 'translateY(-20px)';
                welcomeAlert.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    welcomeAlert.style.display = 'none';
                }, 500);
            }, 5000);
        }
        
        // Load popular vendors from data.js
        loadPopularVendors();
        
        // Vendor slider functionality
        const slider = document.getElementById('vendors-slider');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        
        if (slider && prevBtn && nextBtn) {
            // Scroll by one card width plus gap
            const scrollAmount = 300;
            
            nextBtn.addEventListener('click', () => {
                slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
            
            prevBtn.addEventListener('click', () => {
                slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
        }
        
        // Function to load popular vendors from data.js
        function loadPopularVendors() {
            const vendorsSlider = document.getElementById('vendors-slider');
            if (!vendorsSlider) return;
            
            // Get vendors from localStorage or defaultVendors
            let vendors = [];
            try {
                const vendorsFromStorage = localStorage.getItem('vendors');
                if (vendorsFromStorage) {
                    vendors = JSON.parse(vendorsFromStorage);
                } else if (window.defaultVendors) {
                    vendors = window.defaultVendors;
                }
            } catch (error) {
                console.error('Error loading vendors:', error);
                if (window.defaultVendors) {
                    vendors = window.defaultVendors;
                }
            }
            
            // Sort vendors by rating (highest first) and take the top 5
            const popularVendors = [...vendors]
                .sort((a, b) => (b.rating || 0) - (a.rating || 0))
                .slice(0, 5);
            
            // Clear slider contents
            vendorsSlider.innerHTML = '';
            
            // Create vendor cards
            popularVendors.forEach(vendor => {
                // Create vendor card element
                const vendorCard = document.createElement('div');
                vendorCard.className = 'vendor-card';
                
                // Generate rating stars
                let starsHtml = '';
                const rating = vendor.rating || 0;
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) {
                        starsHtml += '<i class="fas fa-star"></i>';
                    } else if (i - 0.5 <= rating) {
                        starsHtml += '<i class="fas fa-star-half-alt"></i>';
                    } else {
                        starsHtml += '<i class="far fa-star"></i>';
                    }
                }
                
                // Set inner HTML
                vendorCard.innerHTML = `
                    <img src="${vendor.imageUrl}" alt="${vendor.name}" class="vendor-image">
                    <div class="vendor-info">
                        <h3 class="vendor-name">${vendor.name}</h3>
                        <div class="vendor-location">
                            <i class="fas fa-map-marker-alt"></i> ${vendor.location}
                        </div>
                        <div class="vendor-rating">
                            <div class="rating-stars">
                                ${starsHtml}
                            </div>
                            <span class="rating-count">(${vendor.reviewCount || 0} ratings)</span>
                        </div>
                        <p class="vendor-specialty">Specialty: ${vendor.specialty || 'Various Foods'}</p>
                        <span class="vendor-status ${vendor.open ? 'vendor-open' : 'vendor-closed'}">
                            ${vendor.open ? 'Open Now' : 'Closed'}
                        </span>
                    </div>
                `;
                
                // Add click event listener
                vendorCard.addEventListener('click', () => {
                    window.location.href = `vendor.php?id=${vendor.vendorId}`;
                });
                
                // Append to slider
                vendorsSlider.appendChild(vendorCard);
            });
            
            // If no vendors were loaded, show a message
            if (popularVendors.length === 0) {
                vendorsSlider.innerHTML = '<p style="width: 100%; text-align: center; padding: 20px;">No vendors available at the moment.</p>';
            }
        }
    });
</script>

<?php include 'footer.php'; ?> 