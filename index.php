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
    
</head>
<body>
    <!-- Header & Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark  fixed-top">
        <div class="container-narrow">
            <a class="navbar-brand" href="#">
                <img src="assets/IMAGES/fast-fit.png" alt="Fast Fit Gym">
            </a><br>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
                        <a class="nav-link" href="#schedule">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Memberships</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
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
        <a href="#features" class="scroll-down">
            <i class="fas fa-chevron-down fa-2x"></i>
        </a>
    </section>

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
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <h3 class="feature-title">Premium Equipment</h3>
                    <p>State-of-the-art machines and free weights for every type of workout.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Expert Trainers</h3>
                    <p>Certified professionals to guide you through personalized training programs.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="feature-title">Flexible Schedule</h3>
                    <p>Classes available throughout the day to fit your busy lifestyle.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 class="feature-title">Results-Driven</h3>
                    <p>Proven programs designed to help you achieve your fitness goals.</p>
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
                    <img src="assets/IMAGES/crossfit-training.jpg" alt="Crossfit Training">
                    <div class="class-overlay">
                        <h3 class="class-title">Crossfit Training</h3>
                        <p>High-intensity functional training program.</p>
                        <div class="class-meta">
                            <i class="fas fa-clock"></i>
                            <span>60 min</span>
                        </div>
                    </div>
                </div>
                
                <div class="class-card">
                    <img src="assets/IMAGES/fit-training.jpg" alt="Fitness Training">
                    <div class="class-overlay">
                        <h3 class="class-title">Fitness Training</h3>
                        <p>Comprehensive full-body workouts for all levels.</p>
                        <div class="class-meta">
                            <i class="fas fa-clock"></i>
                            <span>45 min</span>
                        </div>
                    </div>
                </div>
                
                <div class="class-card">
                    <img src="assets/IMAGES/weight-training.jpg" alt="Weight Lifting">
                    <div class="class-overlay">
                        <h3 class="class-title">Weight Lifting</h3>
                        <p>Build strength and muscle with expert guidance.</p>
                        <div class="class-meta">
                            <i class="fas fa-clock"></i>
                            <span>60 min</span>
                        </div>
                    </div>
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
                                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=200&q=80" alt="Sarah Johnson">
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
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=200&q=80" alt="Michael Chen">
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

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container-narrow">
            <div class="footer-grid">
                <div>
                    <img src="assets/IMAGES/fast-fit.png" alt="Fast Fit" width="160" class="mb-3">
                    <p>Transform your body, transform your life with Fast Fit Gym. Premium fitness experience since 2010.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="footer-title">Quick Links</h4>
                    <div class="footer-links">
                        <a href="#">Home</a>
                        <a href="pages/classes.php">Classes</a>
                        <a href="#">Schedule</a>
                        <a href="pages/memberships.php">Memberships</a>
                        <a href="pages/pricing.php">Pricing</a>
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
                    <div id="schedule" class="footer-links">
                        <p><strong>Monday - Friday:</strong> 5:00 AM - 11:00 PM</p>
                        <p><strong>Saturday - Sunday:</strong> 7:00 AM - 9:00 PM</p>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 Fast Fit Gym. All rights reserved. Designed with <i class="fas fa-heart" style="color: var(--primary);"></i></p>
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
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Video autoplay for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.querySelector('.hero-video');
            if (video) {
                video.muted = true;
                video.play().catch(error => {
                    // Autoplay was prevented, show a play button
                });
            }
        });
    </script>
</body>
</html>