<?php include("assets/INCLUDE/config.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Fit Gym | Premium Fitness Experience</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="shortcut icon" type="x-icon" href="assets/IMAGES/logo-icon.png">
    <link rel="stylesheet" href="assets/CSS/index.css">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="assets/IMAGES/bg-video2.mp4" as="video">
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>
<body>

    <!-- Header & Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-narrow">
            <a class="navbar-brand" href="#">
                <img src="assets/IMAGES/fast-fit.png" alt="Fast Fit Gym" loading="lazy">
            </a><br>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#classes">Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#schedule-preview">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Memberships</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Others
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#features">About Us</a></li>
                            <li><a class="dropdown-item" href="#contact">Contact Us</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <video class="hero-video" autoplay loop muted playsinline>
            <source src="assets/IMAGES/bg-video2.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-overlay"></div>
        <div class="container-narrow">
            <div class="hero-content">
                <h1 class="hero-title">Bring out the <span>athlete in you</span></h1>
                <p class="hero-subtitle">Transform your body, transform your life with our expert trainers and state-of-the-art facilities.</p>
                <div class="cta-buttons">
                    <a href="login.php" class="btn btn-primary">Sign In</a>
                    <a href="register.php" class="btn btn-outline">Join With Us</a>
                </div>
            </div>
        </div>
        <a href="#features" class="scroll-down" aria-label="Scroll to features">
            <i class="fas fa-chevron-down fa-2x"></i>
        </a>
    </section>

    <!-- Main Content -->
    <main id="main-content">
        <!-- Features Section -->
        <section id="features" class="section features-section">
            <div class="container-narrow">
                <div class="text-center mb-5">
                    <h2>Why Choose Fast Fit</h2>
                    <p class="mx-auto" style="max-width: 700px;">We're committed to helping you achieve your fitness goals with our premium facilities, expert trainers, and supportive community.</p>
                </div>
                
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dumbbell" aria-hidden="true"></i>
                        </div>
                        <h3 class="feature-title">Premium Equipment</h3>
                        <p>State-of-the-art machines and free weights for every type of workout.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users" aria-hidden="true"></i>
                        </div>
                        <h3 class="feature-title">Expert Trainers</h3>
                        <p>Certified professionals to guide you through personalized training programs.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        </div>
                        <h3 class="feature-title">Flexible Schedule</h3>
                        <p>Classes available throughout the day to fit your busy lifestyle.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-heartbeat" aria-hidden="true"></i>
                        </div>
                        <h3 class="feature-title">Results-Driven</h3>
                        <p>Proven programs designed to help you achieve your fitness goals.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modern Statistics Section -->
        <section class="section stats-section">
            <div class="container-narrow">
                <div class="stats-container">
                    <div class="stat-item">
                        <div class="stat-circle">
                            <span class="stat-number" data-count="5000">0</span>
                            <span class="stat-plus">+</span>
                        </div>
                        <h4 class="stat-label">Happy Members</h4>
                    </div>
                    <div class="stat-item">
                        <div class="stat-circle">
                            <span class="stat-number" data-count="50">0</span>
                            <span class="stat-plus">+</span>
                        </div>
                        <h4 class="stat-label">Expert Trainers</h4>
                    </div>
                    <div class="stat-item">
                        <div class="stat-circle">
                            <span class="stat-number" data-count="100">0</span>
                            <span class="stat-plus">+</span>
                        </div>
                        <h4 class="stat-label">Weekly Classes</h4>
                    </div>
                    <div class="stat-item">
                        <div class="stat-circle">
                            <span class="stat-number" data-count="15">0</span>
                            <span class="stat-plus">+</span>
                        </div>
                        <h4 class="stat-label">Years Experience</h4>
                    </div>
                </div>
            </div>
        </section>

        <!-- Classes Section -->
        <section id="classes" class="section classes-section">
            <div class="container-narrow">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h2>Popular Classes</h2>
                    <a href="pages/classes.php" class="btn btn-outline">View All Classes</a>
                </div>
                
                <div class="classes-grid">
                    <div class="class-card">
                        <img src="assets/IMAGES/crossfit-training.jpg" alt="Crossfit Training" loading="lazy">
                        <div class="class-overlay">
                            <h3 class="class-title">Crossfit Training</h3>
                            <p>High-intensity functional training program.</p>
                            <div class="class-meta">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                <span>60 min</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="class-card">
                        <img src="assets/IMAGES/fit-training.jpg" alt="Fitness Training" loading="lazy">
                        <div class="class-overlay">
                            <h3 class="class-title">Fitness Training</h3>
                            <p>Comprehensive full-body workouts for all levels.</p>
                            <div class="class-meta">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                <span>45 min</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="class-card">
                        <img src="assets/IMAGES/weight-training.jpg" alt="Weight Lifting" loading="lazy">
                        <div class="class-overlay">
                            <h3 class="class-title">Weight Lifting</h3>
                            <p>Build strength and muscle with expert guidance.</p>
                            <div class="class-meta">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                <span>60 min</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modern Schedule Preview Section -->
        <section id="schedule-preview" class="section schedule-section">
            <div class="container-narrow">
                <div class="section-header">
                    <h2>Today's Schedule</h2>
                    <p>Join our popular classes throughout the day</p>
                    <a href="pages/schedule.php" class="btn-link">View Full Schedule <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="schedule-cards">
                    <div class="schedule-card">
                        <div class="schedule-time">
                            <span class="time">06:00</span>
                            <span class="period">AM</span>
                        </div>
                        <div class="schedule-info">
                            <h4>Morning Yoga</h4>
                            <p>With Sarah • Studio 1</p>
                        </div>
                        <div class="schedule-badge beginner">Beginner</div>
                    </div>
                    
                    <div class="schedule-card">
                        <div class="schedule-time">
                            <span class="time">07:30</span>
                            <span class="period">AM</span>
                        </div>
                        <div class="schedule-info">
                            <h4>HIIT Training</h4>
                            <p>With Mike • Main Hall</p>
                        </div>
                        <div class="schedule-badge intermediate">Intermediate</div>
                    </div>
                    
                    <div class="schedule-card">
                        <div class="schedule-time">
                            <span class="time">12:00</span>
                            <span class="period">PM</span>
                        </div>
                        <div class="schedule-info">
                            <h4>Lunchtime Core</h4>
                            <p>With Emily • Studio 2</p>
                        </div>
                        <div class="schedule-badge all-levels">All Levels</div>
                    </div>
                    
                    <div class="schedule-card">
                        <div class="schedule-time">
                            <span class="time">18:00</span>
                            <span class="period">PM</span>
                        </div>
                        <div class="schedule-info">
                            <h4>Evening Crossfit</h4>
                            <p>With John • Crossfit Area</p>
                        </div>
                        <div class="schedule-badge advanced">Advanced</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modern Brands Section -->
        <section class="section brands-section">
            <div class="container-narrow">
                <div class="section-header text-center">
                    <h3>Trusted By Industry Leaders</h3>
                </div>
                <div class="brands-grid">
                    <div class="brand-logo">
                        <i class="fas fa-award"></i>
                        <span>Fitness Awards 2023</span>
                    </div>
                    <div class="brand-logo">
                        <i class="fas fa-shield-alt"></i>
                        <span>Certified Excellence</span>
                    </div>
                    <div class="brand-logo">
                        <i class="fas fa-heart"></i>
                        <span>Wellness Partner</span>
                    </div>
                    <div class="brand-logo">
                        <i class="fas fa-star"></i>
                        <span>Top Rated Gym</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="section testimonials-section">
            <div class="container-narrow">
                <div class="text-center mb-5">
                    <h2>Success Stories</h2>
                    <p class="mx-auto" style="max-width: 700px;">Hear from our members who have transformed their lives with Fast Fit.</p>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <p class="testimonial-text">"Joining Fast Fit was the best decision I've made for my health. The trainers are incredibly knowledgeable and the community is so supportive!"</p>
                                <div class="testimonial-author">
                                    <div class="author-img">
                                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=200&q=80" alt="Sarah Johnson" loading="lazy">
                                    </div>
                                    <div class="author-info">
                                        <h4>Sarah Johnson</h4>
                                        <p>Member for 2 years</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <p class="testimonial-text">"The personalized training program helped me lose 30 pounds and completely transform my body. I've never felt better!"</p>
                                <div class="testimonial-author">
                                    <div class="author-img">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=200&q=80" alt="Michael Chen" loading="lazy">
                                    </div>
                                    <div class="author-info">
                                        <h4>Michael Chen</h4>
                                        <p>Member for 1 year</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="section pricing-section">
            <div class="container-narrow">
                <div class="text-center mb-5">
                    <h2>Choose Your Plan</h2>
                    <p class="mx-auto" style="max-width: 700px;">Flexible membership options designed to fit your lifestyle and fitness goals. All plans include access to premium equipment and facilities.</p>
                </div>
                
                <div class="row justify-content-center">
                    <!-- Basic Plan -->
                    <div class="col-md-4 mb-4">
                        <div class="pricing-card">
                            <div class="pricing-header">
                                <h3 class="pricing-title">Basic</h3>
                                <div class="pricing-price">
                                    <span class="currency">$</span>
                                    <span class="amount">29</span>
                                    <span class="period">/month</span>
                                </div>
                                <p class="pricing-description">Perfect for beginners</p>
                            </div>
                            <div class="pricing-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Access to gym facilities</li>
                                    <li><i class="fas fa-check"></i> Locker room access</li>
                                    <li><i class="fas fa-check"></i> Free weights area</li>
                                    <li><i class="fas fa-times"></i> Group classes</li>
                                    <li><i class="fas fa-times"></i> Personal trainer sessions</li>
                                    <li><i class="fas fa-times"></i> Pool & sauna access</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="register.php" class="btn btn-outline w-100">Get Started</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pro Plan (Featured) -->
                    <div class="col-md-4 mb-4">
                        <div class="pricing-card featured">
                            <div class="popular-badge">MOST POPULAR</div>
                            <div class="pricing-header">
                                <h3 class="pricing-title">Pro</h3>
                                <div class="pricing-price">
                                    <span class="currency">$</span>
                                    <span class="amount">49</span>
                                    <span class="period">/month</span>
                                </div>
                                <p class="pricing-description">Our most popular plan</p>
                            </div>
                            <div class="pricing-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Everything in Basic</li>
                                    <li><i class="fas fa-check"></i> All group classes included</li>
                                    <li><i class="fas fa-check"></i> Pool & sauna access</li>
                                    <li><i class="fas fa-check"></i> 2 personal trainer sessions/month</li>
                                    <li><i class="fas fa-check"></i> Nutritional guidance</li>
                                    <li><i class="fas fa-times"></i> Premium locker</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="register.php" class="btn btn-primary w-100">Get Started</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Elite Plan -->
                    <div class="col-md-4 mb-4">
                        <div class="pricing-card">
                            <div class="pricing-header">
                                <h3 class="pricing-title">Elite</h3>
                                <div class="pricing-price">
                                    <span class="currency">$</span>
                                    <span class="amount">79</span>
                                    <span class="period">/month</span>
                                </div>
                                <p class="pricing-description">Ultimate fitness experience</p>
                            </div>
                            <div class="pricing-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Everything in Pro</li>
                                    <li><i class="fas fa-check"></i> Unlimited personal trainer sessions</li>
                                    <li><i class="fas fa-check"></i> Premium locker included</li>
                                    <li><i class="fas fa-check"></i> Guest passes (2/month)</li>
                                    <li><i class="fas fa-check"></i> Advanced body composition analysis</li>
                                    <li><i class="fas fa-check"></i> 24/7 gym access</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="register.php" class="btn btn-outline w-100">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-muted">All plans include a 7-day free trial. No long-term contracts. Cancel anytime.</p>
                </div>
            </div>
        </section>

        <!-- Modern Mobile App Section -->
        <section class="section app-section">
            <div class="container-narrow">
                <div class="app-container">
                    <div class="app-content">
                        <h2>Fast Fit Mobile App</h2>
                        <p class="app-description">Track your progress, book classes, and connect with trainers. Everything you need for your fitness journey in one app.</p>
                        <div class="app-features">
                            <div class="app-feature">
                                <i class="fas fa-calendar-check"></i>
                                <span>Class Booking</span>
                            </div>
                            <div class="app-feature">
                                <i class="fas fa-chart-line"></i>
                                <span>Progress Tracking</span>
                            </div>
                            <div class="app-feature">
                                <i class="fas fa-dumbbell"></i>
                                <span>Workout Plans</span>
                            </div>
                            <div class="app-feature">
                                <i class="fas fa-users"></i>
                                <span>Trainer Connect</span>
                            </div>
                        </div>
                        <div class="app-download">
                            <a href="#" class="download-btn">
                                <i class="fab fa-apple"></i>
                                <div>
                                    <span>Download on the</span>
                                    <strong>App Store</strong>
                                </div>
                            </a>
                            <a href="#" class="download-btn">
                                <i class="fab fa-google-play"></i>
                                <div>
                                    <span>Get it on</span>
                                    <strong>Google Play</strong>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="app-visual">
                        <div class="phone-mockup">
                            <div class="phone-screen">
                                <div class="app-interface">
                                    <div class="app-header">
                                        <span>Fast Fit</span>
                                        <i class="fas fa-bolt"></i>
                                    </div>
                                    <div class="app-stats">
                                        <div class="stat">
                                            <strong>12</strong>
                                            <span>Workouts</span>
                                        </div>
                                        <div class="stat">
                                            <strong>8h</strong>
                                            <span>Training</span>
                                        </div>
                                        <div class="stat">
                                            <strong>95%</strong>
                                            <span>Consistency</span>
                                        </div>
                                    </div>
                                    <div class="next-class">
                                        <h4>Next Class</h4>
                                        <p>Yoga Flow • 6:00 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section cta-section">
            <div class="container-narrow">
                <div class="cta-content">
                    <h2>Start Your Fitness Journey Today</h2>
                    <p class="mb-4">We know starting a fitness routine can be tough, but we're here to help you see fitness in a new way. We believe healthy habits lead to a healthy lifestyle, and we're here to support you on that journey!</p>
                    <a href="register.php" class="btn btn-primary">Join Now</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container-narrow">
            <div class="footer-grid">
                <div>
                    <img src="assets/IMAGES/fast-fit.png" alt="Fast Fit" width="160" class="mb-3" loading="lazy">
                    <p>Transform your body, transform your life with Fast Fit Gym. Premium fitness experience since 2010.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="footer-title">Quick Links</h4>
                    <div class="footer-links">
                        <a href="#hero">Home</a>
                        <a href="pages/classes.php">Classes</a>
                        <a href="#schedule-preview">Schedule</a>
                        <a href="#pricing">Memberships</a>
                        <a href="#pricing">Pricing</a>
                    </div>
                </div>
                
                <div>
                    <h4 class="footer-title">Contact Us</h4>
                    <div class="footer-links">
                        <a href="#"><i class="fas fa-map-marker-alt me-2"></i> 123 Fitness St, New York</a>
                        <a href="tel:+11234567890"><i class="fas fa-phone me-2"></i> +1 (123) 456-7890</a>
                        <a href="mailto:info@fastfitgym.com"><i class="fas fa-envelope me-2"></i> info@fastfitgym.com</a>
                    </div>
                </div>
                
                <div>
                    <h4 class="footer-title">Opening Hours</h4>
                    <div class="footer-links">
                        <p><strong>Monday - Friday:</strong> 5:00 AM - 11:00 PM</p>
                        <p><strong>Saturday - Sunday:</strong> 7:00 AM - 9:00 PM</p>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 Fast Fit Gym. All rights reserved. Designed with <i class="fas fa-heart" style="color: var(--primary);" aria-hidden="true"></i></p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Update active nav link on scroll
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.nav-link');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollY >= (sectionTop - 100)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
        
        // Video autoplay for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.querySelector('.hero-video');
            if (video) {
                video.muted = true;
                video.play().catch(error => {
                    console.log('Video autoplay prevented:', error);
                });
            }
        });

        // Animated counter for statistics
        function animateCounter() {
            const counters = document.querySelectorAll('.stat-number');
            const speed = 200;

            counters.forEach(counter => {
                const target = +counter.getAttribute('data-count');
                const count = +counter.innerText;
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animateCounter, 1);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            });
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    if (entry.target.classList.contains('stats-section')) {
                        animateCounter();
                    }
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.addEventListener('DOMContentLoaded', function() {
            const elementsToAnimate = document.querySelectorAll('.feature-card, .class-card, .pricing-card, .schedule-card, .testimonial-card, .brand-logo, .app-feature');
            elementsToAnimate.forEach(el => observer.observe(el));
            
            // Observe stats section
            const statsSection = document.querySelector('.stats-section');
            if (statsSection) observer.observe(statsSection);
        });

        // Skip navigation functionality
        document.querySelector('.skip-nav').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#main-content').scrollIntoView({
                behavior: 'smooth'
            });
            document.querySelector('#main-content').setAttribute('tabindex', '-1');
            document.querySelector('#main-content').focus();
        });
    </script>
</body>
</html>