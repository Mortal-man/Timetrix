<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetrix</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --academic-blue: #002147;
            --tech-teal: #00c1d4;
            --slate-gray: #2d3b45;
            --ivory-white: #f9f9f9;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        body {
            background: var(--academic-blue);
            color: var(--ivory-white);
            line-height: 1.6;
        }
        .header-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--tech-teal) 0%, var(--academic-blue) 100%);
        }
        header {
            padding: 1.5rem 5%;
            background: rgba(0,33,71,0.95);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(0,193,212,0.1);
        }
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            width: 160px;
            transition: transform 0.3s;
        }
        .logo:hover {
            transform: scale(1.05);
        }
        .nav-links a {
            margin-left: 1.5rem;
            padding: 0.75rem 1.5rem;
            background: rgba(0,193,212,0.1);
            color: var(--tech-teal);
            border-radius: 4px;
            border: 1px solid rgba(0,193,212,0.3);
            transition: all 0.3s;
            text-decoration: none;
        }
        .nav-links a:hover {
            background: var(--tech-teal);
            color: var(--academic-blue);
        }
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 5%;
        }
        .hero {
            padding: 4rem 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: var(--tech-teal);
        }
        .hero p {
            font-size: 1.25rem;
            max-width: 800px;
            margin: 0 auto 3rem;
            color: #c0c0c0;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
        }
        .feature-card {
            padding: 2rem;
            background: rgba(45,59,69,0.8);
            border-radius: 8px;
            border-left: 4px solid var(--tech-teal);
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: var(--tech-teal);
            margin-bottom: 1rem;
        }
        .cta-section {
            text-align: center;
            padding: 4rem 0;
            margin: 4rem 0;
            background: rgba(45,59,69,0.6);
            border-radius: 8px;
        }
        .cta-button {
            display: inline-flex;
            align-items: center;
            padding: 1rem 2.5rem;
            background: var(--tech-teal);
            color: var(--academic-blue) !important;
            font-weight: 600;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,193,212,0.4);
        }
        /* Policy Pages Styles */
        .policy-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background: rgba(45,59,69,0.8);
            border-radius: 8px;
            border-left: 4px solid var(--tech-teal);
        }
        .policy-container h1 {
            color: var(--tech-teal);
            margin-bottom: 2rem;
            font-size: 2.5rem;
        }
        .policy-container h2 {
            color: var(--tech-teal);
            margin: 1.5rem 0 1rem;
            font-size: 1.5rem;
        }
        .policy-container p, .policy-container ul {
            margin-bottom: 1rem;
            color: #c0c0c0;
        }
        .policy-container ul {
            padding-left: 1.5rem;
        }
        .back-button {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.75rem 1.5rem;
            background: var(--tech-teal);
            color: var(--academic-blue);
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
        }
        /* Contact Form Styles */
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--tech-teal);
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(0,193,212,0.3);
            border-radius: 4px;
            color: var(--ivory-white);
        }
        .form-group textarea {
            min-height: 150px;
        }
        .submit-button {
            background: var(--tech-teal);
            color: var(--academic-blue);
            padding: 1rem 2rem;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,193,212,0.3);
        }
        footer {
            padding: 3rem 5%;
            background: rgba(0,33,71,0.95);
            border-top: 1px solid rgba(0,193,212,0.1);
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .credits {
            color: var(--tech-teal);
        }
        .footer-links a {
            margin-left: 1.5rem;
            color: #a0a0a0;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            color: var(--tech-teal);
        }
        @media (max-width: 768px) {
            .header-container, .footer-content {
                flex-direction: column;
                text-align: center;
            }
            .nav-links, .footer-links {
                margin-top: 1.5rem;
            }
            .nav-links a, .footer-links a {
                margin: 0.5rem;
            }
            .hero h1 {
                font-size: 2rem;
            }
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="header-bar"></div>

<header>
    <div class="header-container">
        <img class="logo" src="{{ asset('favicon/favicon_512x512_Nero_AI_Image_Upscaler_Photo_Face-Photoroom.png') }}" alt="Timetrix">
        <nav class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                @else
                    <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a>
                    @endif
                @endauth
            @endif
        </nav>
    </div>
</header>

<main>
    <!-- Main Home Content (shown by default) -->
    <div id="home-content">
        <section class="hero">
            <h1> TIMETRIX </h1>
            <p>Optimize university timetables with optimized algorithm-powered precision. Reduce conflicts, maximize resources, and streamline operations.</p>
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3>Intelligent Scheduling</h3>
                    <p>Automatically generate conflict-free timetables based on institutional constraints and preferences.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <h3>Faculty Management</h3>
                    <p>Track professor availability, preferences, and workload distribution across departments.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-door-open"></i></div>
                    <h3>Room Optimization</h3>
                    <p>Smart classroom allocation based on course requirements and campus locations.</p>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2>Ready to Transform Your Institution's Scheduling?</h2>
            <p>Join leading universities using Timetrix to save hundreds of administrative hours each semester.</p>
            <a href="{{ route('register') }}" class="cta-button">
                <i class="fas fa-calendar-check"></i> Get Started
            </a>
        </section>
    </div>

    <!-- Privacy Policy Content (hidden by default) -->
    <div id="privacy-content" style="display: none;">
        <div class="policy-container">
            <h1><i class="fas fa-shield-alt"></i> Privacy Policy</h1>

            <p>Last Updated: January 2025</p>

            <h2>1. Information We Collect</h2>
            <p>Timetrix collects information necessary to provide our academic scheduling services, including:</p>
            <ul>
                <li>Institutional information (university name, departments, programs)</li>
                <li>Course and curriculum data</li>
                <li>Faculty and staff contact information</li>
                <li>User account credentials</li>
                <li>System usage data</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <p>We use collected data to:</p>
            <ul>
                <li>Generate and optimize academic schedules</li>
                <li>Provide personalized user experiences</li>
                <li>Improve our services</li>
                <li>Communicate important service updates</li>
                <li>Ensure system security</li>
            </ul>

            <h2>3. Data Protection</h2>
            <p>We implement industry-standard security measures including:</p>
            <ul>
                <li>Encryption of sensitive data</li>
                <li>Regular security audits</li>
                <li>Access controls</li>
                <li>Secure data storage</li>
            </ul>

            <h2>4. Third-Party Services</h2>
            <p>We may use trusted third-party services for:</p>
            <ul>
                <li>Hosting and infrastructure</li>
                <li>Analytics</li>
                <li>Customer support</li>
            </ul>

            <a href="#" class="back-button" onclick="showHome()"><i class="fas fa-arrow-left"></i> Back to Home</a>
        </div>
    </div>

    <!-- Terms of Service Content (hidden by default) -->
    <div id="terms-content" style="display: none;">
        <div class="policy-container">
            <h1><i class="fas fa-file-contract"></i> Terms of Service</h1>

            <p>Effective Date: January 2025</p>

            <h2>1. Acceptance of Terms</h2>
            <p>By accessing or using Timetrix, you agree to be bound by these Terms of Service.</p>

            <h2>2. Service Description</h2>
            <p>Timetrix provides academic scheduling software designed for higher education institutions.</p>

            <h2>3. User Responsibilities</h2>
            <p>Users agree to:</p>
            <ul>
                <li>Provide accurate institutional information</li>
                <li>Maintain confidentiality of login credentials</li>
                <li>Use the service only for lawful purposes</li>
                <li>Not attempt to reverse engineer the software</li>
            </ul>

            <h2>4. Intellectual Property</h2>
            <p>All software, content, and trademarks are property of Timetrix Academic Solutions.</p>

            <h2>5. Limitation of Liability</h2>
            <p>Timetrix shall not be liable for any indirect, incidental, or consequential damages arising from use of the service.</p>

            <h2>6. Modifications</h2>
            <p>We reserve the right to modify these terms at any time. Continued use constitutes acceptance of changes.</p>

            <a href="#" class="back-button" onclick="showHome()"><i class="fas fa-arrow-left"></i> Back to Home</a>
        </div>
    </div>

    <!-- Contact Us Content (hidden by default) -->
    <div id="contact-content" style="display: none;">
        <div class="policy-container">
            <h1><i class="fas fa-envelope"></i> Contact Us</h1>

            <form id="contactForm" method="POST">
                <div class="contact-form">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="institution">Institution</label>
                        <input type="text" id="institution" name="institution" placeholder="Your university or college">
                    </div>

                    <div class="form-group">
                        <label for="role">Your Role</label>
                        <select id="role" name="role">
                            <option value="">Select your role</option>
                            <option value="administrator">Administrator</option>
                            <option value="faculty">Faculty Member</option>
                            <option value="it">IT Staff</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="How can we help you?" required></textarea>
                    </div>

                    <div id="formFeedback" style="margin: 1rem 0; color: var(--tech-teal); display: none;"></div>

                    <button type="submit" class="submit-button"><i class="fas fa-paper-plane"></i> Send Message</button>
                </div>
            </form>

            <!-- Rest of your contact content remains the same -->
            <div style="margin-top: 3rem;">
                <h2><i class="fas fa-map-marker-alt"></i> Our Office</h2>
                <p>Timetrix Academic Solutions<br>
                    Nairobi, Kenya</p>

                <h2><i class="fas fa-phone"></i> Phone</h2>
                <p>+254 795 719572</p>

                <h2><i class="fas fa-at"></i> Email</h2>
                <p>ottimanuel714@gmail.com</p>
            </div>

            <a href="#" class="back-button" onclick="showHome()"><i class="fas fa-arrow-left"></i> Back to Home</a>
        </div>
    </div>
</main>

<footer>
    <div class="footer-content">
        <div class="credits">
            <p>Developed by Emmanuel Oduor<br>© 2025 Timetrix Academic Solutions</p>
        </div>
        <nav class="footer-links">
            <a href="#" onclick="showPrivacy()"><i class="fas fa-shield-alt"></i> Privacy</a>
            <a href="#" onclick="showTerms()"><i class="fas fa-file-contract"></i> Terms</a>
            <a href="#" onclick="showContact()"><i class="fas fa-envelope"></i> Contact</a>
        </nav>
    </div>
</footer>

<script>
    // Simple page navigation functions
    function showHome() {
        document.getElementById('home-content').style.display = 'block';
        document.getElementById('privacy-content').style.display = 'none';
        document.getElementById('terms-content').style.display = 'none';
        document.getElementById('contact-content').style.display = 'none';
        window.scrollTo(0, 0);
    }

    function showPrivacy() {
        document.getElementById('home-content').style.display = 'none';
        document.getElementById('privacy-content').style.display = 'block';
        document.getElementById('terms-content').style.display = 'none';
        document.getElementById('contact-content').style.display = 'none';
        window.scrollTo(0, 0);
    }

    function showTerms() {
        document.getElementById('home-content').style.display = 'none';
        document.getElementById('privacy-content').style.display = 'none';
        document.getElementById('terms-content').style.display = 'block';
        document.getElementById('contact-content').style.display = 'none';
        window.scrollTo(0, 0);
    }

    function showContact() {
        document.getElementById('home-content').style.display = 'none';
        document.getElementById('privacy-content').style.display = 'none';
        document.getElementById('terms-content').style.display = 'none';
        document.getElementById('contact-content').style.display = 'block';
        window.scrollTo(0, 0);
    }

    // Handle initial page load with hash
    window.onload = function() {
        if (window.location.hash === '#privacy') {
            showPrivacy();
        } else if (window.location.hash === '#terms') {
            showTerms();
        } else if (window.location.hash === '#contact') {
            showContact();
        }
    };
</script>
<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const feedback = document.getElementById('formFeedback');

        // Show loading state
        feedback.style.display = 'block';
        feedback.textContent = 'Sending your message...';
        feedback.style.color = 'var(--tech-teal)';

        fetch('send_email.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    feedback.textContent = 'Message sent successfully!';
                    feedback.style.color = 'green';
                    form.reset();
                } else {
                    feedback.textContent = 'Error: ' + data.message;
                    feedback.style.color = 'red';
                }
            })
            .catch(error => {
                feedback.textContent = 'Network error. Please try again later.';
                feedback.style.color = 'red';
                console.error('Error:', error);
            });
    });
</script>
</body>
</html>
