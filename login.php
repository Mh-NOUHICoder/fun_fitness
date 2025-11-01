<?php 
include('assets/include/config.php');

$error_message = '';

if (isset($_POST["btn_login"])){
    // Basic sanitization (better to use prepared statements)
    $loginname = trim(htmlspecialchars($_POST["login_name"]));
    $pwd = trim(htmlspecialchars($_POST["pwd_login"]));

    // Query with prepared statement (strongly recommended)
    $stmt = $cnx->prepare("SELECT * FROM `users` WHERE login = ? AND pwd = ?");
    $stmt->execute([$loginname, $pwd]);
    
    if($stmt->rowCount() > 0){
        header("location:pages/dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Log in or create an account for Fast Fit Gym Portal">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Fast Fit Gym Portal</title>
    <link rel="shortcut icon" type="image/png" href="assets/IMAGES/logo-icon.png">
    <style>
        :root {
            --primary: #4e54c8;
            --secondary: #00c9a7;
            --accent: #ff6b6b;
            --dark: #121826;
            --darker: #0a0e15;
            --light: #f0f5ff;
            --gray: #2a3349;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--darker), var(--dark));
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--light);
        }

        .portal-container {
            width: 100%;
            max-width: 900px;
            background: rgba(22, 25, 40, 0.95);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .portal-header {
            padding: 30px;
            text-align: center;
            background: rgba(18, 22, 37, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand-logo {
            max-width: 150px;
            margin-bottom: 10px;
            transition: var(--transition);
        }

        .portal-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--primary);
        }

        .portal-subtitle {
            color: #a0aec0;
            font-size: 1rem;
            max-width: 500px;
            margin: 0 auto;
            font-weight: 300;
        }

        .toggle-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .toggle-button {
            padding: 12px 30px;
            background: transparent;
            color: var(--light);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
        }

        .toggle-button.active {
            background: var(--primary);
            color: var(--dark);
            border-color: var(--primary);
        }

        .toggle-button:hover:not(.active) {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary);
        }

        .form-section {
            padding: 30px;
        }

        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-header h2 {
            font-size: 1.8rem;
            color: var(--light);
            font-weight: 600;
        }

        .form-header p {
            color: #a0aec0;
            font-size: 0.95rem;
            margin-top: 5px;
        }

        .alert {
            padding: 15px;
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.4);
            color: #f8d7da;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
            animation: slideIn 0.5s ease;
        }

        .success {
            background: rgba(0, 201, 167, 0.2);
            border: 1px solid rgba(0, 201, 167, 0.4);
            color: #d4ffea;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        /* Left side icons (user, lock, at) */
        .form-group i.fa-user,
        .form-group i.fa-lock,
        .form-group i.fa-at {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            font-size: 1.1rem;
            z-index: 2;
        }

        .form-input {
            width: 100%;
            padding: 14px 45px 14px 45px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: var(--light);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-input:focus {
            border-color: var(--primary);
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 0 3px rgba(0, 201, 167, 0.2);
        }

        .form-input:focus + i.fa-user,
        .form-input:focus + i.fa-lock,
        .form-input:focus + i.fa-at {
            color: var(--primary);
        }

        .form-input::placeholder {
            color: #718096;
            font-weight: 300;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #718096;
            transition: var(--transition);
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-link:hover {
            text-decoration: underline;
            color: var(--light);
        }

        .form-button {
            padding: 14px 30px;
            background: var(--primary);
            color: var(--dark);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
        }

        .form-button:hover {
            background: var(--primary);
            color: var(--light);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .portal-container {
                margin: 20px;
            }

            .toggle-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .toggle-button {
                width: 100%;
            }

            .form-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .form-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="portal-container">
        <div class="portal-header">
            <img src="assets/IMAGES/fast-fit.png" alt="Fast Fit Gym Logo" class="brand-logo">
            <h1 class="portal-title">Fast Fit Gym Portal</h1>
            <p class="portal-subtitle">Your journey to fitness starts here! Log in or create an account.</p>
        </div>

        <div class="toggle-buttons">
            <button class="toggle-button active" id="signin-toggle">Sign In</button>
            <button class="toggle-button" id="signup-toggle">Create Account</button>
        </div>

        <div class="form-section">
            <!-- Sign In Form -->
            <div class="form-container signin-container active">
                <div class="form-header">
                    <h2>Welcome Back!</h2>
                    <p>Access your fitness dashboard</p>
                </div>

                <?php if ($error_message): ?>
                    <div class="alert"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>

                <form method="post" id="signin-form" novalidate>
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="login_name" placeholder="Username" class="form-input" required 
                               aria-label="Username" autocomplete="username">
                    </div>

                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="pwd_login" placeholder="Password" class="form-input" required 
                               aria-label="Password" autocomplete="current-password" id="signin-password">
                        <i class="fas fa-eye password-toggle" id="signin-password-toggle"></i>
                    </div>

                    <div class="form-footer">
                        <a href="#" class="form-link">Forgot Password?</a>
                        <button type="submit" name="btn_login" class="form-button">Sign In</button>
                    </div>
                </form>
            </div>

            <!-- Sign Up Form -->
            <div class="form-container signup-container">
                <div class="form-header">
                    <h2>Join Our Community</h2>
                    <p>Create your account to start your fitness journey</p>
                </div>

                <form method="post" action="assets/include/script.php" id="signup-form" novalidate>
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" placeholder="Full Name" class="form-input" required 
                               aria-label="Full Name" autocomplete="name">
                    </div>

                    <div class="form-group">
                        <i class="fas fa-at"></i>
                        <input type="text" name="login" placeholder="Username" class="form-input" required 
                               aria-label="Username" autocomplete="username">
                    </div>

                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="pwd" placeholder="Password" class="form-input" required 
                               aria-label="Password" autocomplete="new-password" id="signup-password">
                        <i class="fas fa-eye password-toggle" id="signup-password-toggle"></i>
                    </div>

                    <div class="form-footer">
                        <a href="#" class="form-link">Privacy Policy</a>
                        <button type="submit" name="btn_ajouter_user" class="form-button">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const signinToggle = document.getElementById('signin-toggle');
            const signupToggle = document.getElementById('signup-toggle');
            const signinForm = document.querySelector('.signin-container');
            const signupForm = document.querySelector('.signup-container');

            // Toggle between sign in and sign up
            signinToggle.addEventListener('click', () => {
                signinToggle.classList.add('active');
                signupToggle.classList.remove('active');
                signinForm.classList.add('active');
                signupForm.classList.remove('active');
            });

            signupToggle.addEventListener('click', () => {
                signupToggle.classList.add('active');
                signinToggle.classList.remove('active');
                signupForm.classList.add('active');
                signinForm.classList.remove('active');
            });

            // Password visibility toggle
            const togglePassword = (inputId, toggleId) => {
                const input = document.getElementById(inputId);
                const toggle = document.getElementById(toggleId);
                toggle.addEventListener('click', () => {
                    const type = input.type === 'password' ? 'text' : 'password';
                    input.type = type;
                    toggle.classList.toggle('fa-eye');
                    toggle.classList.toggle('fa-eye-slash');
                });
            };

            togglePassword('signin-password', 'signin-password-toggle');
            togglePassword('signup-password', 'signup-password-toggle');

            // Form validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    const inputs = form.querySelectorAll('.form-input');
                    let valid = true;

                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            valid = false;
                            input.classList.add('error');
                            input.style.borderColor = 'var(--accent)';
                        } else {
                            input.classList.remove('error');
                            input.style.borderColor = '';
                        }
                    });

                    if (!valid) {
                        e.preventDefault();
                        const alert = document.createElement('div');
                        alert.className = 'alert';
                        alert.textContent = 'Please fill in all fields';
                        form.insertBefore(alert, form.firstChild);
                        setTimeout(() => alert.remove(), 3000);
                    }
                });
            });

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 4000);
            });
        });
    </script>
</body>
</html>